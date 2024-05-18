<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Панель управления</span>
            </a>
        </li>
        <!-- Customer Sidebar = 0  -->
        <?php if ($_SESSION['role'] == 0): ?>
            <li class="nav-item nav-category">Документы</li>
            <li class="nav-item">
                <a class="nav-link" href="new_document.php">
                    <i class="bi bi-cloud-arrow-up fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Загрузить Документы</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="documents_lists.php">
                    <i class="bi bi-file-pdf fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Список документов</span>
                </a>
            </li>
            <li class="nav-item nav-category">Папки</li>
            <li class="nav-item">
                <a class="nav-link" href="new_folder.php">
                    <i class="bi bi-folder fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Папки</span>
                </a>
            </li>
            <li class="nav-item nav-category">Группа</li>
            <li class="nav-item">
                <a class="nav-link" href="shared_folder.php">
                    <i class="bi bi-collection fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Общие папки</span>
                </a>
            </li>
            <li class="nav-item nav-category">Друзья</li>
            <li class="nav-item">
                <a class="nav-link" href="new_friend.php">
                    <i class="bi bi-person-plus-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Новый друг</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="friends_list.php">
                    <i class="bi bi-people-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Друзья</span>
                </a>
            </li>
            <li class="nav-item nav-category">Настройки</li>
            <li class="nav-item">
                <a class="nav-link" href="user_pin_setup.php">
                    <i class="bi bi-key-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Настройка PIN-кода</span>
                </a>
            </li>
        <?php elseif ($_SESSION['role'] == 1): ?>
            <!-- Admin Sidebar = 1 - Тут можно ссылку на нормальную страницу-->
            <li class="nav-item nav-category">Панель Админа</li>
            <li class="nav-item">
                <a class="nav-link" href="admin/admin_list_users.php">
                    <i class="bi bi-people-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Пользователи</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin/admin_add_user.php">
                    <i class="bi bi-person-plus-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Добавить пользователя</span>
                </a>
            </li>
            <!-- Include all other admin specific links here -->
            <!-- Common items for both users and admins -->
            <li class="nav-item nav-category">Документы</li>
            <li class="nav-item">
                <a class="nav-link" href="new_document.php">
                    <i class="bi bi-cloud-arrow-up fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Загрузить Документы</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="documents_lists.php">
                    <i class="bi bi-file-pdf fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Список Документов</span>
                </a>
            </li>
            <li class="nav-item nav-category">Папки</li>
            <li class="nav-item">
                <a class="nav-link" href="new_folder.php">
                    <i class="bi bi-folder fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Папки</span>
                </a>
            </li>
            <li class="nav-item nav-category">Группа</li>
            <li class="nav-item">
                <a class="nav-link" href="shared_folder.php">
                    <i class="bi bi-collection fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Общие папки</span>
                </a>
            </li>
            <li class="nav-item nav-category">Друзья</li>
            <li class="nav-item">
                <a class="nav-link" href="new_friend.php">
                    <i class="bi bi-person-plus-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Новый друг</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="friends_list.php">
                    <i class="bi bi-people-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Друзья</span>
                </a>
            </li>
            <li class="nav-item nav-category">Настройки</li>
            <li class="nav-item">
                <a class="nav-link" href="user_pin_setup.php">
                    <i class="bi bi-key-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Установка PIN-кода</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
