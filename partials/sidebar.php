<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <!-- Customer Sidebar = 0  -->
        <?php if ($_SESSION['role'] == 0): ?>
            <li class="nav-item nav-category">Documents</li>
            <li class="nav-item">
                <a class="nav-link" href="new_document.php">
                    <i class="bi bi-cloud-arrow-up fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Upload Documents</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="documents_lists.php">
                    <i class="bi bi-file-pdf fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Documents List</span>
                </a>
            </li>
            <li class="nav-item nav-category">Folders</li>
            <li class="nav-item">
                <a class="nav-link" href="new_folder.php">
                    <i class="bi bi-folder fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Folders</span>
                </a>
            </li>
            <li class="nav-item nav-category">Group</li>
            <li class="nav-item">
                <a class="nav-link" href="shared_folder.php">
                    <i class="bi bi-collection fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Shared Folders</span>
                </a>
            </li>
            <li class="nav-item nav-category">Friends</li>
            <li class="nav-item">
                <a class="nav-link" href="new_friend.php">
                    <i class="bi bi-person-plus-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">New Friend</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="friends_list.php">
                    <i class="bi bi-people-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Friends</span>
                </a>
            </li>
            <li class="nav-item nav-category">Settings</li>
            <li class="nav-item">
                <a class="nav-link" href="user_pin_setup.php">
                    <i class="bi bi-key-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">PIN Setup</span>
                </a>
            </li>
        <?php elseif ($_SESSION['role'] == 1): ?>
            <!-- Admin Sidebar = 1 -->
            <li class="nav-item nav-category">Admin Management</li>
            <li class="nav-item">
                <a class="nav-link" href="admin/admin_list_users.php">
                    <i class="bi bi-people-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Manage Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin/admin_add_user.php">
                    <i class="bi bi-person-plus-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Add User</span>
                </a>
            </li>
            <!-- Include all other admin specific links here -->
            <!-- Common items for both users and admins -->
            <li class="nav-item nav-category">Documents</li>
            <li class="nav-item">
                <a class="nav-link" href="new_document.php">
                    <i class="bi bi-cloud-arrow-up fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Upload Documents</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="documents_lists.php">
                    <i class="bi bi-file-pdf fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Documents List</span>
                </a>
            </li>
            <li class="nav-item nav-category">Folders</li>
            <li class="nav-item">
                <a class="nav-link" href="new_folder.php">
                    <i class="bi bi-folder fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Folders</span>
                </a>
            </li>
            <li class="nav-item nav-category">Group</li>
            <li class="nav-item">
                <a class="nav-link" href="shared_folder.php">
                    <i class="bi bi-collection fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Shared Folders</span>
                </a>
            </li>
            <li class="nav-item nav-category">Friends</li>
            <li class="nav-item">
                <a class="nav-link" href="new_friend.php">
                    <i class="bi bi-person-plus-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">New Friend</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="friends_list.php">
                    <i class="bi bi-people-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">Friends</span>
                </a>
            </li>
            <li class="nav-item nav-category">Settings</li>
            <li class="nav-item">
                <a class="nav-link" href="user_pin_setup.php">
                    <i class="bi bi-key-fill fs-5"></i> &nbsp; &nbsp;
                    <span class="menu-title">PIN Setup</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
