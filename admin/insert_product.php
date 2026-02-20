<?php
session_start();
require_once '../config/data.php';

if (isset($_POST['submit'])) {
    $image = $_FILES['image'];
    $name = trim($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);

    if (empty($name) || strlen($name) > 100) {
        $_SESSION['error'] = "Product name is required and must be less than 100 characters";
        header("Location: admin_page.php?page=products");
        exit();
    }

    if ($price <= 0) {
        $_SESSION['error'] = "Price must be greater than 0";
        header("Location: admin_page.php?page=products");
        exit();
    }

    $allowed = array('jpg', 'jpeg', 'png');
    $extension = explode('.', $image["name"]);
    $filesactext = strtolower(end($extension));
    $filenew = bin2hex(random_bytes(16)) . "." . $filesactext;
    $filePath = "../upload/" . $filenew;

    // Validate file size (max 5MB)
    if ($image['size'] > 5 * 1024 * 1024) {
        $_SESSION['error'] = "File size too large (max 5MB)";
        header("Location: admin_page.php?page=products");
        exit();
    }

    // Validate MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $image['tmp_name']);
    $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($mime, $allowed_mimes)) {
        $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, PNG allowed.";
        header("Location: admin_page.php?page=products");
        exit();
    }

    if (in_array($filesactext, $allowed)) {
        if ($image['size'] > 0 && $image['error'] == 0) {
            if (move_uploaded_file($image['tmp_name'], $filePath)) {
                $sql = $conn->prepare("INSERT INTO games_table(name_games,price_games,img_games) VALUES (:name_games,:price_games,:img_games)");
                $sql->bindParam(":name_games", $name);
                $sql->bindParam(":price_games", $price);
                $sql->bindParam(":img_games", $filenew);
                $sql->execute();

                if ($sql) {
                    $_SESSION['success'] = "เพิ่มสินค้าเรียบร้อยแล้ว";
                    header("Location: admin_page.php?page=products");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("Location: admin_page.php?page=products");
                }
            } else {
                $_SESSION['error'] = "Failed to upload image file";
                header("Location: admin_page.php?page=products");
            }
        } else {
            $_SESSION['error'] = "Invalid or missing image file";
            header("Location: admin_page.php?page=products");
        }
    } else {
        $_SESSION['error'] = "Invalid file extension. Only JPG, JPEG, PNG allowed.";
        header("Location: admin_page.php?page=products");
    }
}
