<?php
session_start();
include('../database.php'); 

if(isset($_POST['username'], $_POST['password'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = sha1($_POST['password']); 

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    if(mysqli_num_rows($query) == 1){
        $admin = mysqli_fetch_assoc($query);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: index.php");
        exit;
    } else {
        header("Location: login.php?error=Invalid+Credentials");
        exit;
    }

} else {
    header("Location: login.php");
    exit;
}
?>
