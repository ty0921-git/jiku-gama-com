<?php
require("head.php");
?>
<title>AXIS</title>
</head>

<body class="d-flex">
  <?php
  require("nav.php");
  ?>

  <section class="p-5 w-100">
    <h1 class="fc-main mb-4">AXIS</h1>


    <?php
    $setup_file = "setup.php";
    if (file_exists($setup_file)) :
    ?>
      <div class="alert alert-danger mb-4">セットアップファイルが存在します。</div>
    <?php endif; ?>

    <?php
    if (!imageCheck("../image", "favicon", false)) :
    ?>
      <div class="alert alert-danger mb-4">ファビコンが設定されていません。</div>
    <?php endif; ?>

    <?php
    if (!imageCheck("../image", "no-image", false)) :
    ?>
      <div class="alert alert-danger mb-4">代替イメージが設定されていません。</div>
    <?php endif; ?>

    <?php
    if (!imageCheck("../image", "ogp-image", false)) :
    ?>
      <div class="alert alert-danger mb-4">OGPイメージが設定されていません。</div>
    <?php endif; ?>


    <h5>最新ポスト <small>Latest Posts</small></h5>
    <hr>
    <div class="row row-cols-4 g-3">
      <?php
      $rows = get_rows("post", null, "order by code DESC limit 4");
      foreach ($rows as $row) : $code = zerop($row['code'], 7);
      ?>
        <div class="col">
          <a href="post_form.php?code=<?= $code ?>" class="thumb01 mb-3" style="background-image:url(<?= imageCheck("../post","{$code}_md_01",true) ?>)"></a>
          <a href="post_form.php?code=<?= $code ?>"><?= $row['title'] ?></a>
        </div>
      <?php endforeach; ?>
    </div>


  </section>


  <?php
  require("foot.php");
  ?>