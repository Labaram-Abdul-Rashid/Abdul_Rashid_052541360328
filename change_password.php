<?php

include("connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if(isset($_POST['change'])){

    $current = $_POST['current'];
    $new = $_POST['new'];
    $confirm = $_POST['confirm'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if(password_verify($current, $user['password'])){

        if($new == $confirm){

            $newhash = password_hash($new, PASSWORD_DEFAULT);

            $stmt2 = $conn->prepare("UPDATE users SET password=? WHERE id=?");
            $stmt2->bind_param("si",$newhash,$user_id);
            $stmt2->execute();

            $message = "Password changed successfully!";
        } else {
            $message = "New passwords do not match.";
        }

    } else {
        $message = "Current password is incorrect.";
    }
}
?>
<style>
    /* Reset */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, Helvetica, sans-serif;
}

/* Background */
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg, #141e30, #243b55);
}

/* Card */
.password-card{
    background:#ffffff;
    width:400px;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

/* Title */
.password-card h2{
    text-align:center;
    margin-bottom:20px;
    color:#2c3e50;
}

/* Message */
.message{
    text-align:center;
    margin-bottom:15px;
    font-size:14px;
    font-weight:bold;
}

/* Success */
.success{
    color:green;
}

/* Error */
.error{
    color:red;
}

/* Inputs */
.password-card input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:14px;
    transition:0.3s;
}

.password-card input:focus{
    border-color:#243b55;
    outline:none;
    box-shadow:0 0 5px rgba(36,59,85,0.3);
}

/* Button */
.password-card button{
    width:100%;
    padding:12px;
    background:#243b55;
    color:white;
    border:none;
    border-radius:6px;
    font-size:15px;
    cursor:pointer;
    transition:0.3s;
}

.password-card button:hover{
    background:#141e30;
}
</style>
<div class="password-card">

    <h2>Change Password</h2>

    <?php if($message != ""): ?>
        <p class="message <?php echo (strpos($message, 'successfully') !== false) ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <input type="password" name="current" placeholder="Current Password" required>
        <input type="password" name="new" placeholder="New Password" required>
        <input type="password" name="confirm" placeholder="Confirm New Password" required>
        <button type="submit" name="change">Change Password</button>
    </form>

</div>