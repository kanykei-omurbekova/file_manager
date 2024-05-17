<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
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

            <?php
            if ($_SESSION['role'] == 0) {
                ?>
            <!-- customer dashboard -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-3 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- fetch data from database  -->
                                                <?php
                                                    
                                                    // Fetch data from your database table
                                                    $user = $_SESSION['user_id'];
                                                    $sql = "SELECT sum(doc_size) as used_space from documents where doc_user = $user";
                                                    $result = $conn->query($sql);
                                                    
                                                    $usedSpace = 0;
                                                    
                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        $usedSpace = $row["used_space"];
                                                    }
                                                    
                                                    $allocatedSpace = 500 * 1024 * 1024; // 1GB in bytes
                                                    
                                                    // Calculate the remaining space
                                                    $remainingSpace = $allocatedSpace - $usedSpace;
                                                    
                                                    // Format the used space, remaining space, and allocated space
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
                                        <h4 class="card-title"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                width="32" height="32" viewBox="0 0 48 48">
                                                <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1" x1="24"
                                                    x2="24" y1="6.708" y2="14.977" gradientUnits="userSpaceOnUse">
                                                    <stop offset="0" stop-color="#eba600"></stop>
                                                    <stop offset="1" stop-color="#c28200"></stop>
                                                </linearGradient>
                                                <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1)"
                                                    d="M24.414,10.414l-2.536-2.536C21.316,7.316,20.553,7,19.757,7L5,7C3.895,7,3,7.895,3,9l0,30	c0,1.105,0.895,2,2,2l38,0c1.105,0,2-0.895,2-2V13c0-1.105-0.895-2-2-2l-17.172,0C25.298,11,24.789,10.789,24.414,10.414z">
                                                </path>
                                                <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2" x1="24"
                                                    x2="24" y1="10.854" y2="40.983" gradientUnits="userSpaceOnUse">
                                                    <stop offset="0" stop-color="#ffd869"></stop>
                                                    <stop offset="1" stop-color="#fec52b"></stop>
                                                </linearGradient>
                                                <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2)"
                                                    d="M21.586,14.414l3.268-3.268C24.947,11.053,25.074,11,25.207,11H43c1.105,0,2,0.895,2,2v26	c0,1.105-0.895,2-2,2H5c-1.105,0-2-0.895-2-2V15.5C3,15.224,3.224,15,3.5,15h16.672C20.702,15,21.211,14.789,21.586,14.414z">
                                                </path>
                                            </svg> Folders list
                                            <a href="new_document.php"
                                                class="btn btn-inverse-success float-end rounded-pill btn-md">Upload
                                                New</a>
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
                                                  // output data of each row
                                                  while($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <!-- Check folder is locked or not  -->
                                                            <?php
                                                        $lock = $row['folder_lock'];
                                                        // if folder is locked 
                                                        if ($lock == 1) {
                                                            ?>
                                                            <!-- PIN modal when folder is locked  -->
                                                            <!-- Button trigger modal -->
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#verify_pin<?=$row['folder_id']?>">
                                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                                    width="32" height="32" viewBox="0 0 48 48">
                                                                    <linearGradient
                                                                        id="WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1"
                                                                        x1="24" x2="24" y1="6.708" y2="14.977"
                                                                        gradientUnits="userSpaceOnUse">
                                                                        <stop offset="0" stop-color="#eba600"></stop>
                                                                        <stop offset="1" stop-color="#c28200"></stop>
                                                                    </linearGradient>
                                                                    <path
                                                                        fill="url(#WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1)"
                                                                        d="M24.414,10.414l-2.536-2.536C21.316,7.316,20.553,7,19.757,7L5,7C3.895,7,3,7.895,3,9l0,30	c0,1.105,0.895,2,2,2l38,0c1.105,0,2-0.895,2-2V13c0-1.105-0.895-2-2-2l-17.172,0C25.298,11,24.789,10.789,24.414,10.414z">
                                                                    </path>
                                                                    <linearGradient
                                                                        id="WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2"
                                                                        x1="24" x2="24" y1="10.854" y2="40.983"
                                                                        gradientUnits="userSpaceOnUse">
                                                                        <stop offset="0" stop-color="#ffd869"></stop>
                                                                        <stop offset="1" stop-color="#fec52b"></stop>
                                                                    </linearGradient>
                                                                    <path
                                                                        fill="url(#WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2)"
                                                                        d="M21.586,14.414l3.268-3.268C24.947,11.053,25.074,11,25.207,11H43c1.105,0,2,0.895,2,2v26	c0,1.105-0.895,2-2,2H5c-1.105,0-2-0.895-2-2V15.5C3,15.224,3.224,15,3.5,15h16.672C20.702,15,21.211,14.789,21.586,14.414z">
                                                                    </path>
                                                                </svg>
                                                                <?=$row['folder_name']?> &nbsp; <i
                                                                    class="bi bi-lock-fill"></i>
                                                            </a>

                                                            <!-- Modal -->
                                                            <div class="modal fade"
                                                                id="verify_pin<?=$row['folder_id']?>" tabindex="-1"
                                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="php/verify_pin_to_open_folder.php"
                                                                                method="POST">
                                                                                <label for="exampleInputEmail1"
                                                                                    class="form-label">Enter PIN
                                                                                </label>
                                                                                <input type="number" name="pin" min="0"
                                                                                    max="9999" class="form-control"
                                                                                    id="pinInput">
                                                                                <input type="hidden" name="folderid"
                                                                                    value="<?=$row['folder_id']?>">
                                                                                <div class="modal-footer mb-0">
                                                                                    <button type="submit"
                                                                                        class="btn btn-inverse-primary rounded-pill">Continue
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end of modal  -->

                                                            <?php
                                                        }
                                                        // if folder is not locked 
                                                        else {
                                                            ?>
                                                            <a href="documents_lists_byfolder.php?fid=<?=$row['folder_id']?>"
                                                                class="text-decoration-none text-dark text-capitalize">
                                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                                    width="32" height="32" viewBox="0 0 48 48">
                                                                    <linearGradient
                                                                        id="WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1"
                                                                        x1="24" x2="24" y1="6.708" y2="14.977"
                                                                        gradientUnits="userSpaceOnUse">
                                                                        <stop offset="0" stop-color="#eba600"></stop>
                                                                        <stop offset="1" stop-color="#c28200"></stop>
                                                                    </linearGradient>
                                                                    <path
                                                                        fill="url(#WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1)"
                                                                        d="M24.414,10.414l-2.536-2.536C21.316,7.316,20.553,7,19.757,7L5,7C3.895,7,3,7.895,3,9l0,30	c0,1.105,0.895,2,2,2l38,0c1.105,0,2-0.895,2-2V13c0-1.105-0.895-2-2-2l-17.172,0C25.298,11,24.789,10.789,24.414,10.414z">
                                                                    </path>
                                                                    <linearGradient
                                                                        id="WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2"
                                                                        x1="24" x2="24" y1="10.854" y2="40.983"
                                                                        gradientUnits="userSpaceOnUse">
                                                                        <stop offset="0" stop-color="#ffd869"></stop>
                                                                        <stop offset="1" stop-color="#fec52b"></stop>
                                                                    </linearGradient>
                                                                    <path
                                                                        fill="url(#WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2)"
                                                                        d="M21.586,14.414l3.268-3.268C24.947,11.053,25.074,11,25.207,11H43c1.105,0,2,0.895,2,2v26	c0,1.105-0.895,2-2,2H5c-1.105,0-2-0.895-2-2V15.5C3,15.224,3.224,15,3.5,15h16.672C20.702,15,21.211,14.789,21.586,14.414z">
                                                                    </path>
                                                                </svg>
                                                                <?=$row['folder_name']?>
                                                            </a>
                                                            <?php
                                                        }
                                                        ?>

                                                        </td>
                                                        <td><?=$row['item_count']?> items </td>
                                                        <td>
                                                            <?php                                                         
                                                        $folderDataSize = $row['folder_data_size'];
                                                        $fileSizeFormatted = formatFileSize($folderDataSize);
                                                        echo $fileSizeFormatted;
                                                        ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                  }
                                                } else {
                                                    ?>
<td>No documents uploaded !</td>
                                                    <?php
                                                }
                                                
                                                ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"> Share Folders </h4>
                                    <p class="card-description">
                                        <!-- share folder delete notiication  -->
                                        <?php
                                    if (isset($_SESSION['sfdelete'])) {
                                        ?>
                                    <div id="notification" class="alert alert-success" role="alert">
                                        <b> <i class="bi bi-check-circle-fill"></i>Success ! </b> Shared Folder deleted
                                        successfully.
                                    </div>
                                    <?php
                                       unset($_SESSION['sfdelete']);
                                    }
                                    ?>
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Profile</th>
                                                    <th>Members</th>
                                                    <th>Created</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $userid = $_SESSION['user_id'];
                                                $sfsql = "SELECT DISTINCT sf.*, COALESCE(sf_member_count, 0) AS total_members
                                                FROM sharefolder AS sf
                                                LEFT JOIN sharefolder_members AS sfm ON sfm.member_sf = sf.sf_id
                                                LEFT JOIN (
                                                    SELECT member_sf, COUNT(*) AS sf_member_count
                                                    FROM sharefolder_members
                                                    GROUP BY member_sf
                                                ) AS member_counts ON member_counts.member_sf = sf.sf_id
                                                WHERE sf.sf_user = $userid OR sfm.member_userid = $userid";
                                                $sf_result = $conn->query($sfsql);

                                                if ($sf_result->num_rows > 0) {
                                                // output data of each row
                                                while($sfrow = $sf_result->fetch_assoc()) {
                                                    ?>
                                                <tr>
                                                    <td>
                                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                            width="32" height="32" viewBox="0 0 48 48">
                                                            <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1"
                                                                x1="24" x2="24" y1="6.708" y2="14.977"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset="0" stop-color="#eba600"></stop>
                                                                <stop offset="1" stop-color="#c28200"></stop>
                                                            </linearGradient>
                                                            <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1)"
                                                                d="M24.414,10.414l-2.536-2.536C21.316,7.316,20.553,7,19.757,7L5,7C3.895,7,3,7.895,3,9l0,30	c0,1.105,0.895,2,2,2l38,0c1.105,0,2-0.895,2-2V13c0-1.105-0.895-2-2-2l-17.172,0C25.298,11,24.789,10.789,24.414,10.414z">
                                                            </path>
                                                            <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2"
                                                                x1="24" x2="24" y1="10.854" y2="40.983"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset="0" stop-color="#ffd869"></stop>
                                                                <stop offset="1" stop-color="#fec52b"></stop>
                                                            </linearGradient>
                                                            <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2)"
                                                                d="M21.586,14.414l3.268-3.268C24.947,11.053,25.074,11,25.207,11H43c1.105,0,2,0.895,2,2v26	c0,1.105-0.895,2-2,2H5c-1.105,0-2-0.895-2-2V15.5C3,15.224,3.224,15,3.5,15h16.672C20.702,15,21.211,14.789,21.586,14.414z">
                                                            </path>
                                                        </svg> &nbsp;
                                                        <?=$sfrow['sf_name']?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                    $members = $sfrow['total_members'];
                                                    if ($members == 1) {
                                                        echo $members. " member";
                                                    }else {
                                                        echo $members. " members";
                                                    }

                                                    ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                // Set the timezone to Asia/Kolkata
                                                                date_default_timezone_set('Asia/Kolkata');

                                                                // Assuming $row['story_date'] contains the story's date in a format like 'Y-m-d H:i:s'
                                                                $createdat = strtotime($sfrow['sf_date']);
                                                                $currentDate = time(); // Get the current timestamp in Asia/Kolkata timezone

                                                                // Calculate the time difference in seconds
                                                                $timeDifference = $currentDate - $createdat;

                                                                // Create a string to display the time when the story was posted
                                                                $timePosted = '';

                                                                if ($timeDifference < 60) {
                                                                    // Less than a minute
                                                                    $timePosted = "Just now";
                                                                } elseif ($timeDifference < 3600) {
                                                                    // Less than an hour
                                                                    $minutes = floor($timeDifference / 60);
                                                                    $timePosted = $minutes . ' minute' . ($minutes != 1 ? 's' : '') . ' ago';
                                                                } elseif ($timeDifference < 86400) {
                                                                    // Less than a day
                                                                    $hours = floor($timeDifference / 3600);
                                                                    $timePosted = $hours . ' hour' . ($hours != 1 ? 's' : '') . ' ago';
                                                                } elseif ($timeDifference < 2592000) {
                                                                    // Less than a month (30 days)
                                                                    $days = floor($timeDifference / 86400);
                                                                    $timePosted = $days . ' day' . ($days != 1 ? 's' : '') . ' ago';
                                                                } else {
                                                                    // More than a month
                                                                    $months = floor($timeDifference / 2592000); // Approximate number of seconds in a month
                                                                    $timePosted = $months . ' month' . ($months != 1 ? 's' : '') . ' ago';
                                                                }

                                                                // Print the time when the story was posted
                                                                echo $timePosted;
                                                                ?>
                                                    </td>
                                                    <td><a href="share_folder_documents.php?id=<?=$sfrow['sf_id']?>"
                                                            class="btn btn-inverse-primary btn-sm rounded">Open</a>

                                                        <?php
                                                            $sf_id = $sfrow['sf_user'];
                                                            if ($sf_id == $userid) {
                                                                ?>
                                                        <!-- delete trigger modal -->
                                                        <button type="button"
                                                            class="btn btn-inverse-danger btn-sm rounded"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deletesharefolder<?=$sfrow['sf_id']?>">
                                                            Delete
                                                        </button>
                                                        <?php
                                                            }
                                                            ?>
                                                        <!-- delete Modal -->
                                                        <div class="modal fade"
                                                            id="deletesharefolder<?=$sfrow['sf_id']?>" tabindex="-1"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body fs-6 fw-bold text-wrap">
                                                                        Are you sure you want to close this sharefolder,
                                                                        all the documents and members will be removed
                                                                        from this sharefolder. This action cannot be
                                                                        undo. <br> Are you sure you want to continue ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <a type="button"
                                                                            href="php/delete_sharefolder.php?sfid=<?=$sfrow['sf_id']?>"
                                                                            class="btn btn-danger btn-sm">Yes, Continue
                                                                            <i class="bi bi-arrow-right-short"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>

                                                </tr>

                                                <?php
                                                }
                                                } else {
                                               ?>
                                                <td>No Sharefolder found !</td>
                                                <?php
                                                }
                                                $conn->close();
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- customers dashboard ends -->
            <?php
            }
            ?>

        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php include 'partials/javascripts.php'; ?>

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