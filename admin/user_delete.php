<?php
session_start();
require_once '../config/data.php';
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../auth/login.php");
    exit();
}
if (isset($_GET['delete_user'])) {
    $delete_id = (int)$_GET['delete_user'];
    $stmt = $conn->prepare("DELETE FROM bob WHERE id = ?");
    
    if ($stmt->execute([$delete_id])) {
        $_SESSION['success'] = "ลบ User เรียบร้อยแล้ว";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการลบ";
    }

    header("Location: admin_page.php?page=user");
    exit();
}
?>