<?php
require_once '../config/data.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDERS</title>
</head>

<body>

    <div class="container mt-5" style="max-height: 1200px; overflow-y: auto;">
        <div class="row">
            <div class="col-md-6">
                <h1>ORDERS</h1>
            </div>
        </div>
        <hr>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>

        <!-- แสดงรายการสินค้า -->
         
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID user</th>
                    <th scope="col">Username</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">status</th>
                    <th scope="col">date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql="SELECT o.*, u.username FROM orders o LEFT JOIN bob u ON o.user_id = u.id ORDER BY o.order_id ASC";
                $stmt = $conn->query($sql);
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!$orders) {
                    echo "<p><td colspan='7' class='text-center'>ไม่มีสินค้าในระบบ</td></p>";
                } else {
                    foreach ($orders as $order) {
                ?>
                        <tr>
                            <th scope="row"><?php echo $order['order_id']; ?></th>
                            <td><?= $order['user_id'] ?></td>
                            <td><?= $order['username'] ?></td>
                            <td><?= $order['total_price'] ?></td>
                            <td><?= $order['order_status'] ?></td>
                            <td><?= $order['order_date'] ?></td>
                            <td>
                                <a href="order_delete.php?delete_order=<?= $order["order_id"] ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการลบออเดอร์หรือไม่ ??')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                <?php   }
                }
                ?>
            </tbody>
        </table>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>