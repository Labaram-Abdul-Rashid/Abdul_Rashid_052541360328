<?php
include("connect.php");

$message = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];

            header("Location: dashboard.php");
            exit();

        } else {
            $message = "Wrong Password!";
        }

    } else {
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="Bcon">
    <form method="POST">
        <h1>LOGIN</h1>

        <p style="color:red;"><?php echo $message; ?></p>

        <div>
            <input class="fm" type="email" name="email" placeholder="EMAIL ADDRESS" required>
        </div><br><br>

        <div>
            <input class="fm" type="password" name="password" placeholder="PASSWORD" required>
        </div><br>

        <div>
            <button type="submit" name="login" class="login-btn">SIGN IN</button>
        </div>

        <div style="margin-top:15px;">
            Don't Have An Account?
            <a href="signup.php">Register</a>
        </div>

    </form>
</div>

</body>
</html>