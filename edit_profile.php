<?php
include("connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if(isset($_POST['update'])){

    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE users SET fullname=?, phone=? WHERE id=?");
    $stmt->bind_param("ssi", $fullname, $phone, $user_id);

    if($stmt->execute()){
        $message = "Profile updated successfully!";
    } else {
        $message = "Error updating profile.";
    }
}

$stmt = $conn->prepare("SELECT fullname, email, phone FROM users WHERE id=?");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<style>
    /* Reset */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, Helvetica, sans-serif;
}

/* Page background */
body{
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Card container */
.profile-card{
    background:#ffffff;
    width:400px;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

/* Title */
.profile-card h2{
    text-align:center;
    margin-bottom:20px;
    color:#2c3e50;
}

/* Input fields */
.profile-card input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:14px;
    transition:0.3s;
}

.profile-card input:focus{
    border-color:#2a5298;
    outline:none;
    box-shadow:0 0 5px rgba(42,82,152,0.3);
}

/* Disabled email field */
.profile-card input:disabled{
    background:#f2f2f2;
    cursor:not-allowed;
}

/* Button */
.profile-card button{
    width:100%;
    padding:12px;
    background:#2a5298;
    color:white;
    border:none;
    border-radius:6px;
    font-size:15px;
    cursor:pointer;
    transition:0.3s;
}

.profile-card button:hover{
    background:#1e3c72;
}

/* Success message */
.message{
    text-align:center;
    margin-bottom:15px;
    font-size:14px;
    color:green;
}
</style>
<div class="profile-card">
    <h2>Edit Profile</h2>

    <p class="message"><?php echo $message; ?></p>

    <form method="POST">
        <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" required>
        <input type="email" value="<?php echo $user['email']; ?>" disabled>
        <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>
        <button type="submit" name="update">Update</button>
    </form>
</div>