<?php
session_start();
require_once '../config/data.php';
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../auth/login.php");
    exit();
}
if (isset($_GET['delete_key'])) {
    $delete_id = (int)$_GET['delete_key'];
    $stmt = $conn->prepare("DELETE FROM game_keys WHERE key_id = ?");
    
    if ($stmt->execute([$delete_id])) {
        $_SESSION['success'] = "ลบ Key เรียบร้อยแล้ว";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการลบ";
    }

    header("Location: admin_page.php?page=key");
    exit;
}
?>