<?php
include("connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT fullname, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>
<style>
body{
    margin:0;
    font-family:Arial;
    background:#f4f6f9;
}
.sidebar{
    width:220px;
    height:100vh;
    background:#2c3e50;
    position:fixed;
    padding-top:20px;
}
.sidebar a{
    display:block;
    color:white;
    padding:12px;
    text-decoration:none;
}
.sidebar a:hover{
    background:#34495e;
}
.main{
    margin-left:220px;
    padding:20px;
}
.card{
    background:white;
    padding:20px;
    border-radius:8px;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}
.topbar{
    background:white;
    padding:15px;
    margin-bottom:20px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<div class="sidebar">
    <h3 style="color:white;text-align:center;">Portal</h3>
    <a href="dashboard.php">Dashboard</a>
    <a href="edit_profile.php">Edit Profile</a>
    <a href="change_password.php">Change Password</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">

<div class="topbar">
    Welcome, <?php echo htmlspecialchars($user['fullname']); ?> 👋
</div>

<div class="card">
    <h2>Your Information</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
</div>

</div>

</body>
</html>