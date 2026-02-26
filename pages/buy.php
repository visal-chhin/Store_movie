<?php
include '../config/storedata.php';

if (!isset($_GET['id'])) {
    die("Movie ID missing.");
}

$movie_id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM movies WHERE id = $movie_id");
$movie = mysqli_fetch_assoc($result);

if (!$movie) {
    die("Movie not found.");
}

$message = "";

// FORM SUBMIT
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $payment = $_POST['payment'];

    // Image upload
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];

    if ($imageSize > 5 * 1024 * 1024) {
        $message = "❌ Image must be less than 5MB!";
    } else {

        $uploadPath = "../uploads/" . time() . "_" . $imageName;
        move_uploaded_file($imageTmp, $uploadPath);

        mysqli_query($conn, "INSERT INTO orders 
        (movie_id, first_name, last_name, email, payment, image)
        VALUES 
        ('$movie_id', '$first', '$last', '$email', '$payment', '$uploadPath')");

        $message = "✅ Order Successful!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buy Movie</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .container {
            background: white;
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .msg {
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">

    <img src="<?= htmlspecialchars($movie['image']); ?>">

    <h2><?= htmlspecialchars($movie['title']); ?></h2>
    <p><strong>Price:</strong> $<?= number_format($movie['price'],2); ?></p>

    <?php if($message) echo "<div class='msg'>$message</div>"; ?>

    <form action="interface.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    
    <select name="payment" required>
        <option value="">Select Payment</option>
        <option value="ABA">ABA</option>
        <option value="Wing">Wing</option>
        <option value="Cash">Cash</option>
    </select>

    <label>Upload Payment Screenshot (Max 5MB)</label>
    <input type="file" name="image">

    <button type="submit">Confirm Purchase</button>
</form>

</div>

</body>
</html>