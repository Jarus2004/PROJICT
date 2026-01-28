<?php
session_start();
require_once '../config/data.php';
if (isset($_POST['re'])){

    $username = $_POST['re-username'];
    $password = $_POST['re-password'];
    $email = $_POST['re-email'];
    $user_role = 'user';

        if(empty($username) || empty($password) || empty($email)){
            $_SESSION['error'] = "All fields are required.";
            header("Location: register.php");

        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] = "Invalid email format.";
            header("Location: register.php");
        }else{
                try{
                    $checkE = $conn->prepare("SELECT * FROM bob WHERE email = :email");
                    $checkE->bindParam(':email', $email);
                    $checkE->execute();
                    $row = $checkE->fetch(PDO::FETCH_ASSOC);
                    if($row['email'] == $email){
                        $_SESSION['error'] = "Email นี้ถูกใช้แล้ว";
                        header("Location: register.php");

                    }else if(!isset($_SESSION['error'])){

                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("INSERT INTO bob (username, password, email, user_role) VALUES (:username, :password, :email, :user_role)");
                        
                        $stmt->bindParam(':username', $username);
                        $stmt->bindParam(':password', $hashed_password);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':user_role', $user_role);
                        $stmt->execute();
                        $_SESSION['success'] = "Registration successful. You can now log in.";
                        header("Location: login.php");
                    }else{
                        $_SESSION['error'] = "An unexpected error occurred.";
                        header("Location: register.php");
                    }
                }catch(PDOException $e){
                    $_SESSION['error'] = "Database error: " . $e->getMessage();
                    header("Location: register.php");
                }
        }
    }
?>