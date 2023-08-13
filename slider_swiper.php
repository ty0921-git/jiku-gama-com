<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<link rel="stylesheet" href="js/swiper/swiper.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<div class="swiper mb-5 mt-4">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <picture>
                <source srcset="slide/slide01_sp.jpg" media="(max-width:767px)">
                <img class="img-fluid" src="slide/slide01.jpg">
            </picture>
            <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1">
                <h2 class="mb-2 min">First_Slide_Lavel</h2>
                <p class="">swiper_slide_subtitle_message</p>
            </div>
        </div>
        <div class="swiper-slide">
            <picture>
                <source srcset="slide/slide02_sp.jpg" media="(max-width:767px)">
                <img class="img-fluid" src="slide/slide02.jpg">
            </picture>
            <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1 wow fadeInRight">
                <h2 class="mb-2 min">Second_Slide_Lavel</h2>
                <p class="">swiper_slide_subtitle_message</p>
            </div>
        </div>
        <div class="swiper-slide">
            <picture>
                <source srcset="slide/slide03_sp.jpg" media="(max-width:767px)">
                <img class="img-fluid" src="slide/slide03.jpg">
            </picture>
            <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1">
                <h2 class="mb-2 min">Third_Slide_Lavel</h2>
                <p class="">swiper_slide_subtitle_message</p>
            </div>
        </div>
        <div class="swiper-slide">
            <picture>
                <source srcset="slide/slide04_sp.jpg" media="(max-width:767px)">
                <img class="img-fluid" src="slide/slide04.jpg">
            </picture>
            <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1">
                <h2 class="mb-2 min">4th_Slide_Lavel</h2>
                <p class="">swiper_slide_subtitle_message</p>
            </div>
        </div>
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>

    <!-- If we need scrollbar -->
    <!-- <div class="swiper-scrollbar"></div> -->
</div>

<script>
    var swiper = new Swiper(".swiper", {
        loop: true,
        loopAdditionalSlides: 1,
        speed: 500,
        autoplay: {
            disableOnInteraction: false,
        },
        slidesPerView: 1.1,
        centeredSlides: true,
        spaceBetween: 10,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1.2,
                spaceBetween: 30,
            },
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        // scrollbar: {
        //     el: '.swiper-scrollbar',
        // },
    });
</script>