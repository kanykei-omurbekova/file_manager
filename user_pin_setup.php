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
    <title>Настройка ПИН-кода пользователя</title>
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
            if ($_SESSION['role'] == 0 || $_SESSION['role'] == 1) {
                ?>
            <!-- customer dashboard -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Изменить ПИН-код пользователя</h4>
                                    <p class="card-description">
                                        <!-- PIN changed notificaton  -->
                                        <?php
                                    if (isset($_SESSION['pinchanged'])) {
                                        ?>
                                    <div id="notification" class="alert alert-success" role="alert">
                                        <b> <i class="bi bi-exclamation-triangle-fill"></i>Успешно ! </b> ПИН-код успешно изменен.
                                    </div>
                                    <?php
                                       unset($_SESSION['pinchanged']);
                                    }
                                    ?>
                                    <!-- Password not match notificaton  -->
                                    <?php
                                    if (isset($_SESSION['wrongpwd'])) {
                                        ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-exclamation-triangle-fill"></i>Ошибка ! </b> Неправильный пароль.
                                    </div>
                                    <?php
                                       unset($_SESSION['wrongpwd']);
                                    }
                                    ?>
                                    </p>
                                    <form class="forms-sample" action="php/update_user_pin.php" method="POST">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Новый PIN код</label>
                                            <input type="text" maxlength="4" name="pin" class="form-control"
                                                id="exampleInputUsername1" placeholder="Введите PIN-код">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Пароль</label>
                                            <input type="password" name="password" class="form-control"
                                                id="exampleInputEmail1" placeholder="Пароль">
                                        </div>

                                        <button type="submit" class="btn btn-primary me-2">Изменить PIN код</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
            <!-- customers dashboard ends -->
            <?php
            }
            ?>

        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php include 'partials/javascripts.php'; ?>
</body>

</html>