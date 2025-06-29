<?php

include 'config.php';

if (isset($_POST['submit'])) {

    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    // Check if user already exists
    $check_user = mysqli_query($conn, "SELECT * FROM `register` WHERE email='$email'") or die('Query failed');

    if (mysqli_num_rows($check_user) > 0) {
        $message[] = 'User already exists!';
    } else {
        // Check if passwords match
        if ($password != $cpassword) {
            $message[] = 'Passwords do not match!';
        } else {
            // Insert new user
            mysqli_query($conn, "INSERT INTO `register` (name, email, password, user_type) 
                VALUES ('$name', '$email', '$password', '$user_type')") or die('Query failed');
            
            $message[] = 'Registered successfully!';
            header('Location: login.php');
            exit(); // Stop script after redirect
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Form</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php
// Show messages if any
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . $msg . '</span>
            <i class="fa-solid fa-xmark" onclick="this.parentElement.remove();"></i>
        </div>';
    }
}
?>

<div class="box">
    <span class="borderline"></span>
    <form action="" method="post">
        <h2>Register</h2>

        <div class="inputbox">
            <input type="text" name="name" required>
            <span>Name</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input type="email" name="email" required>
            <span>Email</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input type="password" name="password" required>
            <span>Password</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input type="password" name="cpassword" required>
            <span>Confirm Password</span>
            <i></i>
        </div>

        <div class="links">
            <a href="#">Forgot Password?</a>
            <a href="login.php">Already have an account? Login</a>
        </div>

        <input type="submit" name="submit" value="Register Now">
    </form>
</div>

<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
</body>
</html>
