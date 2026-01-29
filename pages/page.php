<?php
require_once '../config/data.php';
session_start();
if (!isset($_SESSION['user_login'])) {
    header("Location: ../auth/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <!-- link FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Press+Start+2P&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- BOOTSTRAP SYTLES -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jarus SHOP</title>
    <style>
        .bigfront {
            font-size: 50px;
            font-weight: bold;
        }

        .imggift .col p {
            pointer-events: none;
        }

        .imggift .col:hover p {
            color: red;
            font-weight: bold;
        }

        .imggift .col:hover,
        .member .col:hover {
            transform: scale(1.1);
            transition: all 0.3s ease-in-out;
            opacity: 0.6;
        }

        nav a:hover {
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        .bg-black-rgb {
            background: #0f0c29;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #24243e, #302b63, #0f0c29);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #24243e, #302b63, #0f0c29);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        .rounded-edit {
            border-radius: 25px;
        }

        .back {
            background: #000000;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #434343, #000000);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #434343, #000000);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        .font-2P {
            font-family: "Press Start 2P", system-ui;
            font-weight: 400;
            font-style: normal;
        }

        .font-thai {
            font-family: "Kanit", sans-serif;
            font-weight: 700;
            font-style: normal;
        }
    </style>
</head>

<body class="bg-black-rgb text-warning font-thai">
    <?php
    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        $stmt = $conn->prepare("SELECT * FROM bob WHERE id = $user_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <div class="container-fluid back p-3 mb-5 position-sticky top-0">
        <div class="d-flex justify-content-between">
            <div class="fs-4 fw-bold">
                ยินดีต้อนรับ, <?php echo $row['username']; ?>
            </div>
            <div class="d-flex gap-4">
                <a href="../cart/cart_page.php" class="text-decoration-none fs-4 fw-bold text-warning"><i class="bi bi-bag-fill"></i> ตะกร้าสินค้า </a>
                <a href="../auth/logout.php" class="text-decoration-none fs-4 fw-bold text-warning">ออกจากระบบ</a>
            </div>
        </div>
    </div>

    <h1 class="text-center p-3 font-2P" style="font-size: 70px;">WELCOME TO JARUS STORE</h1>

    <!-- สไลด์รูปภาพ -->
    <div class="container m-auto">
        <?php
        include '../includes/slide.php';
        ?>
    </div>

    <!-- เกมทั้งหมด -->
    <div class="container-xl mt-5 mb-5 mx-auto p-5">
        <h1 class="bigfront mb-3">สินค้าที่นิยม</h1>

        <!-- ช่องค้นหา -->
        <nav class="navbar navbar-light mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" action="page.php" method="get">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                    <button class="btn btn-outline-success" type="submit">ค้นหา</button>
                </form>
            </div>
        </nav>

        <div class="row row-cols-4">
            <?php
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';

            $limit = 9; // แสดง 10 รายการต่อหน้า
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $page = max($page, 1);
            $offset = ($page - 1) * $limit;

            $where = '';
            $params = [];

            if ($search !== '') {
                $where = "WHERE name_games LIKE :search";
                $params[':search'] = "%$search%";
            }

            // ดึงข้อมูลตามหน้า
            $sql = "SELECT * FROM games_table $where LIMIT :limit OFFSET :offset";
            $stmt = $conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($games)){
            foreach ($games as $game) {
            ?>
                <div class="col mx-5 mb-4 bg-black-rgb rounded-edit" width="100px">
                    <img width="100%" height="300px" src="../upload/<?= $game['img_games'] ?>" alt="<?= $game['name_games'] ?>" class="rounded-edit mt-2" />
                    <h4 class="text-center mt-3 text-warning"><?= $game['name_games'] ?></h4>
                    <hr class="bg-white">
                    <h5 class="text-center mb-3 text-warning">ราคา :<?= $game['price_games'] ?>บาท</h5>

                    <!-- ฟอร์มเพิ่มลงตะกร้า -->
                    <form action="../cart/add_to_cart.php" method="post" class="text-center mb-2">
                        <input type="hidden" name="product_id" value="<?= $game['id_games'] ?>">
                        <input type="hidden" name="price" value="<?= $game['price_games'] ?>">
                        <button type="submit" class="btn btn-success">
                            เพิ่มลงในรถเข็น
                        </button>
                    </form>
                </div>
                
            <?php } ?>
            <?php }else{
                echo"<p class=\"text-center w-100 fs-2 m-5\">ไม่พบข้อมูลที่ค้นหา</p>";
            } ?>

            <?php
            $countSql = "SELECT COUNT(*) FROM games_table $where";
            $countStmt = $conn->prepare($countSql);
            if ($search !== '') {
                $countStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }
            $countStmt->execute();
            $totalGames = $countStmt->fetchColumn();
            $totalPages = ceil($totalGames / $limit);


            ?>
        </div>
        <nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link"
                   href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>

    </div>


    <!-- สิทธ์สมาชิก -->
    <div class="container text-center">
        <h1 class="text-start bigfront">สิทธิ์สมาชิก</h1>
        <div class="row member" width="100px">
            <div class="col">
                <img width="100%" src="https://a.storyblok.com/f/77562/960x920/df31ecb323/a-storyblok-2.png/m/" alt="MEMBER ICON" class="" />

            </div>
            <div class="col">
                <img width="100%" src="https://a.storyblok.com/f/210486/960x920/924849b4d6/nintendo-switch.png/m/" alt="MEMBER ICON" class="" />
            </div>
            <div class="col">
                <img width="100%" src="https://a.storyblok.com/f/77562/960x920/1187706966/a-storyblok-1.png/m/" alt="MEMBER ICON" class="" />
            </div>
        </div>
    </div>


    <!-- บัตรของขวัญ -->
    <div class="container mt-5 mb-4 text-center">
        <h1 class="text-start bigfront">บัตรของขวัญ</h1>
        <div class="row row-cols-4 imggift font-2P fs-4">
            <div class="col position-relative"><img src="https://a.storyblok.com/f/210486/315x188/7ca7af17b2/playstation-gift-cards.png/m/" alt="GIFT ICON" class="" />
                <p class="position-absolute end-0 start-0 top-40 bottom-50">PLAYSTATION</p>
            </div>
            <div class="col position-relative"><img src="https://a.storyblok.com/f/210486/315x188/7ca7af17b2/playstation-gift-cards.png/m/" alt="GIFT ICON" class="" />
                <p class="position-absolute end-0 start-0 top-40 bottom-50">XBOX</p>
            </div>
            <div class="col position-relative"><img src="https://a.storyblok.com/f/210486/315x188/7ca7af17b2/playstation-gift-cards.png/m/" alt="GIFT ICON" class="" />
                <p class="position-absolute end-0 start-0 top-40 bottom-50">STEAM</p>
            </div>
            <div class="col position-relative"><img src="https://a.storyblok.com/f/210486/315x188/7ca7af17b2/playstation-gift-cards.png/m/" alt="GIFT ICON" class="" />
                <p class="position-absolute end-0 start-0 top-40 bottom-50">NINTENDO</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="container-fluid p-1 bg-dark text-center">
    <h5 class="p-1">Made By.Jarus Saenubon </h5>
</footer>

</html>