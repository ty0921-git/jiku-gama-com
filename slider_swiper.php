<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<link rel="stylesheet" href="js/swiper/swiper.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<div class="position-relative min">
    <div class="swiper mb-5">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <picture>
                    <source srcset="slide/slide02_sp.jpg" media="(max-width:767px)">
                    <img class="img-fluid" src="slide/slide02.jpg">
                </picture>
                <!-- <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1 wow fadeInRight">
                    <h2 class="mb-2 min fs10 fs-md-20">陶の心、時の旅路</h2>
                    <p class="fs09 fs-md-10">時間の流れを捉え、形に留めた瞬間の美。</p>
                </div> -->
            </div>
            <div class="swiper-slide">
                <picture>
                    <source srcset="slide/slide04_sp.jpg" media="(max-width:767px)">
                    <img class="img-fluid" src="slide/slide04.jpg">
                </picture>
                <!-- <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1">
                    <h2 class="mb-2 min fs10 fs-md-20">陶芸の魔法、時空を超えて</h2>
                    <p class="fs09 fs-md-10">世界の果てまで、心の中まで、旅を続ける陶。</p>
                </div> -->
            </div>
            <div class="swiper-slide">
                <picture>
                    <source srcset="slide/slide05_sp.jpg" media="(max-width:767px)">
                    <img class="img-fluid" src="slide/slide05.jpg">
                </picture>
                <!-- <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1">
                    <h2 class="mb-2 min fs10 fs-md-20">陶芸の魔法、時空を超えて</h2>
                    <p class="fs09 fs-md-10">世界の果てまで、心の中まで、旅を続ける陶。</p>
                </div> -->
            </div>
            <div class="swiper-slide">
                <picture>
                    <source srcset="slide/slide06_sp.jpg" media="(max-width:767px)">
                    <img class="img-fluid" src="slide/slide06.jpg">
                </picture>
                <!-- <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1">
                    <h2 class="mb-2 min fs10 fs-md-20">陶芸の魔法、時空を超えて</h2>
                    <p class="fs09 fs-md-10">世界の果てまで、心の中まで、旅を続ける陶。</p>
                </div> -->
            </div>
            <div class="swiper-slide">
                <picture>
                    <source srcset="slide/slide01_sp.jpg" media="(max-width:767px)">
                    <img class="img-fluid" src="slide/slide01.jpg">
                </picture>
                <!-- <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1">
                    <h2 class="mb-2 min fs10 fs-md-20">時空を編む、手の中の宇宙</h2>
                    <p class="fs09 fs-md-10">一つ一つ、星のように瞬く、永遠の陶の詩。</p>
                </div> -->
            </div>
            <div class="swiper-slide">
                <picture>
                    <source srcset="slide/slide03_sp.jpg" media="(max-width:767px)">
                    <img class="img-fluid" src="slide/slide03.jpg">
                </picture>
                <!-- <div class="swiper-caption ps-md-5 pb-md-5 ps-4 pb-1">
                    <h2 class="mb-2 min fs10 fs-md-20">過去と未来、その手で触れる</h2>
                    <p class="fs09 fs-md-10">古の風合い、未来のデザイン、ここに集結。</p>
                </div> -->
            </div>
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need scrollbar -->
        <!-- <div class="swiper-scrollbar"></div> -->
    </div>
    <div class="position-absolute logo-fv">
        <img src="image/logo-fv.svg" width="300">
    </div>
</div>

<script>
    var swiper = new Swiper(".swiper", {
        loop: true,
        loopAdditionalSlides: 1,
        speed: 1500,
        autoplay: {
            delay: 1500,
            disableOnInteraction: false,
        },
        effect: 'fade',
        slidesPerView: 1,
        centeredSlides: true,
        spaceBetween: 0,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
        },

        // Navigation arrows
        navigation: false,

        // And if we need scrollbar
        // scrollbar: {
        //     el: '.swiper-scrollbar',
        // },
    });
</script>