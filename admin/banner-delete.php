<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit;
}
include('../database.php');

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $q = mysqli_query($conn, "SELECT image FROM banners WHERE id='$id'");
    $row = mysqli_fetch_assoc($q);
    $img = $row['image'];

    if(file_exists("../uploads/".$img)){
        unlink("../uploads/".$img);
    }

    mysqli_query($conn, "DELETE FROM banners WHERE id='$id'");

    header("Location: add-banner.php");  
    exit;
}
?>
