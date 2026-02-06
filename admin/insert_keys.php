<?php
    session_start();
    require_once '../config/data.php';

    if(isset($_POST['submitkeys'])){
        $product_id = $_POST['pid'];
        $key = $_POST['key'];

        $stmt = $conn->prepare("SELECT id_games FROM games_table WHERE id_games = :product_id");
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        $game = $stmt->fetch();

        if(empty($game)){
            $_SESSION['error'] = "ไม่มี ID ของเกมนี้ในระบบ";
            header("refresh:1; url=key_games.php");
            exit();
        }else{
                    $sql = $conn->prepare("INSERT INTO game_keys(product_id,game_key) VALUES (:product_id,:game_key)");
                    $sql->bindParam(":product_id", $product_id);
                    $sql->bindParam(":game_key", $key);
                    $sql->execute();

                    if($sql){
                        $_SESSION['success'] = "เพิ่มสินค้าเรียบร้อยแล้ว";
                        header("Location:key_games.php");
                    }else{
                        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                        header("Location:key_games.php");
                    }
            }
    }
?>