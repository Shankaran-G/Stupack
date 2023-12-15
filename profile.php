<?php
session_start();

if (isset($_POST['logout'])) {

  session_destroy();

  header('Location: login.php');
  exit();
}

if (!isset($_SESSION['indexnumber'])) {
  header('Location: login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Student Details USJ_FOT</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  <style>
    .col-lg-9 {
      padding: 8px;

    }


    .col-lg-3 {
      text-align: center;
    }


    .col-lg-3 img {
      max-width: 100%;
    }

    .outtitle {
      font-size: 25px;

      color: #181d38;

      font-weight: bold;

      margin: 20px 0;
      margin-left: 20px;

      font-family: 'Arial Black', sans-serif;
    }

    .showtitle {
      font-size: 18px;

      color: #124c64;

      font-weight: bold;
      margin-left: 20px;

      margin: 20px 0;

      font-family: 'Arial Black', sans-serif;
    }
  </style>


  <link href="img/favicon.ico" rel="icon" />


  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
    rel="stylesheet" />


  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />


  <link href="lib/animate/animate.min.css" rel="stylesheet" />
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />


  <link href="css/bootstrap.min.css" rel="stylesheet" />


  <link href="css/style.css" rel="stylesheet" />
</head>

<body>

  <div id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="#" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
      <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>STUpack</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <a href="#" class="nav-item nav-link active">Profile</a>
        <a href="results.php" class="nav-item nav-link">Results</a>
        <a href="mail.html" class="nav-item nav-link">Modules</a>
        <a href="preference.php" class="nav-item nav-link">Preferences</a>
      </div>
      <form method="post" action="">
        <button type="submit" name="logout" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Log Out <i
            class="fa fa-arrow-left ms-3"></i></button>
      </form>
    </div>
  </nav>


  <!-- Header Start -->
  <div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
          <h1 class="display-3 text-white animated slideInDown">
            <?php
            $indexnumber = $_SESSION['indexnumber'];

            include 'db.php';
            $sql = "SELECT * FROM stupackdetails WHERE indexnumber ='$indexnumber' ";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              echo '<p class="title">' . $row["name"] . '</p>';
            }
            ?>
          </h1>
        </div>
      </div>
    </div>
  </div>
  <!-- Header End -->



  <?php

  $indexnumber = $_SESSION['indexnumber'];
  include 'db.php';
  $sql = "SELECT profile_photo FROM stupackdetails WHERE indexnumber ='$indexnumber' ";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $profilePhotoPath = $row["profile_photo"];
    if (!empty($profilePhotoPath)) {
      echo '<div class="container-xxl py-5">';
      echo '<div class="container">';
      echo '<div class="row justify-content-center align-items-center">';
      echo '<div class="col-lg-6 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
      echo '<div class="service-item text-center pt-3">';
      echo '<div class="p-4">';
      echo '<h5 class="mb-3">Profile Image</h5>';
      echo '<img src="' . $profilePhotoPath . '" alt="Profile Photo" class="img-fluid" style="width: 50%; height: 50%;" />';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    } else {
      echo '<p>No profile photo available</p>';
    }
  } else {
    echo '<p>No profile photo available</p>';
  }
  mysqli_close($conn);
  ?>
  <?php

  $indexnumber = $_SESSION['indexnumber'];

  include 'db.php';
  $sql = "SELECT * FROM stupackdetails WHERE indexnumber ='$indexnumber' ";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo '<div class="container-xxl py-5">';
    echo '<div class="container">';
    echo '<div class="row g-6">';
    echo '<div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
    echo '<div class="service-item text-center pt-3">';
    echo '<div class="p-4">';
    echo '<i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>';
    echo '<h5 class="mb-3">Full Name</h5>';
    echo '<p><strong class="showtitle">' . $row["fullname"] . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
    echo '<div class="service-item text-center pt-3">';
    echo '<div class="p-4">';
    echo '<i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>';
    echo '<h5 class="mb-3">iIndexnumber</h5>';
    echo '<p> </strong><strong class="showtitle">' . $row["indexnumber"] . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
    echo '<div class="service-item text-center pt-3">';
    echo '<div class="p-4">';
    echo '<i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>';
    echo '<h5 class="mb-3">Registration No</h5>';
    echo '<p></strong><strong class="showtitle">' . $row["registration"] . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="container-xxl py-5">';
    echo '<div class="container">';
    echo '<div class="row g-6">';
    echo '<div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
    echo '<div class="service-item text-center pt-3">';
    echo '<div class="p-4">';
    echo '<i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>';
    echo '<h5 class="mb-3">Date Of Birth</h5>';
    echo '<p> </strong><strong class="showtitle">' . $row["dob"] . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
    echo '<div class="service-item text-center pt-3">';
    echo '<div class="p-4">';
    echo '<i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>';
    echo '<h5 class="mb-3">University Email</h5>';
    echo '<p></strong><strong class="showtitle">' . $row["uniemail"] . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
    echo '<div class="service-item text-center pt-3">';
    echo '<div class="p-4">';
    echo '<i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>';
    echo '<h5 class="mb-3">Department</h5>';
    echo '<p></strong><strong class="showtitle">' . $row["department"] . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="container-xxl py-5">';
    echo '<div class="container">';
    echo '<div class="row g-6">';
    echo '<div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
    echo '<div class="service-item text-center pt-3">';
    echo '<div class="p-4">';
    echo '<i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>';
    echo '<h5 class="mb-3">Batch Year</h5>';
    echo '<p></strong><strong class="showtitle">' . $row["batchyear"] . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
    echo '<div class="service-item text-center pt-3">';
    echo '<div class="p-4">';
    echo '<i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>';
    echo '<h5 class="mb-3">Scholarship</h5>';
    echo '<p></strong><strong class="showtitle">' . $row["scholarship"] . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">';
    echo '<div class="service-item text-center pt-3">';
    echo '<div class="p-4">';
    echo '<i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>';
    echo '<h5 class="mb-3">Contact Number</h5>';
    echo '<p></strong><strong class="showtitle">' . $row["contactnumber"] . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';



  } else {
    echo "No records found.";
  }

  mysqli_close($conn);
  ?>





  <div class="container-fluid bg-dark text-light footer pt-7 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <div class="row g-5">
        <div class="col-lg-4 col-md-6">
          <h4 class="text-white mb-3">Quick Link</h4>
          <a class="btn btn-link" href="about.html">About Us</a>
          <a class="btn btn-link" href="contact.html">Contact Us</a>
          <a class="btn btn-link" href="">Privacy Policy</a>
          <a class="btn btn-link" href="">Terms & Condition</a>
          <a class="btn btn-link" href="">FAQs & Help</a>
        </div>
        <div class="col-lg-4 col-md-6">
          <h4 class="text-white mb-3">Contact</h4>
          <p class="mb-2">
            <i class="fa fa-map-marker-alt me-3"></i>Avengers building,
            Facultyof Technology, UniversityOf sri Jayewardenepura.
          </p>
          <p class="mb-2">
            <i class="fa fa-phone-alt me-3"></i>+012 345 67890
          </p>
          <p class="mb-2">
            <i class="fa fa-envelope me-3"></i>stupack@example.com
          </p>
          <div class="d-flex pt-2">
            <a class="btn btn-outline-light btn-social" href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
            <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/"><i
                class="fab fa-facebook-f"></i></a>
            <a class="btn btn-outline-light btn-social" href="https://www.youtube.com/"><i
                class="fab fa-youtube"></i></a>
            <a class="btn btn-outline-light btn-social" href="https://www.linkedin.com/"><i
                class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <h4 class="text-white mb-3">Gallery</h4>
          <div class="row g-2 pt-2">
            <div class="col-4">
              <img class="img-fluid bg-light p-1" src="img/c1.jpg" alt="" />
            </div>
            <div class="col-4">
              <img class="img-fluid bg-light p-1" src="img/c2.jpg" alt="" />
            </div>
            <div class="col-4">
              <img class="img-fluid bg-light p-1" src="img/c3.jpg" alt="" />
            </div>
            <div class="col-4">
              <img class="img-fluid bg-light p-1" src="img/c4.jpg" alt="" />
            </div>
            <div class="col-4">
              <img class="img-fluid bg-light p-1" src="img/c5.jpg" alt="" />
            </div>
            <div class="col-4">
              <img class="img-fluid bg-light p-1" src="img/c6.jpg" alt="" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="copyright">
        <div class="row">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            &copy; <a class="border-bottom" href="#">STUpack</a>, All Right
            Reserved. Designed By
            <a class="border-bottom" href="https://htmlcodex.com">Avengers</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>


  <script src="js/main.js"></script>
</body>

</html>