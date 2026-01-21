<?php include 'database.php'; ?>

<?php include 'header/header.php'; ?>


<div id="bannerCarousel" class="carousel slide hero" data-bs-ride="carousel">
  <div class="carousel-inner">

    <?php
    $i=0;
    $banners = mysqli_query($conn,"SELECT * FROM banners");
    while($b = mysqli_fetch_assoc($banners)){
    ?>
    <div class="carousel-item <?= ($i==0)?'active':''; ?>">
      <img src="uploads/<?= $b['image']; ?>" class="d-block w-100" style="height: 400px; object-fit: cover;">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
        <h5><?= htmlspecialchars($b['title']); ?></h5>
      </div>
    </div>
    <?php $i++; } ?>

  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<!-- ================= MOST SEARCHED ================= -->

<section class="container my-5">
  <h3 class="section-title">Most Searched Cars</h3>
  <div class="row g-4">

    <?php
    $cars = mysqli_query($conn,"SELECT * FROM cars WHERE type='most'");
    while($c = mysqli_fetch_assoc($cars)){
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
      <div class="card car-card shadow-sm">
        <img src="uploads/<?= $c['image']; ?>" class="card-img-top">
        <div class="card-body text-center">
          <h6 class="mb-2"><?= $c['name']; ?></h6>
          <a href="enquiry.php" class="btn btn-outline-primary btn-sm">Check Details</a>
        </div>
      </div>
    </div>
    <?php } ?>

  </div>
</section>

<!-- ================= LATEST CARS ================= -->
<section class="container my-5">
  <h3 class="section-title">Latest Cars</h3>
  <div class="row g-4">

    <?php
    $cars = mysqli_query($conn,"SELECT * FROM cars WHERE type='latest'");
    while($c = mysqli_fetch_assoc($cars)){
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
      <div class="card car-card shadow-sm">
        <img src="uploads/<?= $c['image']; ?>" class="card-img-top">
        <div class="card-body text-center">
          <h6><?= $c['name']; ?></h6>
          <a href="enquiry.php" class="btn btn-outline-success btn-sm">Enquire Now</a>
        </div>
      </div>
    </div>
    <?php } ?>

  </div>
</section>

<section class="bg-warning text-center p-4">
  <h4 class="mb-2">Looking for the best car?</h4>
  <a href="enquiry.php" class="btn btn-dark">Submit Your Enquiry</a>
</section>

<?php include 'footer/footer.php'; ?>

