<?php

include('database.php');

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$car_type = implode(',', $_POST['car_type']);


mysqli_query($conn,"INSERT INTO car_enquiries (name,phone,email,address,car_type)
VALUES ('$name','$phone','$email','$address','$car_type')");


echo "<script>alert('Enquiry Submitted');window.location='enquiry.php';</script>";



?>