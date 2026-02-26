<?php
include '../config/storedata.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Add Movie
if (isset($_POST['add_movie'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $people_buy = $_POST['people_buy'] ?? 0;
    $people_save = $_POST['people_save'] ?? 0;
    $people_watch = $_POST['people_watch'] ?? 0;

    $stmt = $conn->prepare("INSERT INTO movies (title, price, people_buy, people_save, people_watch) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiii", $title, $price, $people_buy, $people_save, $people_watch);
    $stmt->execute();
    $stmt->close();
}

// Handle Edit Movie (only title and price)
if (isset($_POST['edit_movie'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE movies SET title=?, price=? WHERE id=?");
    $stmt->bind_param("sdi", $title, $price, $id);
    $stmt->execute();
    $stmt->close();
}

// Handle Delete Movie
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM movies WHERE id=$id");
}

// Fetch all movies
$result = $conn->query("SELECT * FROM movies");

// Calculate total numbers for all movies
$total_result = $conn->query("SELECT SUM(people_buy) AS total_buy, SUM(people_save) AS total_save, SUM(people_watch) AS total_watch FROM movies");
$totals = $total_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Admin - Movie Store</title>
    <style>
        body {font-family: Arial, sans-serif; margin: 0; display: flex;}
        /* Right navbar */
        .navbar {
            width: 220px;
            background-color: #333;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .navbar img {width: 100%; margin-bottom: 20px;}
        .navbar h3 {color: #fff; margin-bottom: 10px;}
        .navbar a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin: 10px 0;
            padding: 5px 0;
            border-left: 4px solid transparent;
        }
        .navbar a:hover {border-left: 4px solid #00bfff; text-decoration: none;}
        /* Main content */
        .content {flex: 1; padding: 20px;}
        table {border-collapse: collapse; width: 100%; font-size: 12px;}
        th, td {border: 1px solid #ccc; padding: 6px; text-align: center;}
        th {background-color: #f4f4f4;}
        input[type=text], input[type=number] {width: 80%; padding: 4px;}
        button {padding: 5px 10px; margin: 2px; cursor: pointer;}
        button[name="edit_movie"] {background-color: red; color: white; border: none;}
        button[type="button"] {background-color: gray; color: white; border: none;}
        .people-buy {background-color: #cce5ff; font-weight: bold; width: 90px;}
        .people-save {font-weight: bold;}
        .people-watch {background-color: #ffd699; font-weight: bold;}
        .totals {margin: 10px 0; font-size: 16px; font-weight: bold;}
        form {margin:0;}
        .top-buttons {margin-bottom: 15px;}
        .top-buttons a {margin-right: 10px; text-decoration: none; background-color: #00bfff; color: white; padding: 6px 12px; border-radius: 4px;}
        .top-buttons a:hover {background-color: #009acd;}
    </style>
</head>
<body>
    <!-- Right Manager Navbar -->
    <div class="navbar">
        <img src="../assets/images/logo.png" alt="Logo">
        <h3>Manager Menu</h3>
        <a href="interface.php">Dashboard</a>
        <a href="add_movie.php">Add Movie</a>
        <a href="#">Reports</a>
        <a href="#">Logout</a>
    </div>

    <!-- Main content -->
    <div class="content">
        <h2>Movie Manager Admin</h2>
        <!-- Total Counters -->
        <div class="totals">
            Total People Buy: <?= $totals['total_buy'] ?? 0 ?> &nbsp;&nbsp;|&nbsp;&nbsp;
            Total People Save: <?= $totals['total_save'] ?? 0 ?> &nbsp;&nbsp;|&nbsp;&nbsp;
            Total People Watch: <?= $totals['total_watch'] ?? 0 ?>
        </div>

        <!-- Movies Table -->
        <h3>All Movies</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Price</th>
                <th class="people-buy">People Buy</th>
                <th class="people-save">People Save</th>
                <th class="people-watch">People Watch</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <form method="POST">
                    <td><?= $row['id'] ?></td>
                    <td><input type="text" name="title" value="<?= $row['title'] ?>"></td>
                    <td><input type="number" name="price" value="<?= $row['price'] ?>"></td>
                    <td class="people-buy"><?= $row['people_buy'] ?></td>
                    <td class="people-save"><?= $row['people_save'] ?></td>
                    <td class="people-watch"><?= $row['people_watch'] ?></td>
                    <td>
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="edit_movie">Save</button>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">
                            <button type="button">Delete</button>
                        </a>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>