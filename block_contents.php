<section class="container mb-5 panel">
  <h2 class="heading mb-4 mb-md-5 min"><span>Gallery</span> <small>ギャラリー</small></h2>
  <div class="row g-2 row-cols-2 row-cols-md-3 mb-5">
    <?php
    $i = 0;
    shuffle($num);
    $rows = array_slice($num, 0, 6);

    foreach ($rows as $row) : $img = "gallery/g" . sprintf('%05d', $row) . ".jpg"; ?>
      <div class="col wow fadeInUp" data-wow-delay="<?= ($i * 0.1) ?>s">
        <div class="box">
          <a href="<?= $row ?>" class="thumb thumb01-hold" style="background-image:url(<?= $img ?>);"></a>
        </div>
      </div>
    <?php $i++;
    endforeach; ?>

  </div>
  <div class="text-center">
    <a href="gallery.html" class="btn btn-btn">作品一覧はこちら</a>
  </div>
</section>


<section class="fix-bg mb-5 d-flex align-items-center" style="background-image:url(image/fix-bg01.jpg);">
  <div class="fs30 text-white min container">土と共に</div>
</section>




<section class="container mb-5 min">
  <h2 class="heading mb-4 mb-md-5"><span>Potter</span> <small>陶芸家</small></h2>

  <div class="row g-md-5">
    <div class="col-md-4">
      <img src="image/potter3.jpg" class="img-fluid mb-4 mb-md-0">
    </div>
    <div class="col-md-8">

      <div class="mb-5">
        <span>陶芸家</span>
        <h2 class="fs20 mb-4">峰 とし子 <small>- Mine Toshiko -</small></h2>
        <p>陶器の魅力に導かれ独学で一心不乱、陶芸に没頭。その後、人間国宝「井上萬二」氏に師事し、陶芸の基礎を習得。既成に捉われない自由な発想で作陶活動を展開。</p>
        <a href="profile.html" class="btn btn-btn mt-4">プロフィールはこちら</a>
      </div>

      <div>
        <h2 class="mb-3">時空 <small>- Gallery -</small></h2>
        <div class="row g-1 mb-4">
          <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".1s"><img src="image/jiku01-1s.jpg" class="img-fluid" loading="lazy"></div>
          <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".2s"><img src="image/jiku01-2s.jpg" class="img-fluid" loading="lazy"></div>
          <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".3s"><img src="image/jiku02s.jpg" class="img-fluid" loading="lazy"></div>
          <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".4s"><img src="image/jiku03s.jpg" class="img-fluid" loading="lazy"></div>
          <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".1s"><img src="image/jiku04s.jpg" class="img-fluid" loading="lazy"></div>
          <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".2s"><img src="image/jiku05s.jpg" class="img-fluid" loading="lazy"></div>
          <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".3s"><img src="image/jiku06s.jpg" class="img-fluid" loading="lazy"></div>
          <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".4s"><img src="image/jiku07s.jpg" class="img-fluid" loading="lazy"></div>
        </div>
        <a href="about.html"><span class="arrow-right me-2"></span>時空へのアクセスはこちら</a>
      </div>

    </div>
  </div>
</section>
