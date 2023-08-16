<?php
require("head.php");
?>
<title>ギャラリー | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
  <?php
  require("nav.php");
  ?>
  <section class="p-2 p-md-4"></section>


  <section class="container mb-5">
    <h2 class="heading min mb-4 mb-md-5"><span>Gallery</span> <small>ギャラリー</small></h2>

    <div id="showcase" class="d-none p-3">
      <img src="" class="img-fluid mb-3">
      <a class="text-white cp"><i class="bi bi-x"></i> close</a>
    </div>

    <div class="row row-cols-2 row-cols-md-3 g-3 grid">
      <?php
      $i = 0;
      $num = range(1, 80);
      shuffle($num);
      $rows = array_slice($num, 0, 80);

      foreach ($rows as $row) : if ($i > 2) {
          $i = 0;
        }
        $img = "gallery/g" . sprintf('%05d', $row) . "s.jpg"; ?>
        <div class="col">
          <img src="<?= $img ?>" class="img-fluid photo">
        </div>
      <?php $i++;
      endforeach; ?>

    </div>

  </section>



  <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
  <script>
    let img = document.querySelectorAll(".photo");
    let showcase = document.querySelector("#showcase")
    for (let i = 0; i < img.length; i++) {
      img[i].addEventListener("click", function() {
        let src = img[i].getAttribute("src");
        src = src.replace('s.jpg', '.jpg');
        showcase.querySelector("img").src = src;
        showcase.classList.remove("d-none");
        showcase.classList.add("active");
      });
    }

    showcase.addEventListener("click", function() {
      showcase.classList.add("d-none");
      showcase.classList.remove("active");
    });

    window.addEventListener("DOMContentLoaded", function() {
      img[img.length - 1].addEventListener("load", function() {
        let msnry = new Masonry('.grid', {
          percentPosition: true
        });
      });
    });

    let msnry = new Masonry('.grid', {
      percentPosition: true
    });
  </script>
  <?php
  require("foot.php");
  ?>
