<?php
session_start();
require_once '../config/data.php';
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../auth/login.php");
    exit();
}
if (isset($_GET['delete_order'])) {

    $delete_id = (int)$_GET['delete_order'];

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("UPDATE game_keys
SET status = 'available'
WHERE key_id IN (
    SELECT key_id FROM inbox_keys WHERE order_id = ?)");
        $stmt->execute([$delete_id]);

        // ลบ inbox ก่อน
        $stmt = $conn->prepare("DELETE FROM inbox_keys WHERE order_id = ?");
        $stmt->execute([$delete_id]);

        // ลบ order_items
        $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->execute([$delete_id]);

        // ลบ orders
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->execute([$delete_id]);

        $conn->commit();
        $_SESSION['success'] = "ลบ Order เรียบร้อยแล้ว";
    } catch (Exception $e) {
        $conn->rollBack();
        $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
    }

    header("Location: admin_page.php?page=orders");
    exit;
}
