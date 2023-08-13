<?php
require("head.php");

if ($_GET['code']) {
  $code = $_GET['code'];
} else {
  header("location:./");
  exit;
}

$sql = "select*from post where code='$code'";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row['display'] == "0") {
  header("location:./");
  exit;
}

$row['code'] = zerop($row['code'], 7);
list($date_update) = explode(" ", $row['date_update']);
?>
<link rel="stylesheet" href="css/article.css">
<title><?= h($row['title']) ?> | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
  <?php
  require("nav.php");
  ?>
  <section class="p-2 p-md-4"></section>

  <section class="container mb-4">
    <a href="./">Home</a> <i class='bx bx-chevron-right'></i> <a href="blog_list.html">ブログ一覧</a>
  </section>

  <div class="container mb-5">
    <div class="row">
      <div class="col-md-9">

        <section class="news-detail">
          <h2><?= h($row['title']) ?></h2>
          <div class="mb-5">
            <span class="badge bg-sc">更新日</span> <time class="me-3" datetime="<?= h($row['date_update']) ?>" itemprop="modified"><?= h($date_update) ?></time>
            <span class="badge bg-sc">公開日</span> <time datetime="<?= h($row['date_regi']) ?>" itemprop="datepublished"><?= h($row['date_regi']) ?></time>
          </div>
        </section>


        <?php if ($img = imageCheck("post", "{$code}_lg_01", false)) : ?>
          <section>
            <img src="<?= $img ?>" class="img-fluid mb-3">
          </section>
        <?php endif; ?>

        <section>
          <div id="article"><?= $row['article'] ?></div>
        </section>

        <section class="mb-5">
          <?php require("sns_button.php"); ?>
        </section>

      </div>
      <div class="col-md-3">

        <section>
          <?php require("blog01_side.php"); ?>
        </section>

      </div>
    </div>
  </div>



  <?php
  require("foot.php");
  ?>
