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

    <style>
        /* RESET */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        /* NAVBAR */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background-color: #333;
            padding: 10px 20px;
            color: white;
            border-radius: 8px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        /* PAGE TITLE */
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            color: #333;
        }

        /* GRID CONTAINER */
        .movie-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        /* MOVIE CARD */
        .movie-card {
            background-color: white;
            width: 24%;
            min-width: 200px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s;
        }

        .movie-card:hover {
            transform: scale(1.03);
        }

        .movie-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .movie-content {
            padding: 15px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .movie-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .movie-info {
            margin-bottom: 15px;
            color: #555;
        }

        .movie-info span {
            display: block;
        }

        .movie-actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            cursor: pointer;
        }

        .btn.buy {
            background-color: #28a745;
        }

        .btn.save {
            background-color: #007bff;
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .movie-card { width: 32%; }
        }

        @media (max-width: 900px) {
            .movie-card { width: 48%; }
        }

        @media (max-width: 600px) {
            .movie-card { width: 100%; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <div>
        <a href="#">🎬 Movie Store</a>
    </div>
    <div>
        <a href="login_admin.php">Manager</a>
</div>
</nav>

<h1>🎬 Movie Store</h1>

<div class="movie-grid">
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div class="movie-card">
        <img 
            src="<?= !empty($row['image']) ? htmlspecialchars($row['image']) : 'https://via.placeholder.com/250x350?text=No+Image'; ?>" 
            alt="<?= htmlspecialchars($row['title']); ?>">

        <div class="movie-content">
            <div>
                <div class="movie-title"><?= htmlspecialchars($row['title']); ?></div>
                <div class="movie-info">
                    <span>Price: $<?= number_format($row['price'], 2); ?></span>
                    <span>Quality: <?= htmlspecialchars($row['quality']); ?></span>
                    <span>Status: <?= htmlspecialchars($row['status']); ?></span>
                </div>
            </div>
            <div class="movie-actions">
                <a href="buy.php?id=<?= $row['id']; ?>" class="btn buy">
                    <i class="fas fa-cart-shopping"></i> Buy
                </a>
                <a href="#" class="btn save">
                    <i class="fas fa-bookmark"></i> Save
                </a>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

</body>
</html>