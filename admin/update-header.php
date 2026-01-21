<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit;
}
include('../database.php'); 

$msg = "";
$msg_type = "";

/* ================= ADD NEW HEADER SETTING ================= */
if(isset($_POST['add_header'])){
    $site_name = trim($_POST['site_name']);
    $enquiry_text = trim($_POST['enquiry_button_text']);

    if($site_name==""){
        $msg="Site Name is required";
        $msg_type="warning";
    } else {
        mysqli_query($conn,"INSERT INTO header_settings (site_name,enquiry_button_text) VALUES ('$site_name','$enquiry_text')");
        $msg="Header setting added successfully";
        $msg_type="success";
    }
}

/* ================= UPDATE HEADER SETTING ================= */
if(isset($_POST['update_header'])){
    $id = $_POST['edit_id'];
    $site_name = trim($_POST['edit_site_name']);
    $enquiry_text = trim($_POST['edit_enquiry_text']);

    if($site_name==""){
        $msg="Site Name is required";
        $msg_type="warning";
    } else {
        mysqli_query($conn,"UPDATE header_settings SET site_name='$site_name', enquiry_button_text='$enquiry_text' WHERE id='$id'");
        $msg="Header setting updated successfully";
        $msg_type="success";
    }
}

/* ================= DELETE HEADER SETTING ================= */
if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];
    mysqli_query($conn,"DELETE FROM header_settings WHERE id='$id'");
    $msg="Header setting deleted successfully";
    $msg_type="success";
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Header Settings | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
<h3 class="text-center mb-4">Header Settings</h3>

<?php if($msg!=""){ ?>
<div class="alert alert-<?= $msg_type; ?> text-center"><?= $msg; ?></div>
<?php } ?>

<div class="mb-3 text-end">
  <a href="index.php" class="btn btn-sm btn-dark mr-2">Admin Home</a>

<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Add New Header Setting</button>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover text-center align-middle">
<thead class="table-dark">
<tr>
<th>#</th>
<th>Site Name</th>
<th>Enquiry Button Text</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php
$q=mysqli_query($conn,"SELECT * FROM header_settings ORDER BY id DESC");
$no=1;
while($row=mysqli_fetch_assoc($q)){
?>
<tr>
<td><?= $no++; ?></td>
<td><?= $row['site_name']; ?></td>
<td><?= $row['enquiry_button_text']; ?></td>
<td>
<button class="btn btn-primary btn-sm" 
    data-bs-toggle="modal" 
    data-bs-target="#editModal"
    data-id="<?= $row['id']; ?>"
    data-site="<?= htmlspecialchars($row['site_name'],ENT_QUOTES); ?>"
    data-enquiry="<?= htmlspecialchars($row['enquiry_button_text'],ENT_QUOTES); ?>">Edit</button>

<button class="btn btn-danger btn-sm" 
    data-bs-toggle="modal" 
    data-bs-target="#deleteModal"
    data-id="<?= $row['id']; ?>">Delete</button>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">
<div class="modal-header">
<h5 class="modal-title">Add Header Setting</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<div class="mb-3">
<label>Site Name</label>
<input type="text" name="site_name" class="form-control" required>
</div>
<div class="mb-3">
<label>Enquiry Button Text</label>
<input type="text" name="enquiry_button_text" class="form-control">
</div>
</div>
<div class="modal-footer">
<button type="submit" name="add_header" class="btn btn-success">Add</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
</form>
</div>
</div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">
<div class="modal-header">
<h5 class="modal-title">Edit Header Setting</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<input type="hidden" name="edit_id" id="edit_id">
<div class="mb-3">
<label>Site Name</label>
<input type="text" name="edit_site_name" id="edit_site_name" class="form-control" required>
</div>
<div class="mb-3">
<label>Enquiry Button Text</label>
<input type="text" name="edit_enquiry_text" id="edit_enquiry_text" class="form-control">
</div>
</div>
<div class="modal-footer">
<button type="submit" name="update_header" class="btn btn-success">Update</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
</form>
</div>
</div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">
<div class="modal-header">
<h5 class="modal-title">Confirm Delete</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
Are you sure you want to delete this header setting?
<input type="hidden" name="delete_id" id="delete_id">
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-danger">Delete</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</div>
</form>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Edit Modal
var editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function(event){
    var button = event.relatedTarget;
    document.getElementById('edit_id').value = button.getAttribute('data-id');
    document.getElementById('edit_site_name').value = button.getAttribute('data-site');
    document.getElementById('edit_enquiry_text').value = button.getAttribute('data-enquiry');
});

// Delete Modal 
var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function(event){
    var button = event.relatedTarget;
    document.getElementById('delete_id').value = button.getAttribute('data-id');
});
</script>

</body>
</html>
