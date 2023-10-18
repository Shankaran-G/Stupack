<?php
session_start();

if (isset($_POST['logout'])) {
    // Destroy the session data
    session_destroy();
    // Redirect to the login page after logout
    header('Location: adminlogin.php');
    exit();
}

if (!isset($_SESSION['id'])) {
    header('Location: adminlogin.php'); // Redirect to the login page if not logged in
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
        .outtitle {
            font-size: 25px;
            /* Adjust the font size as needed */
            color: #181d38;
            /* Change the text color to your preference */
            font-weight: bold;
            /* Add bold font-weight */
            margin: 20px 0;
            /* Add margin to create space around the element */
            font-family: 'Arial Black', sans-serif;
        }

        .showtitle {
            font-size: 23px;
            /* Adjust the font size as needed */
            color: #124c64;
            /* Change the text color to your preference */
            font-weight: bold;
            /* Add bold font-weight */
            margin: 20px 0;
            /* Add margin to create space around the element */
            font-family: 'Arial Black', sans-serif;
        }
    </style>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
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
                <a href="adminresults.php" class="nav-item nav-link">Results</a>
                <a href="upload.php" class="nav-item nav-link">Upload</a>
                <a href="mail.html" class="nav-item nav-link">Notification</a>
            </div>
            <form method="post" action="">
                <button type="submit" name="logout" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Log Out <i class="fa fa-arrow-left ms-3"></i></button>
            </form>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">
                        <?php
                        $id = $_SESSION['id'];

                        include 'db.php';
                        $sql = "SELECT * FROM lecdetails WHERE id ='$id' ";
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


    <!-- Testimonial Start -->
    <section class="section">
        <div class="container">
            <div class="row">
                <?php

                $id = $_SESSION['id'];

                include 'db.php';
                $sql = "SELECT * FROM lecdetails WHERE id ='$id' ";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    // echo '<div class="col-lg-4 col-md-6">';
                    // echo '<div class="testimonial-box">';
                    echo '<p><strong class="outtitle"> Full Name: </strong><strong class="showtitle">' . $row["fullname"] . '</strong></p>'; // Replace with your column names
                    //echo '<p class="testimonial-text"><strong class="outtitle"> Index Number: </strong><strong class="showtitle">' . $row["indexnumber"] . '</strong></p>';
                    // echo '<p class="testimonial-text"><strong class="outtitle"> Contact Number: </strong><strong class="showtitle">' . $row["contactnumber"] . '</strong></p>';
                    // echo '<p class="testimonial-text"><strong class="outtitle"> Date Of Birth: </strong><strong class="showtitle">' . $row["dob"] . '</p>';
                    //echo '<p class="testimonial-text"><strong class="outtitle"> University Email: </strong><strong class="showtitle">' . $row["uniemail"] . '</strong></p>';
                    // echo '<p class="testimonial-text"><strong class="outtitle"> Department: </strong><strong class="showtitle">' . $row["department"] . '</strong></p>';
                    //echo '<p class="testimonial-text"><strong class="outtitle"> Batch Year: </strong><strong class="showtitle">' . $row["batchyear"] . '</strong></p>';
                    // echo '<p class="testimonial-text">' . $row[""] . '</p>';
                    // echo '</div>';
                    // echo '</div>';
                } else {
                    echo "No records found.";
                }

                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>
    <!-- Testimonial End -->



    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="about.html">About Us</a>
                    <a class="btn btn-link" href="contact.html">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
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
                        <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
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
                            <img class="img-fluid bg-light p-1" src="img/c2.jpg" alt="" />
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/c3.jpg" alt="" />
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/c1.jpg" alt="" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Comments</h4>
                    <p>If you have any comments feel free to tell.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email" />
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">STUpack</a>, All Right
                        Reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By
                        <a class="border-bottom" href="https://htmlcodex.com">Avengers</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>