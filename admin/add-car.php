<?php

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit;
}

include('../database.php');

$msg = "";
$msg_type = "";

/* ============ ADD CAR ============ */
if(isset($_POST['submit'])) {

    $name = trim($_POST['name']);
    $section = $_POST['section'];

    if($name==""){
        $msg="Car name is required";
        $msg_type="warning";
    }
    elseif($_FILES['image']['name']==""){
        $msg="Please select car image";
        $msg_type="warning";
    }
    else{
        $img = time().'_'.$_FILES['image']['name'];
        if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$img)){
            mysqli_query($conn,"INSERT INTO cars (name,image,type) VALUES ('$name','$img','$section')");
            $msg="Car added successfully";
            $msg_type="success";
        }else{
            $msg="Image upload failed";
            $msg_type="danger";
        }
    }
}

/* ============ UPDATE CAR ============ */
if(isset($_POST['update_car'])){
    $id = $_POST['edit_id'];
    $name = trim($_POST['name']);
    $section = $_POST['section'];

    if($name==""){
        $msg="Car name is required";
        $msg_type="warning";
    }else{

        if($_FILES['image']['name']!=""){
            $new_img = time().'_'.$_FILES['image']['name'];

            $q = mysqli_query($conn,"SELECT image FROM cars WHERE id='$id'");
            $row = mysqli_fetch_assoc($q);

            if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$new_img)){
                if(file_exists("../uploads/".$row['image'])){
                    unlink("../uploads/".$row['image']);
                }
                mysqli_query($conn,"UPDATE cars SET name='$name', type='$section', image='$new_img' WHERE id='$id'");
                $msg="Car updated successfully";
                $msg_type="success";
            }else{
                $msg="Image update failed";
                $msg_type="danger";
            }
        }else{
            mysqli_query($conn,"UPDATE cars SET name='$name', type='$section' WHERE id='$id'");
            $msg="Car updated successfully";
            $msg_type="success";
        }
    }
}

/* ============ DELETE CAR ============ */
if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];

    $q = mysqli_query($conn,"SELECT image FROM cars WHERE id='$id'");
    $row = mysqli_fetch_assoc($q);

    if(file_exists("../uploads/".$row['image'])){
        unlink("../uploads/".$row['image']);
    }
    mysqli_query($conn,"DELETE FROM cars WHERE id='$id'");
    $msg="Car deleted successfully";
    $msg_type="success";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Cars</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
.container{margin-top:60px;}
.card{box-shadow:0 4px 10px rgba(0,0,0,0.1);}
img{width:90px;height:55px;object-fit:cover;}
</style>
</head>

<body>

<div class="container">
<div class="card">

<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Cars Management</h5>
  <div>
    <a href="index.php" class="btn btn-sm btn-light mr-2">Admin Home</a>
    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal">Add Car</button>
  </div>
</div>

<div class="card-body">

<?php if($msg!=""){ ?>
<div class="alert alert-<?= $msg_type; ?>"><?= $msg; ?></div>
<?php } ?>

<table class="table table-bordered table-striped text-center">
<thead class="thead-dark">
<tr>
<th>#</th>
<th>Name</th>
<th>Image</th>
<th>Section</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php
$q=mysqli_query($conn,"SELECT * FROM cars ORDER BY id DESC");
$i=1;
while($row=mysqli_fetch_assoc($q)){
?>
<tr>
<td><?= $i++; ?></td>
<td><?= $row['name']; ?></td>
<td><img src="../uploads/<?= $row['image']; ?>"></td>
<td><?= ucfirst($row['type']); ?></td>
<td>
<button class="btn btn-primary btn-sm"
 data-toggle="modal"
 data-target="#editModal"
 data-id="<?= $row['id']; ?>"
 data-name="<?= $row['name']; ?>"
 data-type="<?= $row['type']; ?>"
 data-image="<?= $row['image']; ?>">Edit</button>

<button class="btn btn-danger btn-sm"
 data-toggle="modal"
 data-target="#deleteModal"
 data-id="<?= $row['id']; ?>">Delete</button>
</td>
</tr>
<?php } ?>

</tbody>
</table>

</div>
</div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addModal">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" enctype="multipart/form-data">
<div class="modal-header">
<h5>Add Car</h5>
<button class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<input class="form-control mb-2" name="name" placeholder="Car Name" required>
<input type="file" name="image" class="form-control mb-2" required>
<select name="section" class="form-control">
<option value="most">Most Searched</option>
<option value="latest">Latest</option>
</select>
</div>
<div class="modal-footer">
<button class="btn btn-primary" name="submit">Add</button>
</div>
</form>
</div>
</div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" enctype="multipart/form-data">
<div class="modal-header bg-primary text-white">
<h5>Edit Car</h5>
<button class="close text-white" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body text-center">
<input type="hidden" name="edit_id" id="edit_id">
<input type="text" name="name" id="edit_name" class="form-control mb-2" required>
<select name="section" id="edit_section" class="form-control mb-2">
<option value="most">Most Searched</option>
<option value="latest">Latest</option>
</select>
<img id="edit_preview" class="mb-2" width="120"><br>
<input type="file" name="image" class="form-control">
</div>
<div class="modal-footer">
<button class="btn btn-success" name="update_car">Update</button>
</div>
</form>
</div>
</div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">
<div class="modal-header">
<h5>Delete Confirmation</h5>
<button class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
Are you sure?
<input type="hidden" name="delete_id" id="delete_id">
</div>
<div class="modal-footer">
<button class="btn btn-danger">Delete</button>
</div>
</form>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$('#deleteModal').on('show.bs.modal', function(e){
  $('#delete_id').val($(e.relatedTarget).data('id'));
});

$('#editModal').on('show.bs.modal', function(e){
  var btn = $(e.relatedTarget);
  $('#edit_id').val(btn.data('id'));
  $('#edit_name').val(btn.data('name'));
  $('#edit_section').val(btn.data('type'));
  $('#edit_preview').attr('src','../uploads/'+btn.data('image'));
});
</script>

</body>
</html>
