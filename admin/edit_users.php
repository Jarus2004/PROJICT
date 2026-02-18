<?php  
    require_once '../config/data.php';
    session_start(); 

    if(isset($_POST['submit_edit_users'])){
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $user_role = $_POST['user_role'];

        $stmt = $conn->prepare("SELECT id FROM bob WHERE id = :user_id");
        $stmt->bindParam(":user_id", $id);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $_SESSION['error'] = "ไม่มี User ID นี้ในระบบ";
            header("Location: admin_page.php?page=user");
            exit();
        }

        $sql = $conn->prepare("UPDATE bob SET username=:username, email=:email, user_role=:user_role WHERE id=:id");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":username", $username);
        $sql->bindParam(":email", $email);
        $sql->bindParam(":user_role", $user_role);
        $sql->execute();

        if($sql){
                        $_SESSION['success'] = "แก้ไข User เรียบร้อยแล้ว";
                        header("Location: admin_page.php?page=user");
                    }else{
                        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                        header("Location: admin_page.php?page=user");
                    }
    }
?>