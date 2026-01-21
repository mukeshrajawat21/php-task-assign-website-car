<?php
include('../database.php');
$id=$_GET['id'];
mysqli_query($conn,"DELETE FROM cars WHERE id=$id");
header("Location:add-car.php");
