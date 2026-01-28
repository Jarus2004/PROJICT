<?php
require_once '../config/data.php';
?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        .back {
            background: #FFC72C;
            background: linear-gradient(320deg, rgba(255, 199, 44, 1) 25%, rgba(38, 0, 82, 1) 60%);
            color:wheat;
        }
        .wheat {
            color: wheat;
        }
    </style>
</head>

<body class="d-flex align-items-center vh-100 back">
    <div class="container shadow-lg rounded-3 p-4">
        <form class="container shadow mt-5 mb-5" action="roe.php" method="POST">
            <h1 class="fw-bold fs-1">สมัครสมาชิก</h1>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php }; ?>

            <div class="mb-3 p-3">
                <label for="email" class="form-label fw-bold fs-5">อีเมล</label>
                <input type="email" class="form-control shadow fs-5" id="email" name="re-email" aria-describedby="emailHelp" required placeholder="กรุณากรอกอีเมล">
            </div>
            <div class="mb-3 p-3">
                <label for="username" class="form-label fw-bold fs-5">ชื่อผู้ใช้</label>
                <input type="text" class="form-control shadow fs-5" id="username" name="re-username" aria-describedby="emailHelp" required placeholder="กรุณากรอกชื่อผู้ใช้">
            </div>
            <div class="mb-3 p-3">
                <label for="password" class="form-label fw-bold fs-5">รหัสผ่าน</label>
                <input type="password" class="form-control shadow fs-5" id="password" name="re-password" required placeholder="กรุณากรอกรหัสผ่าน">
            </div>

            <input type="submit" value="สมัครสมาชิก" class="btn btn-primary m-2 shadow fw-bold wheat" name="re">
            <button type="button" class="btn btn-danger m-2 shadow"><a href="login.php" class="text-decoration-none fw-bold wheat" target="_self">กลับไปหน้าเข้าสู่ระบบ</a></button>
        </form>
    </div>
</body>

</html>