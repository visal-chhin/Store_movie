<?php
// interface.php
include '../config/storedata.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM movies");

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🎬 Movie Store</title>
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>

<!-- Navbar -->
<nav>
    <div>
        <a href="#">🎬 Movie Store</a>
    </div>
    <div>
        <a>MANAGER</a>
    </div>
</nav>

<h1>🎬 Movie Store</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Title</th>
            <th>Price ($)</th>
            <th>Quality</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>

            <td>
                <img 
                    src="<?= !empty($row['image']) ? htmlspecialchars($row['image']) : 'https://via.placeholder.com/80x120?text=No+Image'; ?>" 
                    alt="<?= htmlspecialchars($row['title']); ?>">
            </td>

            <td><?= htmlspecialchars($row['title']); ?></td>
            <td><?= number_format($row['price'], 2); ?></td>
            <td><?= htmlspecialchars($row['quality']); ?></td>
            <td><?= htmlspecialchars($row['status']); ?></td>

            <td>
                <a href="buy.php?id=<?= $row['id']; ?>" class="btn buy">
                    <i class="fas fa-cart-shopping"></i> Buy
                </a>

                <a href="save.php?id=<?= $row['id']; ?>" class="btn save">
                    <i class="fas fa-bookmark"></i> Save
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>