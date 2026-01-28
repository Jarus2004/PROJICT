<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Swiper CSS -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .swiper {
            width: 100%;
            padding: 40px 0;
        }

        .swiper-slide {
            text-align: center;
            transition: 0.3s;
            width: 100%;
            height: 800px;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 10px;
        }

        /* รูปที่ไม่ใช่ตรงกลาง */
        .swiper-slide:not(.swiper-slide-active) {
            transform: scale(0.85);
            opacity: 0.5;
        }
    </style>


</head>

<body>
    <div class="container mt-5">

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <img src="../upload/1828724376.jpeg">
                </div>

                <div class="swiper-slide">
                    <img src="../upload/1242404011.jpeg">
                </div>

                <div class="swiper-slide">
                    <img src="../upload/1085580583.jpeg">
                </div>

                <div class="swiper-slide">
                    <img src="../upload/763445453.jpeg">
                </div>

                <div class="swiper-slide">
                    <img src="../upload/657582762.jpeg">
                </div>

            </div>

            <!-- ปุ่ม -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            centeredSlides: true,
            loop: true,

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

</body>

</html>