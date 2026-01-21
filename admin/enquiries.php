<?php
include('../database.php');
$q = mysqli_query($conn,"SELECT * FROM car_enquiries ORDER BY id DESC");
$total = mysqli_num_rows($q);
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer Enquiries</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
.container{ margin-top:60px; }
.card{ box-shadow:0 4px 10px rgba(0,0,0,0.1); }
</style>
</head>
<body>

<div class="container">

<div class="card">
<div class="card-header bg-dark text-white d-flex justify-content-between">
    <h5 class="mb-0">Customer Enquiries</h5>
    <a href="index.php" class="btn btn-sm btn-light">Admin Home</a>
</div>

<div class="card-body">

<?php if($total==0){ ?>

<div class="alert alert-warning text-center">
    No enquiries found
</div>

<?php } else { ?>

<div class="table-responsive">
<table class="table table-bordered table-hover">

<thead class="thead-dark">
<tr>
<th>#</th>
<th>Name</th>
<th>Phone</th>
<th>Email</th>
<th>Car Type</th>
<th>Address</th>
<th>Date</th>
</tr>
</thead>

<tbody>
<?php
$i=1;
while($e=mysqli_fetch_assoc($q)){
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo $e['name']; ?></td>
<td><?php echo $e['phone']; ?></td>
<td><?php echo $e['email']; ?></td>
<td>
<span class="badge badge-info">
<?php echo $e['car_type']; ?>
</span>
</td>
<td><?php echo $e['address']; ?></td>
<td><?php echo date("d M Y",strtotime($e['created_at'])); ?></td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

<?php } ?>

</div>
</div>

</div>

</body>
</html>
