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
    <meta charset="UTF-8">
    <title>List Users</title>
    <style>
        table.users-table {
            border-collapse: collapse;
            width: 100%;
        }
        table.users-table th, table.users-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        table.users-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Users List</h1>
    <table class="users-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Role</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Username</th>
                <th>Actions</th>
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
</body>
</html>
