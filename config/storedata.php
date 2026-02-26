<?php
$conn = mysqli_connect("localhost", "root", "", "movie_store");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>