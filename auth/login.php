<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
    <style>
        .back {
            background: #3f2f8f;
            background: linear-gradient(230deg, rgba(63, 47, 143, 1) 40%, rgba(38, 0, 82, 1) 80%);
            color: wheat;
        }
        .wheat {
            color: wheat;
        }
    </style>
</head>

<body class="d-flex align-items-center vh-100 back">
    <div class="container shadow-lg rounded-3 p-4">
        <h1 class="fw-bold fs-1">เข้าสู่ระบบ</h1>
        <form class="container shadow" action="signin.php" method="post">

            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger mt-2" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php }; ?>

            <div class="mb-3 p-3">
                <label for="username" class="form-label fs-5 fw-bold">ชื่อผู้ใช้</label>
                <input type="text" class="form-control shadow fs-5" id="username" name="username" aria-describedby="emailHelp" required placeholder="กรุณากรอกชื่อผู้ใช้">
            </div>
            <div class="mb-3 p-3">
                <label for="password" class="form-label fs-5 fw-bold">รหัสผ่าน</label>
                <input type="password" class="form-control shadow fs-5" id="password" name="password" required placeholder="กรุณากรอกรหัสผ่าน">
            </div>

            <button type="submit" class="btn btn-primary m-2 shadow fw-bold wheat" name="login" value="Login">เข้าสู่ระบบ</button>
            <button type="button" class="btn btn-danger m-2 shadow"><a href="register.php" class="text-decoration-none fw-bold wheat" target="_self">สมัครสมาชิก</a></button>

        </form>
    </div>
</body>

</html>