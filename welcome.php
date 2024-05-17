<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
include 'config.php';
include 'partials/php_functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dashboard</title>
    <?php include 'partials/headtags.php'; ?>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include 'partials/navbar.php'; ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <?php include 'partials/settings_panel.php'; ?>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <?php include 'partials/sidebar.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <?php
                    if ($_SESSION['role'] == 0) {
                        // Customer Dashboard
                    ?>
                        <div class="row">
                            <div class="col-lg-3 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="row">
                                                    <!-- fetch data from database  -->
                                                    <?php
                                                    $user = $_SESSION['user_id'];
                                                    $sql = "SELECT sum(doc_size) as used_space from documents where doc_user = $user";
                                                    $result = $conn->query($sql);

                                                    $usedSpace = 0;

                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        $usedSpace = $row["used_space"];
                                                    }

                                                    $allocatedSpace = 500 * 1024 * 1024; // 1GB in bytes
                                                    $remainingSpace = $allocatedSpace - $usedSpace;

                                                    $usedSpaceFormatted = formatFileSize($usedSpace);
                                                    $remainingSpaceFormatted = formatFileSize($remainingSpace);
                                                    $allocatedSpaceFormatted = formatFileSize($allocatedSpace);
                                                    ?>
                                                    <div class="col-lg-12">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h4 class="card-title card-title-dash">
                                                                Space Usage
                                                            </h4>
                                                        </div>
                                                        <canvas class="my-auto" id="doughnutChart1" height="200"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 d-flex flex-column">
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 48 48">
                                                    <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1" x1="24" x2="24" y1="6.708" y2="14.977" gradientUnits="userSpaceOnUse">
                                                        <stop offset="0" stop-color="#eba600"></stop>
                                                        <stop offset="1" stop-color="#c28200"></stop>
                                                    </linearGradient>
                                                    <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1)" d="M24.414,10.414l-2.536-2.536C21.316,7.316,20.553,7,19.757,7L5,7C3.895,7,3,7.895,3,9l0,30c0,1.105,0.895,2,2,2l38,0c1.105,0,2-0.895,2-2V13c0-1.105-0.895-2-2-2l-17.172,0C25.298,11,24.789,10.789,24.414,10.414z"></path>
                                                    <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2" x1="24" x2="24" y1="10.854" y2="40.983" gradientUnits="userSpaceOnUse">
                                                        <stop offset="0" stop-color="#ffd869"></stop>
                                                        <stop offset="1" stop-color="#fec52b"></stop>
                                                    </linearGradient>
                                                    <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2)" d="M21.586,14.414l3.268-3.268C24.947,11.053,25.074,11,25.207,11H43c1.105,0,2,0.895,2,2v26c0,1.105-0.895,2-2,2H5c-1.105,0-2-0.895-2-2V15.5C3,15.224,3.224,15,3.5,15h16.672C20.702,15,21.211,14.789,21.586,14.414z"></path>
                                                </svg>
                                                Folders list
                                                <a href="new_document.php" class="btn btn-inverse-success float-end rounded-pill btn-md">Upload New</a>
                                            </h4>
                                            <p class="card-description">
                                                <!-- wrong pin notificaton  -->
                                                <?php
                                                if (isset($_SESSION['wrongpin'])) {
                                                ?>
                                                    <div id="notification" class="alert alert-danger" role="alert">
                                                        <b> <i class="bi bi-exclamation-triangle-fill"></i>Failed ! </b> Wrong PIN.
                                                    </div>
                                                <?php
                                                    unset($_SESSION['wrongpin']);
                                                }
                                                ?>
                                            </p>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Folder </th>
                                                            <th>Items</th>
                                                            <th>Size</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $user = $_SESSION['user_id'];
                                                        $sql = "SELECT folders.folder_id, folders.folder_name, folders.folder_lock,
                                                                COUNT(documents.doc_id) AS item_count,
                                                                SUM(documents.doc_size) AS folder_data_size
                                                         FROM folders
                                                         LEFT JOIN documents ON folders.folder_id = documents.doc_folder
                                                         WHERE folders.folder_user = $user
                                                         GROUP BY folders.folder_id, folders.folder_name";
                                                        $result = $conn->query($sql);

                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                                <tr>
                                                                    <td>
                                                                        <!-- Check folder is locked or not  -->
                                                                        <?php
                                                                        $lock = $row['folder_lock'];

                                                                        if ($lock == 1) {
                                                                        ?>
                                                                            <!-- PIN modal when folder is locked  -->
                                                                            <!-- Button trigger modal -->
                                                                            <a data-bs-toggle="modal" data-bs-target="#verify_pin<?=$row['folder_id']?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 48 48">
                                                                                    <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1" x1="24" x2="24" y1="6.708" y2="14.977" gradientUnits="userSpaceOnUse">
                                                                                        <stop offset="0" stop-color="#eba600"></stop>
                                                                                        <stop offset="1" stop-color="#c28200"></stop>
                                                                                    </linearGradient>
                                                                                    <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1)" d="M24.414,10.414l-2.536-2.536C21.316,7.316,20.553,7,19.757,7L5,7C3.895,7,3,7.895,3,9l0,30c0,1.105,0.895,2,2,2l38,0c1.105,0,2-0.895,2-2V13c0-1.105-0.895-2-2-2l-17.172,0C25.298,11,24.789,10.789,24.414,10.414z"></path>
                                                                                    <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2" x1="24" x2="24" y1="10.854" y2="40.983" gradientUnits="userSpaceOnUse">
                                                                                        <stop offset="0" stop-color="#ffd869"></stop>
                                                                                        <stop offset="1" stop-color="#fec52b"></stop>
                                                                                    </linearGradient>
                                                                                    <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2)" d="M21.586,14.414l3.268-3.268C24.947,11.053,25.074,11,25.207,11H43c1.105,0,2,0.895,2,2v26c0,1.105-0.895,2-2,2H5c-1.105,0-2-0.895-2-2V15.5C3,15.224,3.224,15,3.5,15h16.672C20.702,15,21.211,14.789,21.586,14.414z"></path>
                                                                                </svg> <?=$row['folder_name']?>
                                                                            </a>

                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="verify_pin<?=$row['folder_id']?>" tabindex="-1" aria-labelledby="verify_pin" aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="verify_pin">Enter your PIN</h5>
                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <form action="php/verify_pin_to_open_folder.php" method="post">
                                                                                                <input type="hidden" name="folder_id" value="<?=$row['folder_id']?>">
                                                                                                <div class="form-group">
                                                                                                    <label for="folder_pin" class="form-label">PIN</label>
                                                                                                    <input type="password" name="folder_pin" class="form-control" required>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                            <button type="submit" class="btn btn-primary">Verify</button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="documents_lists_byfolder.php?folder_id=<?=$row['folder_id']?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 48 48">
                                                                                    <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1" x1="24" x2="24" y1="6.708" y2="14.977" gradientUnits="userSpaceOnUse">
                                                                                        <stop offset="0" stop-color="#eba600"></stop>
                                                                                        <stop offset="1" stop-color="#c28200"></stop>
                                                                                    </linearGradient>
                                                                                    <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1)" d="M24.414,10.414l-2.536-2.536C21.316,7.316,20.553,7,19.757,7L5,7C3.895,7,3,7.895,3,9l0,30c0,1.105,0.895,2,2,2l38,0c1.105,0,2-0.895,2-2V13c0-1.105-0.895-2-2-2l-17.172,0C25.298,11,24.789,10.789,24.414,10.414z"></path>
                                                                                    <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2" x1="24" x2="24" y1="10.854" y2="40.983" gradientUnits="userSpaceOnUse">
                                                                                        <stop offset="0" stop-color="#ffd869"></stop>
                                                                                        <stop offset="1" stop-color="#fec52b"></stop>
                                                                                    </linearGradient>
                                                                                    <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2)" d="M21.586,14.414l3.268-3.268C24.947,11.053,25.074,11,25.207,11H43c1.105,0,2,0.895,2,2v26c0,1.105-0.895,2-2,2H5c-1.105,0-2-0.895-2-2V15.5C3,15.224,3.224,15,3.5,15h16.672C20.702,15,21.211,14.789,21.586,14.414z"></path>
                                                                                </svg> <?=$row['folder_name']?>
                                                                            </a>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?=$row['item_count']?></td>
                                                                    <td>
                                                                        <?php
                                                                        $folder_data_size = $row["folder_data_size"];
                                                                        if ($folder_data_size === NULL) {
                                                                            echo "0 KB";
                                                                        } else {
                                                                            echo formatFileSize($folder_data_size);
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='3'>No folders found.</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                            <div class="card bg-primary card-rounded">
                                <div class="card-body pb-0">
                                    <h4 class="card-title card-title-dash text-white mb-4">
                                        Space Overview
                                    </h4>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p class="status-summary-ight-white mb-1">
                                                Used Space
                                            </p>
                                            <h2 class="text-info"><?= $usedSpaceFormatted ?></h2>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="status-summary-ight-white mb-1">
                                                Free Space
                                            </p>
                                            <h2 class="text-info"><?= $remainingSpaceFormatted ?></h2>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="status-summary-ight-white mb-1">
                                                Total Space
                                            </p>
                                            <h2 class="text-info"><?= $allocatedSpaceFormatted ?></h2>
                                        </div>
                                    </div>
                                </div>
                                <canvas class="mt-4" height="120" id="booking-chart"></canvas>
                            </div>
                        </div> -->
                    </div>
                    <?php
                    } elseif ($_SESSION['role'] == 1) {
                        // Admin Dashboard
                    ?>
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Admin Dashboard</h4>
                                        <p class="card-description">Manage your application</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Function</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><a href="admin/admin_list_users.php">Manage Users</a></td>
                                                        <td>View, add, delete, and update users</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="admin/admin_add_user.php">Add User</a></td>
                                                        <td>Add a new user to the system</td>
                                                    </tr>
                                                    <!-- Add more admin functionalities as needed -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                        echo "Invalid user role.";
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php include 'partials/javascripts.php'; ?>

    
    // JavaScript code for handling dashboard interactions

<script>
   // Function to format file sizes
    function formatFileSize(bytes) {
        if (bytes < 1024) {
            return bytes + ' B';
        } else if (bytes < 1048576) {
            return (bytes / 1024).toFixed(2) + ' KB';
        } else if (bytes < 1073741824) {
            return (bytes / 1048576).toFixed(2) + ' MB';
        } else {
            return (bytes / 1073741824).toFixed(2) + ' GB';
        }
    }

    // Formatted values for chart labels
    var usedSpaceFormatted = "<?php echo formatFileSize($usedSpace); ?>";
    var remainingSpaceFormatted = "<?php echo formatFileSize($remainingSpace); ?>";

    var data = {
        labels: ["Used Space (" + usedSpaceFormatted + ")", "Remaining Space (" + remainingSpaceFormatted + ")"],
        datasets: [{
            data: [<?php echo $usedSpace; ?>, <?php echo $remainingSpace; ?>],
            backgroundColor: ["#FF5733", "#36A2EB"] // Customize colors
        }]
    };

    var ctx = document.getElementById("doughnutChart1").getContext("2d");
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            legend: {
                position: 'bottom',
                display: true
            },
            tooltips: {
                enabled: true,
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var value = dataset.data[tooltipItem.index];
                        var label = data.labels[tooltipItem.index];
                        return label + ': ' + formatFileSize(value);
                    }
                }
            }
        }
    });
    </script>

    <script>
    $(document).ready(function() {
        $('#pinInput').on('input', function() {
            var inputValue = $(this).val();

            // Check if the input is longer than 4 digits
            if (inputValue.length > 4) {
                // Truncate the input to 4 digits
                $(this).val(inputValue.slice(0, 4));
            }
        });
    });
    </script>

</body>

</html>
