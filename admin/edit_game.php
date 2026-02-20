<?php  
    require_once '../config/data.php';
    session_start(); 
    if(!isset($_SESSION['admin_login'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_FILES['image'];

        $image2 = $_POST['image2'];
        $upload = $_FILES['image']['name'];

        if($upload != ''){
                    $allowed = array('jpg', 'jpeg', 'png');
                    $extension = explode('.', $image["name"]);
                    $filesactext = strtolower(end($extension));
                    // $filenew = rand() . "." . $filesactext;
                    $filenew = bin2hex(random_bytes(16)) . "." . $filesactext;
                    $filePath = "../upload/" . $filenew;

                     if(in_array($filesactext, $allowed)){
                        if($image['size']>0 && $image['error']==0){
                            move_uploaded_file($image['tmp_name'], $filePath);
                        }
                     }
        }else{
            $filenew = $image2;
        }
        $sql = $conn->prepare("UPDATE games_table SET name_games=:name_games, price_games=:price_games, img_games=:img_games WHERE id_games=:id_games");
        $sql->bindParam(":id_games", $id);
        $sql->bindParam(":name_games", $name);
        $sql->bindParam(":price_games", $price);
        $sql->bindParam(":img_games", $filenew);
        $sql->execute();

        if($sql){
                        $_SESSION['success'] = "แก้ไขสินค้าเรียบร้อยแล้ว";
                        header("Location: admin_page.php?page=products");
                    }else{
                        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                        header("Location: admin_page.php?page=products");
                    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_page</title>
    <style>
        .container{
            max-width: 600px;
        }
    </style>
</head>
<body>
    <?php 
        if(isset($_SESSION['admin_login'])) {
            $admin_id = $_SESSION['admin_login'];
            $stmt = $conn->prepare("SELECT * FROM bob WHERE id = ?");
            $stmt->execute([$admin_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    ?>    
    <div class="container mt-5">
        <h1>แก้ไขสินค้า</h1>
        <hr>
            <form action="edit_game.php" method="post" enctype="multipart/form-data">
                <?php  
                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                        $stmt = $conn->prepare("SELECT * FROM games_table WHERE id_games = ?");
                        $stmt->execute([$id]);
                        $data = $stmt->fetch();
                    }
                ?>
                <div class="mb-3">
                    <input type="text" readonly value="<?= $data['id_games'] ?>" class="form-control" name="id" required>
                    <label for="name" class="col-form-label">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?= $data['name_games'] ?>" required>
                    <input type="hidden"  class="form-control" name="image2" value="<?= $data['img_games'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="col-form-label">Price:</label>
                    <input type="text" class="form-control" name="price" value="<?= $data['price_games'] ?>">
                </div>
                <div class="mb-3">
                    <label for="image" class="col-form-label">Image:</label>
                    <input type="file" class="form-control" name="image" id="imageinput">
                    <img width="100%" id="preview" src="upload/<?= $data['img_games'] ?>"alt="">
                </div>

                <div class="modal-footer">
                <a class="btn btn-secondary" href="admin_page.php?page=products">กลับ</a>
                <button type="submit" name="update" class="btn btn-success">บันทึก</button>
            </div>

            </form>
        
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    let imageinput = document.getElementById('imageinput');
    let preview = document.getElementById('preview');

    imageinput.onchange = evt => {
        const [file] = imageinput.files;
        if(file){
            preview.src = URL.createObjectURL(file);
        }
    }
</script>

</body>
</html>