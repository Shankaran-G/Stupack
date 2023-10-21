<?php
session_start();
include 'db.php';

if (isset($_POST['logout'])) {
    // Destroy the session data
    session_destroy();
    // Redirect to the login page after logout
    header('Location: adminlogin.php');
    exit();
}

if (!isset($_SESSION['id'])) {
    header('Location: adminlogin.php');
    exit();
}

if (isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];

    $upload_directory = 'csvfiles/';
    $file_path = $upload_directory . $file_name;

    if (move_uploaded_file($file_tmp, $file_path)) {
        $db = new mysqli('localhost', 'root', '', 'stupack');

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $queryCheckID = "SELECT id FROM lecdetails WHERE id = ?";
        $stmtCheckID = $db->prepare($queryCheckID);

        $queryInsert = "INSERT INTO lecdetails (id, fullname, name, password, email) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $db->prepare($queryInsert);

        if ($stmtCheckID && $stmtInsert) {
            $handle = fopen($file_path, "r");
            if ($handle !== FALSE) {
                $firstRow = true; // Flag to identify the first row
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    if ($firstRow) {
                        // Skip the first row
                        $firstRow = false;
                        continue;
                    }
                    $id = $data[0];

                    // Check if ID already exists
                    $stmtCheckID->bind_param('s', $id);
                    $stmtCheckID->execute();
                    $stmtCheckID->store_result();

                    if ($stmtCheckID->num_rows == 0) {
                        // ID is not in the database, insert the row
                        $id = $data[0];
                        $fullname = $data[1];
                        $name = $data[2];
                        $password = $data[3];
                        $email = $data[4];


                        $stmtInsert->bind_param('sssss', $id, $fullname, $name, $password, $email);
                        $stmtInsert->execute();
                        echo 'Insert Succussfully';
                    }
                }
                fclose($handle);
            }

            $stmtCheckID->close();
            $stmtInsert->close();
        }

        $db->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Handle file upload
        if (isset($_FILES['profile_photo'])) {
            $file = $_FILES['profile_photo'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];

            $upload_directory = 'acdemicuploads/';
            $file_path = $upload_directory . $file_name;


            if (move_uploaded_file($file_tmp, $file_path)) {
                $db = new mysqli('localhost', 'root', '', 'stupack');
                $query = "SELECT id FROM lecdetails WHERE id = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param('s', $id);
                $stmt->execute();
                $stmt->store_result();

                if (!empty($existingPhotoPath)) {
                    // Display the existing profile photo
                    echo '<img src="' . $existingPhotoPath . '" alt="Profile Photo" style="max-width: 200px;" /><br>';

                    // Provide a delete button
                    echo '<form method="post" action="upload.php">';
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                    echo '<input type="hidden" name="delete_existing" value="true">';
                    echo '<button type="submit" name="delete" class="btn btn-danger">Delete Existing Photo</button>';
                    echo '</form>';
                }

                if (isset($_POST['delete_existing'])) {
                    // User wants to delete the existing photo
                    unlink($existingPhotoPath); // Delete the file from the server
                    $stmt->close();
                    // Continue with the rest of the code to handle the file upload
                } else {
                    // Continue with the rest of the code to handle the file upload
                }

                if ($stmt->num_rows > 0) {
                    $stmt->close();
                    $update_query = "UPDATE lecdetails SET profile_photo = ? WHERE id = ?";
                    $update_stmt = $db->prepare($update_query);
                    $update_stmt->bind_param('ss', $file_path, $id);
                    $update_stmt->execute();
                    //$message = "Profile photo updated successfully.";
                } else {
                    $insert_query = "INSERT INTO stupackdetails (indexnumber, profile_photo) VALUES (?, ?)";
                    $insert_stmt = $db->prepare($insert_query);
                    $insert_stmt->bind_param('ss', $indexnumber, $file_path);
                    $insert_stmt->execute();
                    $message = "New record created with the profile photo.";
                }

                $db->close();
                // echo '<script type="text/javascript">';
                // echo 'alert("' . $message . '");';
                // echo 'window.location.href = "profile.php";';
                // echo '</script>';
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("Error uploading profile photo.");';
                echo 'window.location.href = "upload.php";';
                echo '</script>';
            }
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
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet" />

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
        /* Center the form horizontally */
        .centered-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 20vh;
        }

        /* Style for each form field */
        .form-field {
            margin: 20px 20px;
            text-align: center;
        }
    </style>

    <style>
        .outtitle {
            font-size: 23px;
            color: #181d38;
            font-weight: bold;
            margin: 20px 0;
        }

        .showtitle {
            font-size: 20px;
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

        .upload {
            border: 2px dashed black;
            border-radius: 15px;
            margin: 15px;
            padding: 10px;
            width: 80%;
            display: flex;
            justify-content: center;
            box-shadow: 0px 6px 15px black;
        }

        input {
            margin-top: 10px;
            margin-bottom: 10px;
            box-shadow: 0px 6px 15px black;
            border: 1px solid grey;
            padding: 8px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
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
                <a href="adminprofile.php" class="nav-item nav-link">Profile</a>
                <a href="adminresults.php" class="nav-item nav-link">Results</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Uploads</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="upload.php" class="dropdown-item active">Staff Upload</a>
                        <a href="studentupload.php" class="dropdown-item">Students Upload</a>
                    </div>
                </div>
                <a href="mail.html" class="nav-item nav-link">Notification</a>

                <form method="post" action="">
                    <button type="submit" name="logout" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Log Out
                        <i class="fa fa-arrow-left ms-3"></i></button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">
                        Acedemic Staff Details Upload
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Testimonial Start -->

    <!-- Service Start -->
    <div class="container-fluid py-5 mb-3" style="background-color: #f2f2f2;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 1</h5>
                            <p>Upload your Staff Details.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 2</h5>
                            <p>Select CSV File From Your Device.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 3</h5>
                            <p>The File Must be .CSV File Format</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 4</h5>
                            <p>Avoid Repeat Records In The File.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Start -->
    <div class=" wow fadeInUp" data-wow-delay="0.1s">
        <center>
            <div class="upload">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <!-- Upload CSV File -->
                    <div class="form-field">
                        <label for="csv_file">Upload CSV File: </label>
                        <input type="file" name="csv_file" id="csv_file">
                    </div>

                    <!-- Submit CSV File Button -->
                    <div class="form-field">
                        <input type="submit" name="submit_csv_file" value="Upload CSV File">
                    </div>
                </form>

            </div>
        </center>
    </div>
    <br />
    <div class="container-fluid py-5 mb-3" style="background-color: #f2f2f2;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 5</h5>
                            <p>Upload Staff Profile Image.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 6</h5>
                            <p>Select Profile Picture From Device.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 7</h5>
                            <p>The Formats Are .jpg, .jpeg, .png</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 8</h5>
                            <p>Avoid Not Clear Image.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" wow fadeInUp" data-wow-delay="0.1s">
        <center>
            <div class="upload">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-field">
                        <label for="id">Id:</label>
                        <input type="text" name="id" id="id" required>
                    </div>

                    <!-- Upload Profile Photo -->
                    <div class="form-field">
                        <label for="profile_photo">Profile Photo:</label>
                        <input type="file" name="profile_photo" id="profile_photo" accept=".jpg, .jpeg, .png" required>
                    </div>

                    <!-- Submit Profile Photo Button -->
                    <div class="form-field">
                        <input type="submit" name="submit_profile_photo" value="Upload Profile Photo">
                    </div>
                </form>
            </div>
        </center>
    </div>

    <div class="container-fluid py-5 mb-3" style="background-color: #f2f2f2;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 9</h5>
                            <p>Click Get Details To Get Student Records.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 10</h5>
                            <p>Check The Records And Find Any Mistake Update Them.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 11</h5>
                            <p>Select The Field then Fill The Update Value Then Submit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 12</h5>
                            <p>Change The Profile Picture By Reupload.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" wow fadeInUp" data-wow-delay="0.1s">
        <div class="container my-5">
            <?php
            include 'db.php';
            echo "<div class='container my-5'>";
            echo "<div class='container text-center'>";
            echo "<div class='row justify-content-center'>";
            echo "<div class='col-lg-6'>";
            echo "<i class='bi bi-file-earmark-person' style='font-size: 5rem; color: #00A1A7;'></i>";
            echo '<form method="post">';
            echo '<button type="submit" name="get_details" class="btn btn-primary">Get Details</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            if (isset($_POST['get_details'])) {
                echo "<h4 class='my-4'>Lecturer Details</h4>";
                echo "<table>";
                echo "<tr class='text-primary'>
            <th class='outtitle'>ID</th>
            <th class='outtitle'>Full Name</th>
            <th class='outtitle'>Name</th>
            <th class='outtitle'>Password</th>
            <th class='outtitle'>Email</th>
            <th class='outtitle'>Change Data</th>
        </tr>";

                // SQL query to fetch data from lecdetails table
                $query = "SELECT id, fullname, name, password, email FROM lecdetails";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='showtitle'>" . $row['id'] . "</td>";
                        echo "<td class='showtitle'>" . $row['fullname'] . "</td>";
                        echo "<td class='showtitle'>" . $row['name'] . "</td>";
                        echo "<td class='showtitle'>" . $row['password'] . "</td>";
                        echo "<td class='showtitle'>" . $row['email'] . "</td>";
                        echo "<td class='showtitle'>
                    <form method='post'>
                        <input type='hidden' name='change_id' value='" . $row['id'] . "'>
                        <select name='change_column'>
                            <option value='fullname'>Full Name</option>
                            <option value='name'>Name</option>
                            <option value='password'>Password</option>
                            <option value='email'>Email</option>
                        </select>
                        <input type='text' name='new_data'>
                        <button type='submit' name='update_data'>Update</button>
                    </form>
                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No data found in the lecdetails table.</td></tr>";
                }

                echo "</table>";
            }

            if (isset($_POST['update_data'])) {
                // Get the values from the form
                $change_id = $_POST['change_id'];
                $change_column = $_POST['change_column'];
                $new_data = $_POST['new_data'];

                // SQL query to update data in lecdetails table
                $update_query = "UPDATE lecdetails SET $change_column = '$new_data' WHERE id = '$change_id'";
                if ($conn->query($update_query) === TRUE) {
                    echo "Data updated successfully!";
                } else {
                    echo "Error updating data: " . $conn->error;
                }
            }
            ?>
        </div>
    </div>

    <!-- Testimonial End -->

    <!-- Footer Start -->
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