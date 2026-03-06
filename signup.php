<?php
include("connect.php");

if (isset($_POST['Submit'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];
    if ($password == $confirm_pass) {
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (fullname, email, phone, password) VALUES ('$fullname', '$email', '$phone', '$passwordhash')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    }
    else{
        echo "Password does not match";
    }

  
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<link rel="stylesheet" href="signup.css">
<body>

<div class="signup-container">
    <h2>Create Account</h2>

    <form method="post">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="tel" name="phone" placeholder="Phone Number" required>
        <input type="password"name="password" placeholder="Password" required>
        <input type="password" name="confirm_pass" placeholder="Confirm Password" required>

        <button type="submit" name="Submit" class="signup-btn">Sign Up</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="LOGIN.php">Login</a>
    </div>
</div>
</body>
</html>