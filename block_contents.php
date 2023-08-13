<section class="container mb-5 panel">
    <h2 class="heading mb-4 mb-md-5"><span>Contents</span> <small>コンテンツ</small></h2>
    <div class="row g-2 row-cols-2 row-cols-md-4">
      <?php
      $rows = [
        [
          "thumb" => "slide/slide01.jpg",
          "title" => "コンテンツタイトル",
          "link" => "",
          "exp" => "コンテンツの説明が入ります。コンテンツの説明が入ります。コンテンツの説明が入ります。"
        ],
        [
          "thumb" => "slide/slide02.jpg",
          "title" => "コンテンツタイトル",
          "link" => "",
          "exp" => "コンテンツの説明が入ります。コンテンツの説明が入ります。コンテンツの説明が入ります。"
        ],
        [
          "thumb" => "slide/slide03.jpg",
          "title" => "コンテンツタイトル",
          "link" => "",
          "exp" => "コンテンツの説明が入ります。コンテンツの説明が入ります。コンテンツの説明が入ります。"
        ],
        [
          "thumb" => "slide/slide04.jpg",
          "title" => "コンテンツタイトル",
          "link" => "",
          "exp" => "コンテンツの説明が入ります。コンテンツの説明が入ります。コンテンツの説明が入ります。"
        ],
      ];
      ?>
      <?php
      $i = 0;
      foreach ($rows as $row) : ?>
        <div class="col wow fadeInUp" data-wow-delay="<?= ($i * 0.1) ?>s">
          <div class="box">
            <a href="<?= $row['link'] ?>" class="thumb thumb01-hold" style="background-image:url(<?= $row['thumb'] ?>);"></a>
            <a href="<?= $row['link'] ?>" class="title"><?= $row['title'] ?></a>
            <div class="exp"><?= $row['exp'] ?></div>
          </div>
        </div>
      <?php $i++;
      endforeach; ?>

    </div>
  </section>