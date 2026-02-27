<?php
include '../config/storedata.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* DELETE MOVIE: mark as deleted */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("UPDATE movies SET is_deleted=1 WHERE id=$id");
    header("Location: manager_admin.php"); // reload page
    exit;
}

/* EDIT MOVIE */
if (isset($_POST['edit_movie'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE movies SET title=?, price=? WHERE id=?");
    $stmt->bind_param("sdi", $title, $price, $id);
    $stmt->execute();
    $stmt->close();
}

/* TOTAL COUNTERS */
$total_result = $conn->query("
    SELECT 
    SUM(people_buy) AS total_buy, 
    SUM(people_save) AS total_save, 
    SUM(people_watch) AS total_watch 
    FROM movies
");
$totals = $total_result->fetch_assoc();

/* FETCH MOVIES (only not deleted) */
$result = $conn->query("SELECT * FROM movies WHERE is_deleted=0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Admin - Movie Store</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background: #f4f6f9;
        }

        /* NAVBAR */
        .navbar {
            width: 220px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            height: 100vh;
        }

        .navbar img { width: 100%; margin-bottom: 20px; }
        .navbar a { display: block; color: white; text-decoration: none; margin: 10px 0; padding: 8px; border-radius: 4px; }
        .navbar a:hover { background: #34495e; }

        /* CONTENT */
        .content { flex: 1; padding: 20px; }

        /* TOTAL BOXES */
        .total-container { display: flex; gap: 15px; margin-bottom: 20px; }
        .total-box { flex: 1; padding: 20px; color: white; border-radius: 8px; text-align: center; font-weight: bold; }
        .buy-box { background: #3498db; }
        .save-box { background: #27ae60; }
        .watch-box { background: #f39c12; }
        .total-number { font-size: 28px; margin-top: 10px; display: block; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: #ecf0f1; }
        input[type=text], input[type=number] { width: 80%; padding: 4px; }

        /* BUTTONS */
        .update-btn { background: #28a745; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
        .update-btn:hover { background: #218838; }
        .delete-btn { background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
        .delete-btn:hover { background: #c82333; }

        /* ADD BUTTON LINK */
        .add-movie-btn {
            padding: 10px 20px; background-color: #28a745; color: white; 
            text-decoration: none; border-radius: 5px; font-weight: bold;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <img src="https://imgs.search.brave.com/6ZtWT5f_zvu4Y-akKQRlcFTdxc7F4lSGXmu-lP5XMk8/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9hczEu/ZnRjZG4ubmV0L2pw/Zy8wMi8zNS8xNy83/Mi8xMDAwX0ZfMjM1/MTc3MjI4X3dHMWRM/bzF0Snh2WEFkclUy/eUZ4d3MyOGNhcks2/RnBzLmpwZw" alt="Logo">
    <h3>Manager Menu</h3>
    <a href="interface.php">Dashboard</a>
    <a href="add_movie.php">Add Movie</a>
    <a href="delete_movie.php">Deleted Movies</a>
    <a href="#">Reports</a>
    <a href="interface.php">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin: 20px 0;">
        <h2 style="margin: 0;">🎬 Movie Manager Admin</h2>
        <a href="add_movie.php" class="add-movie-btn">Add Movie</a>
    </div>

    <!-- TOTAL BOXES -->
    <div class="total-container">
        <div class="total-box buy-box">
            Total People Buy
            <span class="total-number"><?= $totals['total_buy'] ?? 0 ?></span>
        </div>
        <div class="total-box save-box">
            Total People Save
            <span class="total-number"><?= $totals['total_save'] ?? 0 ?></span>
        </div>
        <div class="total-box watch-box">
            Total People Watch
            <span class="total-number"><?= $totals['total_watch'] ?? 0 ?></span>
        </div>
    </div>

    <!-- MOVIE TABLE -->
    <h3>All Movies</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Price</th>
            <th>People Buy</th>
            <th>People Save</th>
            <th>People Watch</th>
            <th>Actions</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="POST">
                <td><?= $row['id'] ?></td>
                <td><input type="text" name="title" value="<?= $row['title'] ?>"></td>
                <td><input type="number" name="price" value="<?= $row['price'] ?>"></td>
                <td><?= $row['people_buy'] ?></td>
                <td><?= $row['people_save'] ?></td>
                <td><?= $row['people_watch'] ?></td>
                <td>
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" name="edit_movie" class="update-btn">Update</button>
                    <button type="button" class="delete-btn" 
                        onclick="window.location.href='manager_admin.php?delete=<?= $row['id'] ?>';">
                        Delete
                    </button>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>