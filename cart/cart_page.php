<?php
session_start();
require_once '../config/data.php';

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
} else {
    header("Location: ../auth/login.php");
    exit;
}

// อัพเดทจำนวนสินค้า
if (isset($_POST['update_qty'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);

    if ($quantity > 0) {
        $stmt = $conn->prepare("
            UPDATE cart_item 
            SET quantity = ? 
            WHERE cart_id = (
                SELECT cart_id FROM cart WHERE user_id = ?
            ) AND product_id = ?
        ");
        $stmt->execute([$quantity, $user_id, $product_id]);
    }
}

// ลบสินค้า
if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];

    $stmt = $conn->prepare("
        DELETE FROM cart_item 
        WHERE cart_id = (
            SELECT cart_id FROM cart WHERE user_id = ?
        ) AND product_id = ?
    ");
    $stmt->execute([$user_id, $product_id]);
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .bg-rgb {
            background: #000000;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #434343, #000000);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #434343, #000000);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


        }
    </style>
</head>

<body class="bg-rgb">

    <div class="container bg-primary text-white text-center p-3 mt-5">
        <h1>Shopping Cart</h1>
        <a href="../pages/page.php" class="text-dark text-decoration-none">กลับไปหน้าหลัก</a>
    </div>
        
    <div class="container mt-5">
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <table class="table table-bordered text-center" style="background-color: rgba(255,255,255,0.4);">
            <thead>
                <tr>
                    <th>แก้ไขจำนวน</th>
                    <th>สินค้า</th>
                    <th>จำนวน</th>
                    <th>ราคา</th>
                    <th>ราคารวม</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $stmt = $conn->prepare("
SELECT 
    c.product_id,
    c.quantity,
    c.price,
    g.name_games,
    COUNT(gk.key_id) AS key_available
FROM cart_item c
JOIN cart ct ON c.cart_id = ct.cart_id
JOIN games_table g ON c.product_id = g.id_games
LEFT JOIN game_keys gk 
    ON g.id_games = gk.product_id 
    AND gk.status = 'available'
WHERE ct.user_id = ?
GROUP BY c.product_id, c.quantity, c.price, g.name_games
");
                $stmt->execute([$user_id]);

                $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!$cart_items) {
                    echo "
                <tr>
                    <td colspan='6' class='text-center text-danger'>
                        ไม่มีสินค้าในตะกร้า
                    </td>
                </tr>
            ";
                } else {
                    foreach ($cart_items as $item) {
                        $total_price = $item['price'] * $item['quantity'];
                        $max = max(1, (int)$item['key_available']);
                ?>
                        <tr>
                            <!-- ฟอร์มแก้ไขจำนวนสินค้า -->
                            <td>
                                <form method="post" action="cart_page.php" class="d-inline-block">
                                    <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity']; ?>" min="1" max="<?= $max ?>" class="form-control mb-1">
                                    <button type="submit" name="update_qty" class="btn btn-sm btn-warning">
                                        แก้จำนวน
                                    </button>
                                </form>
                            </td>

                            <!-- แสดงข้อมูลสินค้า -->
                            <td><?= $item['name_games']; ?></td>
                            <td><?= $item['quantity']; ?></td>
                            <td><?= number_format($item['price'], 2); ?></td>
                            <td><?= number_format($total_price, 2); ?></td>

                            <!-- ลบสินค้า -->
                            <td>
                                <a href="?delete=<?= $item['product_id']; ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('ต้องการลบสินค้านี้หรือไม่?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>

                <?php } ?>
            </tbody>
        </table>
        <?php if (!empty($cart_items)) { ?>
            <a href="orders.php?user_order=<?= $user_id ?>" class="btn btn-success text-center d-block mt-3">ชำระเงิน</a>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>