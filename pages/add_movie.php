<?php
include '../config/storedata.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add_movie'])) {

    $title   = $_POST['title'];
    $price   = $_POST['price'];
    $quality = $_POST['quality'];
    $status  = $_POST['status'];
    $image   = "";

    /* IMAGE UPLOAD */
    if (!empty($_FILES['image_upload']['name'])) {

        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image = $target_dir . basename($_FILES["image_upload"]["name"]);
        move_uploaded_file($_FILES["image_upload"]["tmp_name"], $image);

    } else {
        $image = $_POST['image_link'];
    }

    $stmt = $conn->prepare("
        INSERT INTO movies (title, price, quality, status, image) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sdsss", $title, $price, $quality, $status, $image);
    $stmt->execute();
    $stmt->close();

    header("Location: manager_admin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Movie</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
            padding: 40px;
        }

        .card {
            width: 25%;
            min-width: 300px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn:hover {
            background: #218838;
        }

        .back {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

<a href="manager_admin.php" class="back">← Back to Manager</a>

<div class="card">
    <h2>Add New Movie</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Title</label>
        <input type="text" name="title" required>

        <label>Upload Image</label>
        <input type="file" name="image_upload">

        <label>OR Image Link</label>
        <input type="text" name="image_link" placeholder="https://example.com/image.jpg">

        <label>Price</label>
        <input type="number" name="price" required>

        <label>Quality</label>
        <select name="quality" required>
            <option value="">Select Quality</option>
            <option value="2D">2D</option>
            <option value="3D">3D</option>
            <option value="IMAX">IMAX</option>
            <option value="ScreenX">ScreenX</option>
        </select>
        <label>Status</label>
        <select name="status" required>
            <option value="">Select Status</option>
            <option value="Non-Variable">Non-Variable</option>
            <option value="Variable">Variable</option>
        </select>

        <button type="submit" name="add_movie" class="btn">
            Add Movie
        </button>

    </form>
</div>

</body>
</html>