<?php
session_start();

if (isset($_POST['logout'])) {

    session_destroy();

    header('Location: leclogin.php');
    exit();
}

if (!isset($_SESSION['id'])) {

    header('Location: leclogin.php');
    exit();
}
$selectedIndexNumber = isset($_SESSION['selectedIndexNumber']) ? $_SESSION['selectedIndexNumber'] : '';
$selectedSemester = isset($_SESSION['selectedSemester']) ? $_SESSION['selectedSemester'] : '';

if (isset($_POST['submit'])) {
    $selectedIndexNumber = $_POST['indexnumber'];
    $_SESSION['selectedIndexNumber'] = $selectedIndexNumber;
}

if (isset($_POST['semester'])) {
    $selectedSemester = $_POST['semester'];
    $_SESSION['selectedSemester'] = $selectedSemester;
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
                <a href="lecprofile.php" class="nav-item nav-link">Profile</a>
                <a href="#" class="nav-item nav-link active">Results</a>
                <a href="mail.html" class="nav-item nav-link">Modules</a>
            </div>
            <form method="post" action="">
                <button type="submit" name="logout" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Log Out <i
                        class="fa fa-arrow-left ms-3"></i></button>
            </form>
        </div>
    </nav>

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
                                <input type="submit" name="submit" value="Get details "
                                    class="btn btn-primary rounded-pill py-3 px-5">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <div class="container my-5">
        <?php
        include 'db.php';
        if ($selectedIndexNumber) {
            $indexnumber = $selectedIndexNumber;

            $query = "SELECT * FROM stupackdetails WHERE indexnumber = '$indexnumber'";
            $studentDetails = $conn->query($query);

            if ($studentDetails->num_rows > 0) {
                $studentRow = $studentDetails->fetch_assoc();
                if (isset($studentRow['profile_photo'])) {
                    $profileImage = $studentRow['profile_photo'];
                    if (!empty($profileImage)) {
                        echo '<img src="' . $profileImage . '" alt="Profile Image" class="img-fluid mb-3" style="max-width: 200px; border-radius: 10px;">';
                    }
                }
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



            $queryy = "SELECT DISTINCT semester FROM results WHERE indexnumber = '$indexnumber'";


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
        if ($selectedSemester) {
            if (isset($_POST['semester'])) {
                $indexnumber = $_POST['indexnumber'];
                $selectedSemester = $_POST['semester'];


                $query = "SELECT * FROM results WHERE indexnumber = '$indexnumber' AND semester = '$selectedSemester'";


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
        }

        ?>
    </div>


    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
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
                        <a class="btn btn-outline-light btn-social" href="https://twitter.com/"><i
                                class="fab fa-twitter"></i></a>
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

    <script>
        window.addEventListener('pageshow', function (event) {

            if (event.persisted) {

                window.location.reload();
            }
        });
    </script>
</body>


</html>