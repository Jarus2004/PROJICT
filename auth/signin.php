<?php
session_start();
require_once '../config/data.php';
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

        if(empty($username)){
            $_SESSION['error'] = "Username ไม่ถูกต้อง";
            header("Location: login.php");

        }else if(empty($password)){
            $_SESSION['error'] = "Password ไม่ถูกต้อง";
            header("Location: login.php");
        
        }else{
                try{
                    $checkdata = $conn->prepare("SELECT * FROM bob WHERE username = :username");
                    $checkdata->bindParam(':username', $username);
                    $checkdata->execute();
                    $row = $checkdata->fetch(PDO::FETCH_ASSOC);

                    if($checkdata->rowCount() > 0){
                        if($username == $row['username']){
                            if(password_verify($password,$row['password'])){
                                if($row['user_role'] == 'admin'){
                                    $_SESSION['admin_login'] = $row['id'];
                                    header("Location: ../admin/admin_page.php");
                                }else{
                                    $_SESSION['user_login'] = $row['id'];
                                    header("Location: ../pages/page.php");
                                }
                            }else{
                                $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
                                header("Location: login.php");
                            }
                        }else{
                        $_SESSION['error'] = "ชื่อผู้ใช้ไม่ถูกต้อง";
                        header("Location: login.php");
                        }
                    }else{
                        $_SESSION['error'] = "ไม่พบชื่อผู้ใช้ในระบบ";
                        header("Location: login.php");
                    }
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
        }
    }
?>