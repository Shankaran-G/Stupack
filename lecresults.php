<?php
session_start();

if (isset($_POST['logout'])) {
    // Destroy the session data
    session_destroy();
    // Redirect to the login page after logout
    header('Location: leclogin.php');
    exit();
}

if (!isset($_SESSION['id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: leclogin.php'); // Replace 'login.php' with your actual login page URL
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

    <style>
        .outtitle {
            font-size: 25px;
            color: #181d38;
            font-weight: bold;
            margin: 20px 0;
        }

        .showtitle {
            font-size: 23px;
            color: #124c64;
            font-weight: bold;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: center;
            padding: 10px;
        }
    </style>
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
                <a href="lecprofile.php" class="nav-item nav-link">Profile</a>
                <a href="#" class="nav-item nav-link active">Results</a>
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
                        Student Semester Results
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Testimonial Start -->

    <div class="container my-5">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-person-lines-fill" style=" font-size: 5rem; color: #00A1A7;"></i>


                    <form method="post">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="indexnumber" class="form-label">Enter Index Number</label>
                                <input type="text" name="indexnumber" id="indexnumber" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <input type="submit" name="submit" value="Get details " class="btn btn-primary rounded-pill py-3 px-5">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    </div>
    <div class="container my-5">
        <?php
        include 'db.php';

        if (isset($_POST['submit'])) {
            $indexnumber = $_POST['indexnumber'];

            // SQL query to fetch student details based on the input index number
            $query = "SELECT * FROM stupackdetails WHERE indexnumber = '$indexnumber'";

            // Execute the query
            $studentDetails = $conn->query($query);

            if ($studentDetails->num_rows > 0) {
                $studentRow = $studentDetails->fetch_assoc();
                echo '<p><strong class="outtitle"> Full Name: </strong><strong class="showtitle">' . $studentRow["fullname"] . '</strong></p>';
                echo '<p class="testimonial-text"><strong class="outtitle"> Index Number: </strong><strong class="showtitle">' . $studentRow["indexnumber"] . '</strong></p>';
                echo '<p class="testimonial-text"><strong class="outtitle"> Contact Number: </strong><strong class="showtitle">' . $studentRow["contactnumber"] . '</strong></p>';
                echo '<p class="testimonial-text"><strong class="outtitle"> Date Of Birth: </strong><strong class="showtitle">' . $studentRow["dob"] . '</strong></p>';
                echo '<p class="testimonial-text"><strong class="outtitle"> University Email: </strong><strong class="showtitle">' . $studentRow["uniemail"] . '</strong></p>';
                echo '<p class="testimonial-text"><strong class="outtitle"> Department: </strong><strong class="showtitle">' . $studentRow["department"] . '</strong></p>';
                echo '<p class="testimonial-text"><strong class="outtitle"> Batch Year: </strong><strong class="showtitle">' . $studentRow["batchyear"] . '</strong></p>';
            } else {
                echo "Student with the provided index number not found.";
            }
            echo "<div class='container my-5'>";
            echo "<div class='container text-center'>";
            echo "<div class='row justify-content-center'>";
            echo "<div class='col-lg-6'>";
            echo "<i class='bi bi-file-earmark-person' style='font-size: 5rem; color: #00A1A7;'></i>";


            // SQL query to fetch unique semesters for the student
            $queryy = "SELECT DISTINCT semester FROM results WHERE indexnumber = '$indexnumber'";

            // Execute the query
            $semesterResults = $conn->query($queryy);

            if ($semesterResults->num_rows > 0) {
                echo '<form method="post">';
                echo '<input type="hidden" name="indexnumber" value="' . $indexnumber . '">';
                echo '<select name="semester" class="form-select" onchange="this.form.submit()">';
                echo '<option value="" disabled selected>Select a Semester</option>';
                while ($semesterRow = $semesterResults->fetch_assoc()) {
                    $semester = $semesterRow['semester'];
                    echo "<option value='$semester'>$semester</option>";
                }
                echo '</select>';
                echo '</form>';
            } else {
                echo "No results found for this index number.";
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        if (isset($_POST['semester'])) {
            $indexnumber = $_POST['indexnumber']; // Get the index number from the form
            $selectedSemester = $_POST['semester'];

            // SQL query to fetch results for the selected semester
            $query = "SELECT * FROM results WHERE indexnumber = '$indexnumber' AND semester = '$selectedSemester'";

            // Execute the query
            $results = $conn->query($query);

            if ($results->num_rows > 0) {
                echo "<h4 class='my-4'>Results for Semester: $selectedSemester</h4>";
                echo "<table>";
                echo "<tr class='text-primary'>
                    <th class='outtitle'>Module Code</th>
                    <th class='outtitle'>Module Name</th>
                    <th class='outtitle'>Result</th>
                </tr>";

                while ($row = $results->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='showtitle'>" . $row['modulecode'] . "</td>";
                    echo "<td class='showtitle'>" . $row['modulename'] . "</td>";
                    echo "<td class='showtitle'>" . $row['results'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No results found for this semester.";
            }
        }
        ?>
    </div>

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


    <script src="js/main.js"></script>

    <script>
        window.addEventListener('pageshow', function(event) {
            // Check if the event's persisted property is set to true
            if (event.persisted) {
                // Redirect to the previous page without resubmitting the form
                window.location.reload();
            }
        });
    </script>
</body>


</html>