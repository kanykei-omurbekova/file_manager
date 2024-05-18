<?php
session_start();
include '../config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] != 1) {
    header("location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doc_id = $_POST['doc_id'];
    $admin_id = $_SESSION['user_id'];

    $sql = "UPDATE documents SET approved = 1, approved_by = ?, approved_at = NOW() WHERE doc_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $admin_id, $doc_id);
        if ($stmt->execute()) {
            header("location: ../welcome.php");
            exit;
        } else {
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
    $conn->close();
} else {
    header("location: ../welcome.php");
    exit;
}
?>