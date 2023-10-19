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
    header('Location: adminlogin.php'); // Redirect to the login page if not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['indexnumber'])) {
        $indexnumber = $_POST['indexnumber'];

        // Handle file upload
        if (isset($_FILES['profile_photo'])) {
            $file = $_FILES['profile_photo'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];

            $upload_directory = 'uploads/';

            $file_path = $upload_directory . $file_name;
            if (move_uploaded_file($file_tmp, $file_path)) {
                $db = new mysqli('localhost', 'root', '', 'stupack');
                $query = "SELECT indexnumber FROM stupackdetails WHERE indexnumber = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param('s', $indexnumber);
                $stmt->execute();
                $stmt->store_result();

                if (!empty($existingPhotoPath)) {
                    // Display the existing profile photo
                    echo '<img src="' . $existingPhotoPath . '" alt="Profile Photo" style="max-width: 200px;" /><br>';

                    // Provide a delete button
                    echo '<form method="post" action="upload.php">';
                    echo '<input type="hidden" name="indexnumber" value="' . $indexnumber . '">';
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
                    $update_query = "UPDATE stupackdetails SET profile_photo = ? WHERE indexnumber = ?";
                    $update_stmt = $db->prepare($update_query);
                    $update_stmt->bind_param('ss', $file_path, $indexnumber);
                    $update_stmt->execute();
                    //$message = "Profile photo updated successfully.";
                } else {
                    // $insert_query = "INSERT INTO stupackdetails (indexnumber, profile_photo) VALUES (?, ?)";
                    // $insert_stmt = $db->prepare($insert_query);
                    // $insert_stmt->bind_param('ss', $indexnumber, $file_path);
                    // $insert_stmt->execute();
                    // //$message = "New record created with the profile photo.";
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
            font-size: 18px;
            color: #181d38;
            font-weight: bold;
            margin: 20px 0;
        }

        .showtitle {
            font-size: 15px;
            color: #124c64;
            font-weight: bold;
            margin: 20px 0;
        }

        .outresult {
            font-size: 20px;
            color: #181d38;
            font-weight: bold;
            margin: 20px 0;
        }

        .showresult {
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
                        <a href="upload.php" class="dropdown-item">Staff Upload</a>
                        <a href="studentupload.php" class="dropdown-item active">Students Upload</a>
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
                        Student Details Upload
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Upload Details CSV -->

    <div class="container-fluid py-5 mb-3" style="background-color: #f2f2f2;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 1</h5>
                            <p>Upload your Student Details.</p>
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
    <div class=" wow fadeInUp" data-wow-delay="0.1s">
        <center>
            <div class="upload">
                <form action="studentupload.php" method="post" enctype="multipart/form-data">
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
    <?php
    if (isset($_POST['submit_csv_file'])) { // Check if the form is submitted
        if (isset($_FILES['csv_file'])) {
            $file = $_FILES['csv_file'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];

            $upload_directory = 'stuCsvfiles/';
            $file_path = $upload_directory . $file_name;

            if (move_uploaded_file($file_tmp, $file_path)) {
                $db = new mysqli('localhost', 'root', '', 'stupack'); // Update database credentials as needed
    
                if ($db->connect_error) {
                    die("Connection failed: " . $db->connect_error);
                }

                $queryInsert = "INSERT INTO stupackdetails (indexnumber, name, fullname, password, contactnumber, uniemail, address, dob, department, batchyear, scholarship) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtInsert = $db->prepare($queryInsert);

                if ($stmtInsert) {
                    $handle = fopen($file_path, "r");
                    $firstRow = true; // To skip the first row
    
                    if ($handle !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                            if ($firstRow) {
                                $firstRow = false; // Skip the first row
                                continue;
                            }

                            $indexnumber = $data[0];

                            // Check if the index number already exists in the database
                            $checkQuery = "SELECT COUNT(*) as count FROM stupackdetails WHERE indexnumber = ?";
                            $stmtCheck = $db->prepare($checkQuery);
                            $stmtCheck->bind_param('s', $indexnumber);
                            $stmtCheck->execute();
                            $resultCheck = $stmtCheck->get_result();
                            $stmtCheck->close();
                            $rowCheck = $resultCheck->fetch_assoc();

                            // If the index number doesn't exist, insert the row
                            if ($rowCheck['count'] == 0) {
                                $name = $data[1];
                                $fullname = $data[2];
                                $password = $data[3];
                                $contactnumber = $data[4];
                                $uniemail = $data[5];
                                $address = $data[6];
                                $dob = $data[7];
                                $department = $data[8];
                                $batchyear = $data[9];
                                $scholarship = $data[10];

                                $stmtInsert->bind_param('sssssssssss', $indexnumber, $name, $fullname, $password, $contactnumber, $uniemail, $address, $dob, $department, $batchyear, $scholarship);
                                $stmtInsert->execute();
                            }
                        }
                        fclose($handle);
                    }

                    $stmtInsert->close();
                    echo '<div style="text-align: center; margin-top: 20px;">Data inserted successfully!</div>';
                } else {
                    echo "Prepare statement error: " . $db->error;
                }

                $db->close();
            }
        }
    }
    ?>
    <!-- END Upload Details CSV -->
    <br />
    <!-- Upload Profile CSV -->
    <div class="container-fluid py-5 mb-3" style="background-color: #f2f2f2;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 5</h5>
                            <p>Upload Student Profile Image.</p>
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
                <form action="studentupload.php" method="post">
                    <div class="form-field">
                        <label for="indexnumber">Index Number:</label>
                        <input type="text" name="indexnumber" id="indexnumber" required>
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
    <!-- End Profile CSV -->

    <!-- Start Results CSV -->
    <div class="container-fluid py-5 mb-3" style="background-color: #f2f2f2;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 9</h5>
                            <p>Upload Student Results .</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 10</h5>
                            <p>Select Results File From Device.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 11</h5>
                            <p>The File Formats Must Be .CSV</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 12</h5>
                            <p>Recheck The Resilts Before Insert.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" wow fadeInUp" data-wow-delay="0.1s">
        <center>
            <div class="upload">
                <form action="studentupload.php" method="post" enctype="multipart/form-data">
                    <!-- Upload CSV File -->
                    <div class="form-field">
                        <label for="result_file">Upload Results CSV File: </label>
                        <input type="file" name="result_file" id="result_file">
                    </div>

                    <!-- Submit CSV File Button -->
                    <div class="form-field">
                        <input type="submit" name="submit_results_file" value="Upload Results CSV File">
                    </div>
                </form>
            </div>
        </center>
    </div>
    <?php

    if (isset($_POST['submit_results_file'])) { // Check if the form is submitted
        if (isset($_FILES['result_file'])) {
            $file = $_FILES['result_file'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];

            $upload_directory = 'stuResults/';
            $file_path = $upload_directory . $file_name;

            if (move_uploaded_file($file_tmp, $file_path)) {
                $db = new mysqli('localhost', 'root', '', 'stupack'); // Update database credentials as needed
    
                if ($db->connect_error) {
                    die("Connection failed: " . $db->connect_error);
                }

                $queryInsert = "INSERT INTO results (indexnumber, semester, modulecode, modulename, results) VALUES (?, ?, ?, ?, ?)";
                $stmtInsert = $db->prepare($queryInsert);

                if ($stmtInsert) {
                    $handle = fopen($file_path, "r");
                    $firstRow = true; // To skip the first row
    
                    if ($handle !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                            if ($firstRow) {
                                $firstRow = false; // Skip the first row
                                continue;
                            }

                            $indexnumber = $data[0];
                            $modulecode = $data[2];

                            // Check if a row with the same indexnumber and modulecode already exists
                            $checkQuery = "SELECT indexnumber FROM results WHERE indexnumber = ? AND modulecode = ?";
                            $checkStmt = $db->prepare($checkQuery);
                            $checkStmt->bind_param('ss', $indexnumber, $modulecode);
                            $checkStmt->execute();
                            $checkStmt->store_result();


                            if ($checkStmt->num_rows == 0) {
                                $indexnumber = $data[0];
                                $semester = $data[1];
                                $modulecode = $data[2];
                                $modulename = $data[3];
                                $results = $data[4];
                                $stmtInsert->bind_param('sssss', $indexnumber, $semester, $modulecode, $modulename, $results);
                                $stmtInsert->execute();
                                $stmtInsert->close();
                                echo '<div style="text-align: center; margin-top: 20px;">Data inserted successfully!</div>';
                            } else {

                            }
                            $checkStmt->close();
                        }
                        fclose($handle);
                    }


                }

                $db->close();
            }
        }
    }

    ?>

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
            echo '<button type="submit" name="getresults" class="btn btn-primary">Get Results</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            if (isset($_POST['getresults'])) {
                echo "<h4 class='my-4'>Student Results</h4>";
                echo "<table>";
                echo "<tr class='text-primary'>
                <th class='outresult'>Indexnumber</th>
                <th class='outresult'>Semester</th>
                <th class='outresult'>Modulecode</th>
                <th class='outresult'>Modulename</th>
                <th class='outresult'>Results</th>
            </tr>";

                // SQL query to fetch data from stupackdetails table
                $query = "SELECT indexnumber, semester, modulecode, modulename, results FROM results";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='showresult'>" . $row['indexnumber'] . "</td>";
                        echo "<td class='showresult'>" . $row['semester'] . "</td>";
                        echo "<td class='showresult'>" . $row['modulecode'] . "</td>";
                        echo "<td class='showresult'>" . $row['modulename'] . "</td>";
                        echo "<td class='showresult'>" . $row['results'] . "</td>";
                        echo "<td class='showresult'>
                        <form method='post'>
                            <input type='hidden' name='change_result_indexnumber' value='" . $row['indexnumber'] . "'>
                            <select name='change_result_column'>
                                <option value='indexnumber'>Indexnumber</option>
                                <option value='semester'>Semester</option>
                                <option value='modulecode'>Modulecode</option>
                                <option value='modulename'>Modulename </option>
                                <option value='results'>Results</option>
                                
                            </select>
                            <input type='text' name='new_result'>
                            <button type='submit' name='update_result'>Update</button>
                        </form>
                    </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No data found in the results table.</td></tr>";
                }

                echo "</table>";
            }

            if (isset($_POST['update_result'])) {
                // Get the values from the form
                $change_result_indexnumber = $_POST['change_result_indexnumber'];
                $change_result_column = $_POST['change_result_column'];
                $new_result = $_POST['new_result'];

                // SQL query to update data in stupackdetails table
                $update_query = "UPDATE results SET $change_result_column = ? WHERE indexnumber = ?";
                $stmtUpdate = $conn->prepare($update_query);

                if ($stmtUpdate) {
                    $stmtUpdate->bind_param('ss', $new_result, $change_result_indexnumber);
                    if ($stmtUpdate->execute()) {
                        echo "Data updated successfully!";
                    } else {
                        echo "Error updating data: " . $stmtUpdate->error;
                    }
                    $stmtUpdate->close();
                }
            }
            ?>
        </div>
    </div>


    <!-- End Results CSV -->

    <!-- Start Show Details CSV -->
    <div class="container-fluid py-5 mb-3" style="background-color: #f2f2f2;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 13</h5>
                            <p>Click Get Details To Get Student Records.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 14</h5>
                            <p>Check The Records And Find Any Mistake Update Them.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 15</h5>
                            <p>Select The Field then Fill The Update Value Then Submit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 16</h5>
                            <p>Change The Profile Picture By Reupload.</p>
                        </div>
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
            echo '<button type="submit" name="getdetails" class="btn btn-primary">Get Details</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            if (isset($_POST['getdetails'])) {
                echo "<h4 class='my-4'>Student Details</h4>";
                echo "<table>";
                echo "<tr class='text-primary'>
                <th class='outtitle'>ID</th>
                <th class='outtitle'>Full Name</th>
                <th class='outtitle'>Name</th>
                <th class='outtitle'>Password</th>
                <th class='outtitle'>Contact Number</th>
                <th class='outtitle'>University Email</th>
                <th class='outtitle'>Address</th>
                <th class='outtitle'>Date of Birth</th>
                <th class='outtitle'>Department</th>
                <th class='outtitle'>Batch Year</th>
                <th class='outtitle'>Scholarship</th>
                <th class='outtitle'>Update Data</th>
            </tr>";

                // SQL query to fetch data from stupackdetails table
                $query = "SELECT indexnumber, name, fullname, password, contactnumber, uniemail, address, dob, department, batchyear, scholarship FROM stupackdetails";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='showtitle'>" . $row['indexnumber'] . "</td>";
                        echo "<td class='showtitle'>" . $row['fullname'] . "</td>";
                        echo "<td class='showtitle'>" . $row['name'] . "</td>";
                        echo "<td class='showtitle'>" . $row['password'] . "</td>";
                        echo "<td class='showtitle'>" . $row['contactnumber'] . "</td>";
                        echo "<td class='showtitle'>" . $row['uniemail'] . "</td>";
                        echo "<td class='showtitle'>" . $row['address'] . "</td>";
                        echo "<td class='showtitle'>" . $row['dob'] . "</td>";
                        echo "<td class='showtitle'>" . $row['department'] . "</td>";
                        echo "<td class='showtitle'>" . $row['batchyear'] . "</td>";
                        echo "<td class='showtitle'>" . $row['scholarship'] . "</td>";
                        echo "<td class='showtitle'>
                        <form method='post'>
                            <input type='hidden' name='change_indexnumber' value='" . $row['indexnumber'] . "'>
                            <select name='change_column'>
                                <option value='name'>Name</option>
                                <option value='fullname'>Full Name</option>
                                <option value='password'>Password</option>
                                <option value='contactnumber'>Contact Number</option>
                                <option value='uniemail'>University Email</option>
                                <option value='address'>Address</option>
                                <option value='dob'>Date of Birth</option>
                                <option value='department'>Department</option>
                                <option value='batchyear'>Batch Year</option>
                                <option value='scholarship'>Scholarship</option>
                            </select>
                            <input type='text' name='new_data'>
                            <button type='submit' name='update_data'>Update</button>
                        </form>
                    </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No data found in the stupackdetails table.</td></tr>";
                }

                echo "</table>";
            }

            if (isset($_POST['update_data'])) {
                // Get the values from the form
                $change_indexnumber = $_POST['change_indexnumber'];
                $change_column = $_POST['change_column'];
                $new_data = $_POST['new_data'];

                // SQL query to update data in stupackdetails table
                $update_query = "UPDATE stupackdetails SET $change_column = ? WHERE indexnumber = ?";
                $stmtUpdate = $conn->prepare($update_query);

                if ($stmtUpdate) {
                    $stmtUpdate->bind_param('ss', $new_data, $change_indexnumber);
                    if ($stmtUpdate->execute()) {
                        echo "Data updated successfully!";
                    } else {
                        echo "Error updating data: " . $stmtUpdate->error;
                    }
                    $stmtUpdate->close();
                }
            }
            ?>
        </div>
    </div>
    <!-- Start Show Details CSV -->



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
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text"
                            placeholder="Your email" />
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