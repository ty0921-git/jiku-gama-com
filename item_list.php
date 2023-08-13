<?php
require("head.php");

$table = "item";
$call_code = null;

// データ件数取得
$tails = "and date_regi<='$date_today'";
$cnt = get_rows_cnt($table,$call_code,$tails);

// 表示データ設定
$disp_data = 50;

// ページ数
$page_num = ceil($cnt / $disp_data);

// 開始ページ
if ($_GET['start']) {
  $start = $_GET['start'] * $disp_data;
} else {
  $start = 0;
}

// カテゴリーリスト生成
$cate_list=getCategoryList($table);
?>
<title>商品一覧 | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
  <?php
  require("nav.php");
  ?>

  <section class="p-2 p-md-4"></section>


  <section class="container mb-4 mb-md-5">
    <h2 class="heading"><span>Item</span> <small>商品</small></h2>
  </section>


  <section class="container mb-5">
    <div class="row row-cols-2 row-cols-md-4 gx-1 gy-3 g-md-3">
      <?php
      $tails = "and date_regi<='$date_today' order by code DESC limit $start,$disp_data";
      $rows = get_rows($table,$call_code,$tails);
      foreach ($rows as $row) : $code = zerop($row['code'], 7);

        $price_data = explode("\n", $row['price']);
        list(, $price) = explode("<>", $price_data[0]);
        if (empty($price)) {
          continue;
        }
      ?>
        <?php require("item01.php"); ?>
      <?php endforeach; ?>
    </div>
  </section>


  <section class="d-flex justify-content-center mb-5">
    <nav>
      <ul class="pagination">

        <?php for ($i = 0; $i < $page_num; $i++) : ?>
          <li class="page-item"><a class="page-link" href="?start=<?= $i ?>"><?= $i + 1 ?></a></li>
        <?php endfor; ?>

      </ul>
    </nav>
  </section>




  <?php
  require("foot.php");
  ?>
