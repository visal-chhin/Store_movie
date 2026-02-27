<?php
include '../config/storedata.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* RECOVER MOVIE */
if (isset($_GET['recover'])) {
    $id = $_GET['recover'];
    $conn->query("UPDATE movies SET is_deleted=0 WHERE id=$id");
    header("Location: delete_movie.php");
    exit;
}

/* FETCH DELETED MOVIES */
$result = $conn->query("SELECT * FROM movies WHERE is_deleted=1");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deleted Movies - Recovery</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; padding: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: #ecf0f1; }
        .recover-btn {
            background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 4px;
            cursor: pointer;
        }
        .recover-btn:hover { background: #218838; }
        .back { text-decoration: none; color: #007bff; margin-bottom: 15px; display: inline-block; }
    </style>
</head>
<body>

<a href="manager_admin.php" class="back">← Back to Manager</a>

<h2>Deleted Movies - Recovery</h2>

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
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['people_buy'] ?></td>
        <td><?= $row['people_save'] ?></td>
        <td><?= $row['people_watch'] ?></td>
        <td>
            <a href="?recover=<?= $row['id'] ?>">
                <button class="recover-btn">Recover</button>
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>