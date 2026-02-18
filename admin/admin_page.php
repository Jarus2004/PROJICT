<?php
require_once '../config/data.php';
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_page</title>
</head>

<body class="d-flex flex-column vh-100">
    <?php
    if (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        $stmt = $conn->prepare("SELECT * FROM bob WHERE id = ?");
        $stmt->execute([$admin_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <main>
        <div class="d-flex">
            <nav>
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height:100vh;">
                    <a href="admin_page.php?page=dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                        <img src="../loadpicture/KING.png" alt="" width="40" height="40" class="me-2">
                        <span class="fs-4">ADMIN</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="admin_page.php?page=dashboard" class="nav-link <?= ($_GET['page'] ?? '') == 'dashboard' ? 'active' : 'link-dark' ?>">
                                DASHBOARD
                            </a>

                        </li>
                        <li>
                            <a href="admin_page.php?page=products" class="nav-link <?= ($_GET['page'] ?? '') == 'products' ? 'active' : 'link-dark' ?>">
                                PRODUCT
                            </a>
                        </li>
                        <li>
                            <a href="admin_page.php?page=user" class="nav-link <?= ($_GET['page'] ?? '') == 'user' ? 'active' : 'link-dark' ?>">
                                USER
                            </a>
                        </li>
                        <li>
                            <a href="admin_page.php?page=key" class="nav-link <?= ($_GET['page'] ?? '') == 'key' ? 'active' : 'link-dark' ?>">
                                KEYS
                            </a>
                        </li>
                        <li>
                            <a href="admin_page.php?page=orders" class="nav-link <?= ($_GET['page'] ?? '') == 'orders' ? 'active' : 'link-dark' ?>">
                                ORDERS
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <button
                            type="button"
                            class="btn d-flex align-items-center dropdown-toggle"
                            id="dropdownUser2"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="../loadpicture/KING.png" width="32" height="32" class="rounded-circle me-2">
                            <strong><?= $row['username'] ?></strong>
                        </button>

                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../auth/logout.php">Sign out</a></li>
                        </ul>
                    </div>


                </div>
            </nav>


            <div class="flex-grow-1 p-3">
                <?php
                $page = $_GET['page'] ?? 'dashboard';

                switch ($page) {
                    case 'user':
                        include '../includes/userpage.php';
                        break;
                    case 'products':
                        include 'product.php';
                        break;
                    case 'key':
                        include 'key_games.php';
                        break;
                    case 'orders':
                        include 'orders_admin.php';
                        break;
                    default:
                        include 'dashbord.php';
                        break;
                }
                ?>


            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>