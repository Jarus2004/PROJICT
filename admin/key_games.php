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
    <title>KeyGames</title>
</head>

<body>

    <!-- เพิ่มKEYS -->
    <div class="modal fade" id="keyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">keys</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insert_keys.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="col-form-label">ProductID:</label>
                            <input type="text" class="form-control" name="pid" required>
                        </div>

                        <!-- <div class="mb-3">
                            <label for="key" class="col-form-label">Key:</label>
                            <input type="text" class="form-control" name="key" required>
                        </div> -->

                        <div class="mb-3">
                            <textarea name="keys" class="form-control" rows="10"
                                placeholder="วางคีย์เกม 1 บรรทัด ต่อ 1 คีย์" required></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submitkeys" class="btn btn-success">บันทึก</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- edit_key -->
    <div class="modal fade" id="editKeyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="edit_keys.php" method="post">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Game Key</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- hidden -->
                        <input type="hidden" name="key_id" id="modal_key_id">

                        <div class="mb-3">
                            <label>Product ID</label>
                            <input type="text" class="form-control" name="pid" id="modal_pid" value="<?= $key['product_id'] ?>">
                        </div>

                        <div class="mb-3">
                            <label>Game Key</label>
                            <input type="text" class="form-control" name="game_key" id="modal_game_key" value="<?= $key['game_key'] ?>">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" name="submit_edit_keys" class="btn btn-success">
                            บันทึก
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>



    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>KEYS</h1>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#keyModal">เพิ่มKEYS</button>
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
        <div style="max-height: 1000px; overflow-y: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ProductID</th>
                        <th scope="col">Key</th>
                        <th scope="col">status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->query("SELECT * FROM game_keys");
                    $stmt->execute();
                    $keys = $stmt->fetchAll();

                    if (!$keys) {
                        echo "<p><td colspan='4' class='text-center'>ไม่มีสินค้าในระบบ</td></p>";
                    } else {
                        foreach ($keys as $key) {
                    ?>
                            <tr>
                                <th scope="row"><?php echo $key['key_id']; ?></th>
                                <td><?= $key['product_id'] ?></td>
                                <td><?= $key['game_key'] ?></td>
                                <td><?= $key['status'] ?></td>
                                <td>
                                    <button type="button"
                                        class="btn btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editKeyModal"

                                        data-id="<?= $key['key_id'] ?>"
                                        data-pid="<?= $key['product_id'] ?>"
                                        data-key="<?= htmlspecialchars($key['game_key']) ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>


                                    <a href="key_delete.php?delete_key=<?= $key["key_id"] ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการลบสินค้าหรือไม่ ??')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                    <?php   }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <script>
        const editKeyModal = document.getElementById('editKeyModal');

        editKeyModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            document.getElementById('modal_key_id').value = button.getAttribute('data-id');
            document.getElementById('modal_pid').value = button.getAttribute('data-pid');
            document.getElementById('modal_game_key').value = button.getAttribute('data-key');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>