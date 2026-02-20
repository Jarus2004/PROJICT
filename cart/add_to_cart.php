<?php
session_start();
require_once '../config/data.php';

$product_id = $_POST['product_id'];
$price = $_POST['price'];

// เช็ค login
if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];

    // หา cart ของ user
    $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $cart = $stmt->fetch();

    if (!$cart) {
        // ถ้ายังไม่มี cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id) VALUES (?)");
        $stmt->execute([$user_id]);
        $cart_id = $conn->lastInsertId();
    } else {
        $cart_id = $cart['cart_id'];
    }
}else {
    // ถ้าไม่ login
    header("Location: ../auth/login.php");
    exit;
}

// เช็คว่าสินค้าอยู่ในตะกร้าแล้วหรือยัง
$stmt = $conn->prepare("
    SELECT cart_item_id, quantity 
    FROM cart_item 
    WHERE cart_id = ? AND product_id = ?
");
$stmt->execute([$cart_id, $product_id]);
$item = $stmt->fetch();

if ($item) {
    // ถ้ามีแล้ว เพิ่มจำนวน
    $stmt = $conn->prepare("
        UPDATE cart_item 
        SET quantity = quantity + 1 
        WHERE cart_item_id = ?
    ");
    $stmt->execute([$item['cart_item_id']]);
} else {
    // ถ้ายังไม่มี เพิ่มใหม่
    $stmt = $conn->prepare("
        INSERT INTO cart_item (cart_id, product_id, price, quantity)
        VALUES (?, ?, ?, 1)
    ");
    $stmt->execute([$cart_id, $product_id, $price]);
}

header("Location:../index.php");
exit();
