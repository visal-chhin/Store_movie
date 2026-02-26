<?php
session_start();

// Hardcoded credentials
$correct_email = "visalchhin54@gmail.com";
$correct_password = "Aa1122@@";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($email === $correct_email && $password === $correct_password){
        $_SESSION['admin'] = $email;
        header("Location: manager_admin.php");
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        /* Body Background Gradient */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f6d365, #fda085);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Card Container */
        .card {
            background: white;
            width: 380px;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            text-align: center;
        }

        /* Logo / Title */
        .card h1 {
            color: #ff6f61;
            font-size: 36px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        /* Inputs */
        .card input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        /* Login Button */
        .card button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #6c5ce7;
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }

        .card button:hover {
            background: #5a4bcf;
        }

        /* Error Message */
        .error {
            color: red;
            margin-bottom: 10px;
            font-weight: bold;
        }

        /* Footer / Links */
        .card .footer-link {
            margin-top: 20px;
            font-size: 14px;
            color: #ff6f61;
            text-decoration: none;
        }

        .card .footer-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Movie Admin</h1>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Log In</button>
    </form>

    <a href="#" class="footer-link">Forgot password?</a>
</div>

</body>
</html>