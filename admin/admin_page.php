<?php
require_once '../config/data.php';
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../auth/login.php");
}
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM games_table WHERE id_games = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('ลบสินค้าเรียบร้อยแล้ว')</script>";
        $_SESSION['success'] = "ลบสินค้าเรียบร้อยแล้ว";
        header("refresh:1.5; url=admin_page.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<header>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_page</title>
</header>

<body>
    <?php
    if (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        $stmt = $conn->prepare("SELECT * FROM bob WHERE id = ?");
        $stmt->execute([$admin_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <head>
        <nav>
            <a href="../auth/logout.php"><button class="btn btn-danger p-2">Logout</button></a>
        </nav>
    </head>
    <main>
        <div class="modal fade" id="gameModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มสินค้า</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="insert_product.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" class="form-control" name="image" id="imageinput" required>
                                <img width="100%" id="preview" alt="">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-success">บันทึก</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h1>ตารางสินค้า</h1>
                </div>
                <div class="col-md-6 d-flex justify-content-end gap-2 p-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gameModal">เพิ่มสินค้า</button>
                    <a href="key_games.php" class="btn btn-warning">KEYS</a>
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
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->query("SELECT * FROM games_table");
                    $stmt->execute();
                    $games = $stmt->fetchAll();

                    if (!$games) {
                        echo "<p><td colspan='4' class='text-center'>ไม่มีสินค้าในระบบ</td></p>";
                    } else {
                        foreach ($games as $game) {
                    ?>
                            <tr>
                                <th scope="row"><?php echo $game['id_games']; ?></th>
                                <td><?= $game['name_games'] ?></td>
                                <td><?= $game['price_games'] ?></td>
                                <td width="250px"><img width="100%" src="../upload/<?= $game['img_games'] ?>" alt="<?= $game['name_games'] ?>" class="rounded"></td>
                                <td>
                                    <a href="edit_game.php?id=<?= $game['id_games'] ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                    <a href="?delete=<?= $game["id_games"] ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการลบสินค้าหรือไม่ ??')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                    <?php   }
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
            let imageinput = document.getElementById('imageinput');
            let preview = document.getElementById('preview');

            imageinput.onchange = evt => {
                const [file] = imageinput.files;
                if (file) {
                    preview.src = URL.createObjectURL(file);
                }
            }
        </script>
    </main>
</body>

</html>