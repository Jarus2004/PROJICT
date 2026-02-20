<?php  
    require_once '../config/data.php';
    session_start(); 
    if(!isset($_SESSION['user_login'])){
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <?php 
        $row = null;
        if(isset($_SESSION['user_login'])) {
            $user_id = $_SESSION['user_login'];
            $stmt = $conn->prepare("SELECT * FROM bob WHERE id = ?");
            $stmt->execute([$user_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    ?>
    <div class="head">
    <a href="logout.php">Logout</a>
    <div id="A">
        <img src="https://img.icons8.com/ios-filled/50/000000/lock--v1.png" alt="Lock Icon"/>
        <p>ปลอดภัย <?php echo isset($row['username']) ? $row['username'] : 'Guest'; ?></p>
        <p>100% ความปลอดภัย และ สนับสนุน 24ชั่วโมง</p>
    </div>

    <div id="B">
        <p>ยอดเยี่ยม 4.8 จาก 5 คะแนน จากการรีวิว 215,933 ครั้ง</p>
    </div>

    <div id="C">
        <p>รวดเร็ว</p>
        <p>ดาวน์โหลดดิจิทัลได้ทันที</p>
    </div>

    </div>
    <div class="link">
        <a href="https://www.loaded.com/promotion-terms">ซื้อสินค้าในโปรโมชั่นคริสต์มาสของเราครบ 50 ดอลลาร์ขึ้นไป รับส่วนลด 50%</a>
    </div>
    
    <div class="homepage">

        <h1>เกมแห่งปี 2025</h1>
    <div class="game">
        <div id="G">
            <a href="https://www.loaded.com/clair-obscur-expedition-33-pc-steam"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/c/l/clair_obscur-_expedition_33_.png" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/clair-obscur-expedition-33-pc-steam"><p>Clair Obscur: Expedition 33 PC</p></a>
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0001">BUY</button>
            </form>
        </div>

        <div id="G">
            <a href="https://www.loaded.com/arc-raiders-pc-steam"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/u/n/untitled_design.png" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/arc-raiders-pc-steam"><p>Arc Raiders PC Key</p></a>
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0002">BUY</button>
            </form>
        </div>

        <div id="G">
            <a href="https://www.loaded.com/battlefield-6-xbox-series-x-s"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/b/a/battlefield_6_pc_cdkeys_2.png" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/battlefield-6-xbox-series-x-s"><p>Battlefield 6 Xbox Series X/S</p></a>
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0003">BUY</button>
            </form>
        </div>

        <div id="G">
            <a href="https://www.loaded.com/no-mans-sky-pc-steam-cd-key"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/m/i/microsoftteams-image_27_.jpg" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/no-mans-sky-pc-steam-cd-key"><p>No Man's Sky PC Key</p></a>
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0004">BUY</button>
            </form>
        </div>

        <div id="G">
            <a href="https://www.loaded.com/hollow-knight-silksong-pc-steam"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/h/o/hollow_knight_silksong_cdkeys.png" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/hollow-knight-silksong-pc-steam"><p>Hollow Knight: Silksong PC Key</p></a>
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0005">BUY</button>
            </form>
        </div>
        
        <div id="G">
            <a href="https://www.loaded.com/doom-the-dark-ages-pc-steam"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/d/o/doom_dark_ages.png" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/doom-the-dark-ages-pc-steam"><p>Doom: The Dark Ages PC Key</p></a>
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0006">BUY</button>
            </form>
        </div>

        <div id="G">
            <a href="https://www.loaded.com/fatal-fury-city-of-the-wolves-special-edition-pc-steam"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/f/a/fatal_fury_city_of_the_wolves_special_edition_.png" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/fatal-fury-city-of-the-wolves-special-edition-pc-steam"><p>Fatal Fury: City of the Wolves Special Edition PC Key</p></a>
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0007">BUY</button>
            </form>
        </div>

        <div id="G">
            <a href="https://www.loaded.com/helldivers-2-pc-steam"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/h/e/helldivers_2_into_the_unjust_art_work.png" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/helldivers-2-pc-steam"><p>Helldivers 2 PC Key</p></a>
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0008">BUY</button>
            </form>
        </div>

        <div id="G">
            <a href="https://www.loaded.com/ea-sports-fc-26-xbox-one-xbox-series-x-s"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/f/c/fc26_standard_edition_cdkeys_2.png" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/ea-sports-fc-26-xbox-one-xbox-series-x-s"><p>EA Sports FC 26 Xbox One Xbox Series X/S</p></a>   
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0009">BUY</button>
            </form>
        </div>

        <div id="G">
            <a href="https://www.loaded.com/peak-pc-steam"><img src="https://cdn.cdkeys.com/245x340/media/catalog/product/p/e/peak_pc.png" alt="Games Icon"/></a>
            <a href="https://www.loaded.com/peak-pc-steam"><p>Peak PC Key</p></a>
            <legend class="border"></legend>
            <p>ราคา: 1,200 บาท</p>
            <form action="data.php" method="post" target="_self">
                <button type="submit" class="buy" value="0010">BUY</button>
            </form>
        </div>
    </div>

    <div class="memberships">

        <h1>สิทธิ์สมาชิก</h1>
        <table class="table-memberships">
            <tr>
                <td><a href="https://www.loaded.com/xbox-live/memberships"><img src="https://a.storyblok.com/f/77562/960x920/df31ecb323/a-storyblok-2.png/m/" alt="MEMBER ICON" class="imgMEM"/></a></td>
                <td><a href="https://www.loaded.com/nintendo/nintendo-memberships"><img src="https://a.storyblok.com/f/210486/960x920/924849b4d6/nintendo-switch.png/m/" alt="MEMBER ICON" class="imgMEM"/></a></td>
                <td><a href="https://www.loaded.com/playstation-network-psn/playstation-plus"><img src="https://a.storyblok.com/f/77562/960x920/1187706966/a-storyblok-1.png/m/" alt="MEMBER ICON" class="imgMEM"/></a></td>
            </tr>
        </table>
    </div>

    <div class="gift">
        <h1>บัตรของขวัญ</h1>

        <table class="table-giftcard">
            <tr>
                <td><a href="https://www.loaded.com/playstation-network-psn/psn-cards"><img src="https://a.storyblok.com/f/210486/315x188/7ca7af17b2/playstation-gift-cards.png/m/" alt="GIFT ICON" class="imgGIFT"/></a><p>PLAYSTATION<br/>GIFT CARDS</p></td>
                <td><a href="https://www.loaded.com/xbox-live/gift-cards-points"><img src="https://a.storyblok.com/f/210486/315x188/055b59ba07/xbox-gift-cards.png/m/" alt="GIFT ICON" class="imgGIFT"/></a><p>XBOX<br/>GIFT CARDS</p></td>
                <td><a href="https://www.loaded.com/nintendo/eshop-topup-cards"><img src="https://a.storyblok.com/f/210486/315x188/b676c1be67/nintendo-e-shop-cards.png/m/" alt="GIFT ICON" class="imgGIFT"/></a><p>NINTENDO<br/>E-SHOP CARDS</p></td>
                <td><a href="https://www.loaded.com/top-up-cards/steam"><img src="https://a.storyblok.com/f/210486/315x188/0f639a5d88/steam-gift-cards.png/m/" alt="GIFT ICON" class="imgGIFT"/></a><p>STEAM<br/>GIFT CARDS</p></td>
            </tr>
        </table>
    </div>
    </div>

</body>
<footer>
    <p>Made By.Jarus Saenubon </p>
</footer>
</html>