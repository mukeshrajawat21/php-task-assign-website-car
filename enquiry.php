<?php include 'header/header.php'; ?>

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-8">

<h2 class="mb-4 text-center">Car Enquiry Form</h2>

<form method="POST" action="insert.php" class="card p-4 shadow">

<div class="mb-3">
<label class="form-label">Full Name</label>
<input type="text" name="name" class="form-control" placeholder="Enter your name" required>
</div>

<div class="mb-3">
<label class="form-label">Phone Number</label>
<input type="text" name="phone" class="form-control" placeholder="Enter phone number" required>
</div>

<div class="mb-3">
<label class="form-label">Email Address</label>
<input type="email" name="email" class="form-control" placeholder="Enter email">
</div>

<div class="mb-3">
<label class="form-label">Address</label>
<textarea name="address" class="form-control" rows="3" placeholder="Enter address"></textarea>
</div>

<div class="mb-3">
<label class="form-label fw-bold">Select Car Type</label>

<div class="row g-3 mt-1">

<div class="col-md-4">
<label class="car-option w-100">
<input type="checkbox" name="car_type[]" value="Hatchback">
Hatchback
</label>
</div>

<div class="col-md-4">
<label class="car-option w-100">
<input type="checkbox" name="car_type[]" value="Sedan">
Sedan
</label>
</div>

<div class="col-md-4">
<label class="car-option w-100">
<input type="checkbox" name="car_type[]" value="SUV">
SUV
</label>
</div>

</div>
</div>

<button class="btn btn-primary w-100 py-2 mt-3">
Submit Enquiry
</button>

</form>

</div>
</div>
</div>

<?php include 'footer/footer.php'; ?>
