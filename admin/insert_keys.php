<?php
session_start();
require_once '../config/data.php';

if (isset($_POST['submitkeys'])) {
    $product_id = $_POST['pid'];
    // $key = $_POST['key'];
    $keys = explode("\n", $_POST['keys']);

    $stmt = $conn->prepare("SELECT id_games FROM games_table WHERE id_games = :product_id");
    $stmt->bindParam(":product_id", $product_id);
    $stmt->execute();
    $game = $stmt->fetch();

    if (empty($game)) {
        $_SESSION['error'] = "ไม่มี ID ของเกมนี้ในระบบ";
        header("Location:admin_page.php?page=key");
        exit();
    } else {
        // $stmt = $conn->prepare("INSERT INTO game_keys (product_id, game_key) 
        //                     VALUES (?, ?)");
        $stmt = $conn->prepare("INSERT IGNORE INTO game_keys (product_id, game_key)
VALUES (?, ?)
");


        foreach ($keys as $key) {
            $key = trim($key);
            if (!empty($key)) {
                $stmt->execute([$product_id, $key]);
            }
        }

        $_SESSION['success'] = "เพิ่มสินค้าเรียบร้อยแล้ว";
        header("Location:admin_page.php?page=key");
        exit();
    }
}
