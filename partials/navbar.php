<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo" href="index.php">
                <!-- <img src="images/logo.svg" alt="logo" /> -->
                <span class="fw-bold " style="font-family: Sofia,sans-serif;">
                    <span class="fs-2 font-effect-shadow-multiple">Ordo</span>
                    <span class="text-primary fs-5 font-effect-shadow-multiple">Docs</span>
                </span>
            </a>
            <!-- <a class="navbar-brand brand-logo-mini" href="index.php">
                <img src="images/logo-mini.svg" alt="logo" />
            </a> -->
        </div>
    </div>
    <?php
    $id = $_SESSION['user_id'];
    $sql = "SELECT * from users where user_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
    ?>
    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text">
                    <?php
                    // Локальная таймзона
                    date_default_timezone_set('Asia/Bishkek'); 

                    // Get the current hour
                    $currentHour = date('G');

                    // Define the greetings
                    $greeting = '';

                    if ($currentHour >= 5 && $currentHour < 12) {
                        $greeting = 'Доброе утро';
                    } elseif ($currentHour >= 12 && $currentHour < 18) {
                        $greeting = 'Добрый день';
                    } else {
                        $greeting = 'Добрый вечер';
                    }

                    // Приветствие
                    echo $greeting;
                    ?>,

                    <span class="text-black fw-bold text-capitalize">
                        <?=$row['user_fullname']?>
                    </span>
                </h1>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <form class="search-form" action="#">
                    <i class="icon-search"></i>
                    <input type="search" class="form-control" placeholder="Искать" title="Искать">
                </form>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                    <i class="icon-mail icon-lg"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                    aria-labelledby="notificationDropdown">
                    <a class="dropdown-item py-3 border-bottom">
                        <p class="mb-0 font-weight-medium float-left"> У вас 4 новых уведомления</p>
                        <span class="badge badge-pill badge-primary float-right"> Посмотреть все </span>
                    </a>
                    <a class="dropdown-item preview-item py-3">
                        <div class="preview-thumbnail">
                            <i class="mdi mdi-alert m-auto text-primary"></i>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject fw-normal text-dark mb-1"> Ошибка приложения </h6>
                            <p class="fw-light small-text mb-0"> Только что </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item py-3">
                        <div class="preview-thumbnail">
                            <i class="mdi mdi-settings m-auto text-primary"></i>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject fw-normal text-dark mb-1"> Настройки</h6>
                            <p class="fw-light small-text mb-0"> Личное сообщение </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item py-3">
                        <div class="preview-thumbnail">
                            <i class="mdi mdi-airballoon m-auto text-primary"></i>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject fw-normal text-dark mb-1">Регистрация нового пользователя </h6>
                            <p class="fw-light small-text mb-0"> 2 дня назад </p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="icon-bell"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                    aria-labelledby="countDropdown">
                    <a class="dropdown-item py-3">
                        <p class="mb-0 font-weight-medium float-left">У вас 7 непрочитанных писем </p>
                        <span class="badge badge-pill badge-primary float-right">Посмотреть все</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="images/faces/face10.jpg" alt="image" class="img-sm profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis font-weight-medium text-dark"> Садыр Жапаров </p>
                            <p class="fw-light small-text mb-0"> Встреча отменена </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="images/faces/face12.jpg" alt="image" class="img-sm profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis font-weight-medium text-dark"> Алмазбек Атамбаев </p>
                            <p class="fw-light small-text mb-0"> Встреча отменена </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="images/faces/face1.jpg" alt="image" class="img-sm profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis font-weight-medium text-dark"> Курманбек Бакиев </p>
                            <p class="fw-light small-text mb-0"> Встреча отменена </p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="images/faces/face8.jpg" alt="Profile image"> </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="images/faces/face8.jpg" alt="Profile image">
                        <p class="mb-1 mt-3 font-weight-semibold text-capitalize"><?=$row['user_fullname']?></p>
                        <p class="fw-light text-muted mb-0"><?=$row['user_email']?></p>
                    </div>
                    <!-- <a class="dropdown-item"><i
                            class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile</a>
                    <a class="dropdown-item"><i
                            class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
                    <a class="dropdown-item"><i
                            class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i>
                        Activity</a>
                    <a class="dropdown-item"><i
                            class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a> -->
                    <a href="php/logout.php" class="dropdown-item"><i
                            class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Выйти</a>
                </div>
            </li>
            <!-- Add admin links here -->
            <?php if ($_SESSION['role'] === 1): // Check if the user is an admin ?>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" data-bs-toggle="dropdown"> Админ </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown">
                    <a class="dropdown-item" href="/admin/admin_list_users.php">Управление пользователями
                    </a>
                    <a class="dropdown-item" href="/admin/admin_add_user.php">Добавить пользователя</a>
                </div>
            </li>
            <?php endif; ?>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
    <?php
        }
    } else {
        echo "0 results";
    }
    ?>
</nav>
