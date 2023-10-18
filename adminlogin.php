<?php
include "db.php";

session_start();
if (isset($_COOKIE['adminid']) && isset($_COOKIE['adminpassword'])) {
    $adminid = $_COOKIE['adminid'];
    $adminpassword = $_COOKIE['adminpassword'];
} else {
    $adminid = '';
    $adminpassword = '';
}

if (isset($_POST['login_Btn']) && isset($_POST['id']) && isset($_POST['password'])) {
    $id = $_POST['id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM lecdetails WHERE id = '$id'";
    $results = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($results)) {
        $resultPassword = $row['password'];
        if ($password == $resultPassword) {
            $_SESSION['id'] = $id;
            if (isset($_POST['remember_me'])) {

                setcookie("adminid", $id, time() + 3600 * 24 * 30, "/");
                setcookie("adminpassword", $password, time() + 3600 * 24 * 30, "/");
            } else {
                // Clear the "Remember Me" cookies
                // setcookie("remembered_username", "", time() - 3600 * 24 * 30, "/");
                // setcookie("remembered_password", "", time() - 3600 * 24 * 30, "/");
            }
            header('Location:adminprofile.php');
            exit();
        } else {
            echo "<script>
        alert('Login unsuccessfull');
      </script>";
        }
    }
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
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>STUpack</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="team.html" class="nav-item nav-link">Our Team</a>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <div class="dropdown" style="background-color: #06bbcc">
                <a href="#" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block nav-link dropdown-toggle">Login Now<i></i></a>
                <div class="dropdown-menu fade-dowm m-0" style="background-color: #06bbcc; border: 2px solid #06bbcc">
                    <a href="login.php" class="dropdown btn btn-primary py-4 px-lg-4 d-lg-block" style="color: rgb(255, 255, 255)">Login as student<i class="fa fa-arrow-right ms-3"></i></a>
                    <a href="leclogin.php" class="dropdown btn btn-primary py-4 px-lg-4 d-lg-block" style="color: rgb(255, 255, 255)">Login as lecturer<i class="fa fa-arrow-right ms-3"></i></a>
                    <a href="adminlogin.php" class="dropdown btn btn-primary py-4 px-lg-4 d-lg-block" style="color: rgb(255, 255, 255)">Login as Admin<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">
                        Welcome to Admin Login
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-key display-1 text-primary"></i>
                    <h1 class="display-1"></h1>
                    <h1 class="mb-4">Login</h1>
                    <p class="mb-4">Create your own way</p>
                    <form action="#" method="POST">
                        <div class="mb-3">
                            <input type="text" name="id" id="id" class="form-control" placeholder="Use your University Identity Number" required value="<?php echo $adminid; ?>" />
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Use your Stupack Password" required value="<?php echo $adminpassword; ?>" />
                        </div>
                        <div class="mb-4">
                            <label for="remember_me">Remember Me</label>
                            <input type="checkbox" name="remember_me" id="remember_me" value="1">
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill py-3 px-5" name="login_Btn">
                            Log In
                        </button>
                    </form>
                    <p class="mt-3">
                        <a href="index.html">Go Back To Home</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

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