<?php
session_start();
require_once '../config/data.php';
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../auth/login.php");
    exit();
}
if (isset($_GET['delete_game'])) {

    $delete_id = (int)$_GET['delete_game'];

    $stmt = $conn->prepare(
        "DELETE FROM games_table WHERE id_games = ?"
    );
    $stmt->execute([$delete_id]);

    $_SESSION['success'] = "ลบสินค้าเรียบร้อยแล้ว";
    header("Location: admin_page.php?page=products");
    exit;
}
?>