<?php
session_start();
if(isset($_SESSION['admin_logged_in'])){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login | CarsDekho</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f8f9fa; }
.login-container { max-width:400px; margin-top:100px; }
</style>
</head>
<body>

<div class="container login-container">
  <div class="card shadow">
    <div class="card-body">
      <h4 class="card-title text-center mb-4">Admin Login</h4>
      <?php
      if(isset($_GET['error'])){
          echo '<div class="alert alert-danger">'.htmlspecialchars($_GET['error']).'</div>';
      }
      ?>
      <form method="POST" action="authenticate.php">
        <div class="mb-3">
          <label>Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Login</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
