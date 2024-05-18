<?php
include '../config.php';
session_start();

// Check if the user is an admin
if ($_SESSION['role'] !== 1) {
    die("Access denied");
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Список пользователей</title>
    <?php include '../partials/headtags.php'; ?>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:../partials/_navbar.html -->
        <?php include '../partials/navbar.php'; ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../partials/_settings-panel.html -->
            <?php include '../partials/settings_panel.php'; ?>
            <!-- partial -->
            <!-- partial:../partials/_sidebar.html -->
            <?php include '../partials/sidebar.php'; ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Список пользователей</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID пользователя</th>
                                                    <th>Роль</th>
                                                    <th>ФИО</th>
                                                    <th>Почта</th>
                                                    <th>Телефон</th>
                                                    <th>Логин</th>
                                                    <th>Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo $row['user_id']; ?></td>
                                                    <td><?php echo $row['user_role'] == 1 ? 'Admin' : 'User'; ?></td>
                                                    <td><?php echo $row['user_fullname']; ?></td>
                                                    <td><?php echo $row['user_email']; ?></td>
                                                    <td><?php echo $row['user_phone']; ?></td>
                                                    <td><?php echo $row['username']; ?></td>
                                                    <td>
                                                        <a href="admin_update_user.php?user_id=<?php echo $row['user_id']; ?>">Edit</a> | 
                                                        <a href="admin_delete_user.php?user_id=<?php echo $row['user_id']; ?>">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Система Электронного документооборота <a href="https://www.bootstrapdash.com/" target="_blank">Ordo Docs</a> Бишкек, Кыргызстан</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2024. Все права защищены</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php include '../partials/javascripts.php'; ?>
</body>
</html>
