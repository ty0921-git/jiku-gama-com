<?php
require("head.php");

$table = "post";
$call_code="news";

// データ件数取得
$tails="and date_regi<='$date_today' order by date_regi DESC";
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
?>
<title>新着情報一覧 | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
  <?php
  require("nav.php");
  ?>

  <section class="p-2 p-md-4"></section>


  <section class="container mb-5">
    <h2 class="heading"><span>News</span> <small>新着情報</small></h2>
    <?php
    $tails="and date_regi<='$date_today' order by date_regi DESC limit $start,$disp_data";
    $rows = get_rows($table,$call_code,$tails);
    $i = 0;
    foreach ($rows as $row) :
    ?>
      <?php require("news01.php"); ?>
    <?php endforeach; ?>
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
