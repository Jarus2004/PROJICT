<?php  
    require_once '../config/data.php';
    session_start(); 

    if(isset($_POST['submit_edit_keys'])){
        $id = $_POST['key_id'];
        $pid = $_POST['pid'];
        $key = $_POST['game_key'];

        $stmt = $conn->prepare("SELECT id_games FROM games_table WHERE id_games = :product_id");
        $stmt->bindParam(":product_id", $pid);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $_SESSION['error'] = "ไม่มี Product ID นี้ในระบบ";
            header("Location: key_games.php");
            exit();
        }

        $sql = $conn->prepare("UPDATE game_keys SET product_id=:product_id, game_key=:game_key WHERE key_id=:key_id");
        $sql->bindParam(":key_id", $id);
        $sql->bindParam(":game_key", $key);
        $sql->bindParam(":product_id", $pid);
        $sql->execute();

        if($sql){
                        $_SESSION['success'] = "แก้ไขสินค้าเรียบร้อยแล้ว";
                        header("Location: key_games.php");
                    }else{
                        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                        header("Location: key_games.php");
                    }
    }
?>