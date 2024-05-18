<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Загрузить Новый Документ</title>
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

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Загрузить Новый Документ</h4>
                                    <p class="card-description">
                                        <!-- Notifications here  -->
                                        <!-- file uploaded success message  -->
                                        <?php
                                    if (isset($_SESSION['doc_upload'])) {
                                        ?>
                                    <div id="notification" class="alert alert-success" role="alert">
                                        <b> <i class="bi bi-check-circle-fill"></i>Успешно ! </b>Документ успешно загружен.
                                    </div>
                                    <?php
                                       unset($_SESSION['doc_upload']);
                                    }
                                    ?>
                                    <!-- File size exceed message  -->
                                    <?php
                                    if (isset($_SESSION['file_size'])) {
                                        ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-x-circle-fill"></i></i>Failed ! </b> Размер файла превышает допустимый лимит (100 МБ).
                                    </div>
                                    <?php
                                       unset($_SESSION['file_size']);
                                    }
                                    ?>
                                    <!-- File already exist message  -->
                                    <?php
                                    if (isset($_SESSION['file_exists'])) {
                                        ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-x-circle-fill"></i>Ошибка ! </b> Файл уже существует.
                                    </div>
                                    <?php
                                       unset($_SESSION['file_exists']);
                                    }
                                    ?>
                                    </p>
                                    <form class="forms-sample" action="php/upload_new_document.php" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Название Документа </label>
                                            <input type="text" name="name" class="form-control"
                                                id="exampleInputUsername1" placeholder="Название Документа" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Папка </label>
                                            <select name="folder" class="form-control" id="" required>
                                                <option value="" selected hidden>Выбрать... </option>
                                                <?php
                                                $user = $_SESSION['user_id'];
                                                $sql = "SELECT * from folders where folder_user = $user";
                                                $result = $conn->query($sql);
                                                
                                                if ($result->num_rows > 0) {
                                                  // output data of each row
                                                  while($row = $result->fetch_assoc()) {
                                                    ?>
                                                <option value="<?=$row['folder_id']?>">
                                                    <span class="text-capitalize"><?=$row['folder_name']?></span>
                                                </option>
                                                <?php
                                                  }
                                                }                                                 
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Описание Документа (необязательно)</label>
                                            <textarea id="inp_editor1" name="desc" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Загрузить Файл</label>
                                            <input type="file" name="file" class="form-control" id="" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2">Отправить</button>
                                        <button class="btn btn-secondary" type="reset">Сбросить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Система Электронного документооборота <a
                                href="https://www.bootstrapdash.com/" target="_blank">Ordo Docs</a> Бишкек,Кыргызстан</span>
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
    <?php include 'partials/javascripts.php'; ?>
    <script>
    var editor1 = new RichTextEditor("#inp_editor1");
    </script>

</body>

</html>