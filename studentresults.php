<?php
session_start();
include 'db.php';

if (isset($_POST['logout'])) {

    session_destroy();

    header('Location: adminlogin.php');
    exit();
}

if (!isset($_SESSION['id'])) {
    header('Location: adminlogin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_table'])) {
    $table_name = $_POST['table_name'];

    $db = new mysqli('localhost', 'root', '', 'stupack');

    $table_name = mysqli_real_escape_string($db, $table_name);



    $queryCreateTable = "CREATE TABLE IF NOT EXISTS $table_name (
        indexnumber VARCHAR(255) NOT NULL,
        modulecode VARCHAR(255) NOT NULL,
        modulename VARCHAR(255) NOT NULL,
        results VARCHAR(255) NOT NULL,
        semester VARCHAR(255) NOT NULL
    )";


    if ($db->query($queryCreateTable) === TRUE) {
        $dialogMessage = 'Table "' . $table_name . '" created successfully!';
        $dialogType = 'success';
    } else {
        $dialogMessage = 'Error creating table: ' . $db->error;
        $dialogType = 'error';
    }
    $db->close();
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
    <script>
        function closeResults() {
            document.querySelector('table').style.display = 'none';
            document.getElementById('closeResultsBtn').style.display = 'none';
        }
    </script>
    <link href="css/style.css" rel="stylesheet" />
    <style>
        .dialog {
            padding: 10px;
            margin: 10px;
            border: 1px solid;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .centered-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 20vh;
        }


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

        .glow-on-hover {
            width: 220px;
            height: 50px;
            border: none;
            outline: none;
            color: #fff;
            background: #111;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 10px;
            justify-content: center;
        }

        .glow-on-hover:before {
            content: '';
            background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 400%;
            z-index: -1;
            filter: blur(5px);
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            animation: glowing 20s linear infinite;
            opacity: 0;
            transition: opacity .3s ease-in-out;
            border-radius: 10px;
            justify-content: center;
        }

        .glow-on-hover:active {
            color: #000
        }

        .glow-on-hover:active:after {
            background: transparent;
        }

        .glow-on-hover:hover:before {
            opacity: 1;
        }

        .glow-on-hover:after {
            z-index: -1;
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: #111;
            left: 0;
            top: 0;
            border-radius: 10px;
        }

        @keyframes glowing {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 400% 0;
            }

            100% {
                background-position: 0 0;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <a href="adminprofile.php" class="nav-item nav-link">Profile</a>
                <a href="adminresults.php" class="nav-item nav-link">Results</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Uploads</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="upload.php" class="dropdown-item">Staff Upload</a>
                        <a href="studentupload.php" class="dropdown-item">Students Upload</a>
                        <a href="studentresults.php" class="dropdown-item active">Results Upload</a>
                    </div>
                </div>
                <a href="mail.html" class="nav-item nav-link">Modules</a>

                <form method="post" action="">
                    <button type="submit" name="logout" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Log Out
                        <i class="fa fa-arrow-left ms-3"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">
                        Student Results Upload
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class=" wow fadeInUp" data-wow-delay="0.1s">
        <center>
            <div class="upload">
                <form method="post" action="">
                    <label for="table_name">Enter Table Name:</label>
                    <input type="text" name="table_name" required>
                    <div class="form-field">
                        <button type="submit" name="create_table">Create Table</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <div class=" wow fadeInUp" data-wow-delay="0.1s">
        <?php if (isset($dialogMessage) && isset($dialogType)): ?>
            <div id="dialogBox" class="dialog <?= $dialogType ?>">
                <?= $dialogMessage ?>
            </div>
            <script>
                setTimeout(function () {
                    document.getElementById('dialogBox').style.display = 'none';
                }, 3000);
            </script>
        <?php endif; ?>
    </div>
    <div class="container-fluid py-5 mb-3" style="background-color: #f2f2f2;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 1</h5>
                            <p>Upload Student Results From Device .</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 2</h5>
                            <p>The Upload Time Its Load The Page Just Refresh It.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 3</h5>
                            <p>After Refresh You Get The Insertation Reply</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-space-shuttle" style="font-size:48px;color: #124c64"></i>
                            <h5 class="mb-3">Instruction 4</h5>
                            <p>Recheck The Inseration By Click The Get Results.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" wow fadeInUp" data-wow-delay="0.1s">
        <center>
            <div>
                <a href="https://convertio.co/xlsx-csv/" target="_blank">
                    <button type="button" class="glow-on-hover">Click to Online Converter</button>
                </a>
            </div>
        </center>
    </div>

    <div class=" wow fadeInUp" data-wow-delay="0.1s">
        <center>
            <div class="upload">
                <form action="studentresults.php" method="post" enctype="multipart/form-data">

                    <div class="form-field">
                        <label for="result_file">Upload Results CSV File: </label>
                        <input type="file" name="result_file" id="result_file">
                    </div>
                    <label for="selected_table">Select Table:</label>
                    <select name="selected_table" required>
                        <?php
                        $db = new mysqli('localhost', 'root', '', 'stupack');
                        $result = $db->query("SHOW TABLES");
                        while ($row = $result->fetch_row()) {
                            echo "<option value='{$row[0]}'>{$row[0]}</option>";
                        }
                        $db->close();
                        ?>
                    </select>

                    <div class="form-field">
                        <input type="submit" name="submit_results_file" value="Upload Results CSV File">
                    </div>
                </form>
            </div>
        </center>
    </div>
    <?php
    if (isset($_POST['submit_results_file'])) {
        if (isset($_FILES['result_file']) && isset($_POST['selected_table'])) {
            $table_name = $_POST['selected_table'];
            $file = $_FILES['result_file'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];

            $upload_directory = 'stuResults/';
            $file_path = $upload_directory . $file_name;

            if (move_uploaded_file($file_tmp, $file_path)) {
                $db = new mysqli('localhost', 'root', '', 'stupack');

                if ($db->connect_error) {
                    die("Connection failed: " . $db->connect_error);
                }

                $queryInsert = "INSERT INTO $table_name (indexnumber, semester, modulecode, modulename, results) VALUES (?, ?, ?, ?, ?)";
                $stmtInsert = $db->prepare($queryInsert);

                if ($stmtInsert) {
                    $handle = fopen($file_path, "r");
                    $firstRow = true;
                    $dataInserted = false;

                    if ($handle !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                            if ($firstRow) {
                                $firstRow = false;
                                continue;
                            }

                            $indexnumber = $data[0];
                            $semester = $data[1];
                            $modulecode = $data[2];
                            $modulename = $data[3];
                            $results = $data[4];

                            $stmtInsert->bind_param('sssss', $indexnumber, $semester, $modulecode, $modulename, $results);

                            if ($stmtInsert->execute()) {
                                $dataInserted = true;
                            }
                        }
                        fclose($handle);
                    }

                    if ($dataInserted) {
                        echo '<div style="text-align: center; margin-top: 20px;">Data inserted successfully!</div>';
                    } else {
                        echo '<div style="text-align: center; margin-top: 20px;">No new data was inserted.</div>';
                    }

                    $stmtInsert->close();
                }

                $db->close();
            } else {
                echo '<div style="text-align: center; margin-top: 20px;">Error moving the uploaded file.</div>';
            }
        } else {
            echo '<div style="text-align: center; margin-top: 20px;">No file was uploaded or table not selected.</div>';
        }
    }
    ?>

    <div class="wow fadeInUp" data-wow-delay="0.1s">
        <div class="container my-5">
            <?php
            include 'db.php';
            echo "<div class='container my-5'>";
            echo "<div class='container text-center'>";
            echo "<div class='row justify-content-center'>";
            echo "<div class='col-lg-6'>";
            echo "<i class='bi bi-file-earmark-person' style='font-size: 5rem; color: #00A1A7;'></i>";
            echo '<form method="post" onsubmit="return getDetails()">';
            echo '<label for="selected_table">Select Table : </label>';
            echo '<select name="selected_table" required>';
            $tables = $conn->query("SHOW TABLES");
            while ($row = $tables->fetch_row()) {
                echo "<option value='{$row[0]}'>{$row[0]}</option>";
            }
            echo '</select>';
            echo '<div class="form-field">';
            echo '<button type="submit" name="getresults" class="btn btn-primary">Get Results</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            if (isset($_POST['getresults'])) {
                $selected_table = $_POST['selected_table'];
                $expected_columns = array('indexnumber', 'semester', 'modulecode', 'modulename', 'results');

                $column_check_query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?";
                $stmt_columns = $conn->prepare($column_check_query);
                if ($stmt_columns) {
                    $stmt_columns->bind_param('s', $selected_table);
                    $stmt_columns->execute();
                    $stmt_columns->bind_result($column_name);

                    $existing_columns = array();
                    while ($stmt_columns->fetch()) {
                        $existing_columns[] = $column_name;
                    }

                    $stmt_columns->close();
                    if (array_diff($expected_columns, $existing_columns)) {
                        echo '<div class="alert alert-danger" id="error-message">Invalid table selected. Please choose a correct table.</div>';
                        echo "<script>
                        setTimeout(function() {
                            document.getElementById('error-message').style.display = 'none';
                        }, 7000); 
                      </script>";
                    } else {
                        echo "<button onclick='closeResults()' id='closeResultsBtn' class='btn btn-danger'>Close Details</button>";
                        echo "<h4 class='my-4'>Student Results</h4>";
                        echo "<table>";
                        echo "<tr class='text-primary'>
                <th class='outresult'>Indexnumber</th>
                <th class='outresult'>Semester</th>
                <th class='outresult'>Modulecode</th>
                <th class='outresult'>Modulename</th>
                <th class='outresult'>Results</th>
                <th class='outresult'>Update</th>
            </tr>";

                        $query = "SELECT indexnumber, semester, modulecode, modulename, results FROM $selected_table";
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
                            echo "<tr><td colspan='6'>No data found in the selected table.</td></tr>";
                        }

                        echo "</table>";
                    }
                }
            }
            if (isset($_POST['update_result'])) {
                $change_result_indexnumber = $_POST['change_result_indexnumber'];
                $change_result_column = $_POST['change_result_column'];
                $new_result = $_POST['new_result'];

                $update_query = "UPDATE $selected_table SET $change_result_column = ? WHERE indexnumber = ?";
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
                echo "<script>document.getElementById('closeResultsBtn').style.display = 'none';</script>";
            }
            ?>
            <div id="resultContainer"></div>
        </div>
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