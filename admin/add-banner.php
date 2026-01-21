<?php

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit;
}

include('../database.php');

$msg = "";
$msg_type = "";

/* ================= ADD BANNER ================= */
if(isset($_POST['add_banner'])){
    $title = trim($_POST['title']); 

    if($_FILES['image']['name']!=""){
        $img = time().'_'.$_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        if(move_uploaded_file($tmp,"../uploads/".$img)){
            mysqli_query($conn,"INSERT INTO banners (title, image) VALUES ('$title','$img')");
            $msg="Banner added successfully";
            $msg_type="success";
        }else{
            $msg="Image upload failed";
            $msg_type="danger";
        }
    }else{
        $msg="Please select an image";
        $msg_type="warning";
    }
}



/* ================= UPDATE BANNER ================= */

if(isset($_POST['update_banner'])){
    $id = $_POST['edit_id'];
    $title = trim($_POST['title']);

    $q = mysqli_query($conn,"SELECT image FROM banners WHERE id='$id'");
    $row = mysqli_fetch_assoc($q);
    $current_img = $row['image'];

    // If new image uploaded
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
        $new_img = time().'_'.$_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        if(move_uploaded_file($tmp,"../uploads/".$new_img)){
            if(file_exists("../uploads/".$current_img)){
                unlink("../uploads/".$current_img);
            }
            mysqli_query($conn,"UPDATE banners SET title='$title', image='$new_img' WHERE id='$id'");
            $msg="Banner updated successfully";
            $msg_type="success";
        } else {
            $msg="Banner update failed";
            $msg_type="danger";
        }
    } else {
        
        mysqli_query($conn,"UPDATE banners SET title='$title' WHERE id='$id'");
        $msg="Banner updated successfully (image unchanged)";
        $msg_type="success";
    }
}

/* ================= DELETE BANNER ================= */
if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];

    $q = mysqli_query($conn,"SELECT image FROM banners WHERE id='$id'");
    $row = mysqli_fetch_assoc($q);

    if($row){
        if(file_exists("../uploads/".$row['image'])){
            unlink("../uploads/".$row['image']);
        }
        mysqli_query($conn,"DELETE FROM banners WHERE id='$id'");
        $msg="Banner deleted successfully";
        $msg_type="success";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Banners</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
.container{margin-top:60px;}
.card{box-shadow:0 4px 10px rgba(0,0,0,0.1);}
@media(max-width:576px){ .card-header div{ margin-top:10px; } }
</style>
</head>
<body>

<div class="container">
<div class="card">
<div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
  <h5 class="mb-0">Banner Management</h5>
  <div>
    <a href="index.php" class="btn btn-sm btn-light mr-2">Admin Home</a>
    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addBannerModal">Add Banner</button>
  </div>
</div>

<div class="card-body">
<?php if($msg!=""){ ?>
<div class="alert alert-<?php echo $msg_type; ?>"><?php echo $msg; ?></div>
<?php } ?>

<table class="table table-bordered text-center">
<thead class="thead-dark">
<tr>
<th>ID</th>
<th>Title</th>
<th>Image</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php
$q=mysqli_query($conn,"SELECT * FROM banners ORDER BY id DESC");
if(mysqli_num_rows($q)==0){
    echo "<tr><td colspan='4'>No banners found</td></tr>";
}
while($b=mysqli_fetch_assoc($q)){
?>
<tr>
<td><?= $b['id']; ?></td>
<td><?= htmlspecialchars($b['title']); ?></td>
<td><img src="../uploads/<?= $b['image']; ?>" width="150"></td>
<td>
<button class="btn btn-sm btn-primary"
 data-toggle="modal"
 data-target="#editModal"
 data-id="<?= $b['id']; ?>"
 data-title="<?= htmlspecialchars($b['title']); ?>"
 data-image="<?= $b['image']; ?>">Edit</button>

<button class="btn btn-sm btn-danger"
 data-toggle="modal"
 data-target="#deleteModal"
 data-id="<?= $b['id']; ?>">Delete</button>
</td>
</tr>
<?php } ?>

</tbody>
</table>
</div>
</div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addBannerModal">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" enctype="multipart/form-data">
<div class="modal-header bg-dark text-white">
<h5>Add Banner</h5>
<button class="close text-white" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<input type="text" name="title" class="form-control mb-3" placeholder="Banner Title" required>
<input type="file" name="image" class="form-control" required>
</div>
<div class="modal-footer">
<button class="btn btn-success" name="add_banner">Upload</button>
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
<h5>Edit Banner</h5>
<button class="close text-white" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body text-center">
<input type="hidden" name="edit_id" id="edit_id">
<input type="text" name="title" id="edit_title" class="form-control mb-3" placeholder="Banner Title" required>
<img id="preview_image" width="200" class="mb-3"><br>
<input type="file" name="image" class="form-control">
</div>
<div class="modal-footer">
<button class="btn btn-success" name="update_banner">Update</button>
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
<h5>Confirm Delete</h5>
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

<script>
$('#deleteModal').on('show.bs.modal', function (event) {
  $('#delete_id').val($(event.relatedTarget).data('id'));
});

$('#editModal').on('show.bs.modal', function (event) {
  var btn = $(event.relatedTarget);
  $('#edit_id').val(btn.data('id'));
  $('#edit_title').val(btn.data('title'));
  $('#preview_image').attr('src','../uploads/'+btn.data('image'));
});
</script>

</body>
</html>
