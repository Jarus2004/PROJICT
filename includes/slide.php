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

<div class="container mt-5">

    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

            <div class="swiper-slide">
                <img src="upload/9007ba69637aadf6df4c4ed76db42b76.jpeg">
            </div>

            <div class="swiper-slide">
                <img src="upload/7bb0bf4cf11ce39404ed0b656db19043.jpeg">
            </div>

            <div class="swiper-slide">
                <img src="upload/5095074aa824b32721e6b22ccfd8b047.jpeg">
            </div>

            <div class="swiper-slide">
                <img src="upload/f113eff05a3cc28c4d29a784ab7bf8b3.jpeg">
            </div>

            <div class="swiper-slide">
                <img src="upload/f63667170d82cc7f1db15e387c64fdd9.jpeg">
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