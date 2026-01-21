<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Dashboard | CarsDekho</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.admin-navbar {
    background: #212529;
}
.admin-navbar .nav-link,
.admin-navbar .navbar-brand {
    color: #fff !important;
    font-weight: 500;
}

.card:hover {
    transform: translateY(-4px);
    transition: 0.3s;
}
</style>
</head>

<body class="bg-light">

<!-- ================= ADMIN HEADER ================= -->
<nav class="navbar admin-navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="../index.php">CarsDekho Admin</a>

    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#adminMenu" aria-controls="adminMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminMenu">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link text-white" href="#">
            Welcome, <?= htmlspecialchars($_SESSION['admin_username']); ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- ================= DASHBOARD ================= -->
<div class="container my-5">
  <h3 class="text-center mb-4">Admin Dashboard</h3>
  <div class="row g-4 justify-content-center">

    <div class="col-lg-4 col-md-6 col-sm-12">
      <div class="card shadow h-100 text-center">
        <div class="card-body">
          <h5 class="card-title">Banner Management</h5>
          <p class="text-muted">Add, update or delete homepage banners</p>
          <a href="add-banner.php" class="btn btn-primary w-100">Manage Banners</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
      <div class="card shadow h-100 text-center">
        <div class="card-body">
          <h5 class="card-title">Car Management</h5>
          <p class="text-muted">Add, update or delete cars</p>
          <a href="add-car.php" class="btn btn-success w-100">Manage Cars</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
      <div class="card shadow h-100 text-center">
        <div class="card-body">
          <h5 class="card-title">Header Settings</h5>
          <p class="text-muted">Update site name and enquiry button text</p>
          <a href="update-header.php" class="btn btn-info w-100 text-white">Manage Header</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
      <div class="card shadow h-100 text-center">
        <div class="card-body">
          <h5 class="card-title">User Enquiries</h5>
          <p class="text-muted">View customer enquiries</p>
          <a href="enquiries.php" class="btn btn-warning w-100">View Enquiries</a>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- ================= FOOTER ================= -->
<footer class="bg-dark text-white text-center py-3 mt-5">
  &copy; <?= date('Y'); ?> CarsDekho Admin Panel
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
