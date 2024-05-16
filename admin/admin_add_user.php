<?php
include '../config.php';
session_start();

// Check if the user is an admin
if ($_SESSION['role'] !== 1) {
    die("Access denied");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (user_role, user_fullname, user_email, user_phone, username, password) VALUES (0, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $fullname, $email, $phone, $username, $password);

        if ($stmt->execute()) {
            echo "User added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <style>
        form {
            width: 300px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <form action="admin_add_user.php" method="post">
        <label>Full Name: <input type="text" name="fullname" required></label>
        <label>Email: <input type="email" name="email" required></label>
        <label>Phone: <input type="text" name="phone" required></label>
        <label>Username: <input type="text" name="username" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <input type="submit" value="Add User">
    </form>
</body>
</html>
