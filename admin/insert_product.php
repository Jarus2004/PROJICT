<?php
    session_start();
    require_once '../config/data.php';

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_FILES['image'];

        $allowed = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $image["name"]);
        $filesactext = strtolower(end($extension));
        $filenew = rand() . "." . $filesactext;
        $filePath = "../upload/" . $filenew;

        if(in_array($filesactext, $allowed)){
            if($image['size']>0 && $image['error']==0){
                if(move_uploaded_file($image['tmp_name'], $filePath)){
                    $sql = $conn->prepare("INSERT INTO games_table(name_games,price_games,img_games) VALUES (:name_games,:price_games,:img_games)");
                    $sql->bindParam(":name_games", $name);
                    $sql->bindParam(":price_games", $price);
                    $sql->bindParam(":img_games", $filenew);
                    $sql->execute();

                    if($sql){
                        $_SESSION['success'] = "เพิ่มสินค้าเรียบร้อยแล้ว";
                        header("Location: admin_page.php?page=products");
                    }else{
                        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                        header("Location: admin_page.php?page=products");
                    }
                }
            }
        }
    }
?>