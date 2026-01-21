
<?php
include 'database.php';
$header = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM header_settings LIMIT 1"));
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.car-option {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
}
.car-option:hover {
    border-color: #0d6efd;
    background: #f8f9fa;
}
.car-option input {
    transform: scale(1.2);
    margin-right: 8px;
}

.hero {
    max-height: 450px;
    overflow: hidden;
}

.hero .carousel-item img {
    height: 450px;
    object-fit: cover;
    width: 100%;
}


</style>



</head>

<body>

<nav class="navbar navbar-dark bg-dark px-3">
  <a class="navbar-brand fw-bold" href="index.php">
    <?= $header['site_name']; ?>
  </a>
  <a href="enquiry.php" class="btn btn-warning btn-sm">
    <?= $header['enquiry_button_text']; ?>
  </a>
</nav>

