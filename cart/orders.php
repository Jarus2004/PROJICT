<?php
require_once '../config/data.php';
session_start();

if (!isset($_SESSION['user_login'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>order</title>
</head>

<body>
    <?php
    if (isset($_GET['user_order'])) {
        $user_id = $_GET['user_order'];
        $sql = "
SELECT ci.product_id, ci.quantity, g.price_games
FROM cart_item ci
JOIN cart c ON ci.cart_id = c.cart_id
JOIN games_table g ON ci.product_id = g.id_games
WHERE c.user_id = :user_id
";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="container mt-5">
            <h1 class="text-center">สรุปคำสั่งซื้อ</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID สินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อชิ้น</th>
                        <th>ราคารวม</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td><?= $item['product_id'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price_games'], 2) ?></td>
                            <td><?= number_format($item['quantity'] * $item['price_games'], 2) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <form method="post">
                <button type="submit" name="confirm_order" onclick="return confirm('คุณต้องการยืนยันการสั่งซื้อหรือไม่?');" value="1" class="btn btn-primary mb-2">
                    ยืนยันการสั่งซื้อ
                </button>
            </form>
            <button class="btn btn-secondary" onclick="window.location.href='cart_page.php'">กลับไปที่ตะกร้าสินค้า</button>
        </div>

    <?php
        if (isset($_POST['confirm_order'])) {

    try {

        $conn->beginTransaction();

        // คำนวณยอดรวม
        $total = 0;
        foreach ($items as $item) {
            $total += $item['quantity'] * $item['price_games'];
        }

        // สร้าง order
        $stmt = $conn->prepare("
            INSERT INTO orders (user_id, total_price)
            VALUES (?, ?)
        ");
        $stmt->execute([$user_id, $total]);

        $order_id = $conn->lastInsertId();

        // วนสินค้า
        foreach ($items as $item) {

            $product_id = $item['product_id'];
            $quantity   = $item['quantity'];

            // ล็อก key
            $stmt = $conn->prepare("
                SELECT key_id, game_key
                FROM game_keys
                WHERE product_id = ?
                AND status = 'available'
                ORDER BY key_id
                LIMIT ?
                FOR UPDATE
            ");

            $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
            $stmt->bindValue(2, (int)$quantity, PDO::PARAM_INT);
            $stmt->execute();

            $keys = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($keys) < $quantity) {
                throw new Exception("Key ของสินค้า $product_id ไม่พอ");
            }

            // อัปเดต key
            $key_ids = array_column($keys, 'key_id');
            $in = implode(',', $key_ids);

            $conn->exec("
                UPDATE game_keys
                SET status = 'used'
                WHERE key_id IN ($in)
            ");

            // บันทึก inbox
            $stmtInbox = $conn->prepare("
                INSERT INTO inbox_keys 
                (order_id, user_id, product_id, key_id, game_key)
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($keys as $k) {
                $stmtInbox->execute([
                    $order_id,
                    $user_id,
                    $product_id,
                    $k['key_id'],
                    $k['game_key']
                ]);
            }
        }

        // บันทึก order items
        $stmtItem = $conn->prepare("
            INSERT INTO order_items 
            (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");

        foreach ($items as $item) {
            $stmtItem->execute([
                $order_id,
                $item['product_id'],
                $item['quantity'],
                $item['price_games']
            ]);
        }

        $stmtpending = $conn->prepare("
            UPDATE orders
            SET order_status = 'completed'
            WHERE order_id = ?");
        $stmtpending->execute([$order_id]);

        // ลบตะกร้า
        $conn->prepare("
            DELETE ci FROM cart_item ci
            JOIN cart c ON ci.cart_id = c.cart_id
            WHERE c.user_id = ?
        ")->execute([$user_id]);

        $conn->commit();

        $_SESSION['success'] = "สั่งซื้อสำเร็จ!";
        header("Location: ../index.php");
        exit();

    } catch (Exception $e) {

        $conn->rollBack();
        error_log("Order processing error: " . $e->getMessage());
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการสั่งซื้อ กรุณาลองใหม่อีกครั้ง";
        header("Location: cart_page.php");
        exit();
    }
}

    }
    ?>
</body>

</html>