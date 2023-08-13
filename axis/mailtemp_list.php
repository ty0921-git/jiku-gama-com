<?php
require("head.php");

// テーブル指定
$table = "mailtemp";


// キーワード無害化
$keyword = h(filter_input(INPUT_GET, 'keyword'));
$get_start = h(filter_input(INPUT_GET, 'start'));


// データ件数取得
$sql = "select*from $table";
if ($keyword) {
  $sql = "select*from $table where mail_title like '%$keyword%' or short_description like '%$keyword%'";
}
$stmt = connect()->query($sql);
$cnt = $stmt->rowCount();

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


// データ取得
$sql = "select*from $table order by code DESC limit $start,$disp_data";
if ($keyword) {
  $sql = "select*from $table where mail_title like '%$keyword%' or short_description like '%$keyword%' order by code DESC limit $start,$disp_data";
}
$stmt = connect()->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<title>AXIS</title>
</head>

<body class="d-flex">
  <?php
  require("nav.php");
  ?>

  <div class="w-100">
    <section class="container-fluid p-5">
      <h4>テンプレート一覧</h4>
      <hr class="mb-4">

      <form action="" method="GET">
        <div class="row g-1 mb-5">
          <div class="col-md-6">
            <div class="input-group mb-3">
              <input type="text" name="keyword" class="form-control" placeholder="キーワード" value="<?= $keyword ?>">
              <button class="btn btn-btn" type="submit"><i class="bi bi-search"></i></button>
            </div>
          </div>
        </div>
      </form>

      <table class="table">
        <?php
        foreach ($rows as $row) :
          $code = zerop($row['code'], 7);
          $row['mail_title'] = htmlspecialchars($row['mail_title']);
          $row['mail_body'] = htmlspecialchars($row['mail_body']);
        ?>
          <tr>
            <td>
              <h5><a href="<?= $table ?>_form.php?code=<?= $code ?>" style="white-space:nowrap;"><?= h($row['mailtemp_name']) ?></a></h5>
            </td>
            <td>
              <?php if ($row['support'] == "on") : ?>
                <span class="badge bg-cgreen">一斉送信</span>
              <?php endif; ?>
            </td>
            <td>
              <?= h($row['call_code']) ?>
            </td>
            <td>
              <?= h($row['mail_title']) ?>
            </td>
            <td>
              <a class="btn btn-btn" style="white-space:nowrap;" href="<?= $table ?>_form.php?code=<?= $code ?>">編集</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>

    </section>



    <section class="d-flex justify-content-center">
      <nav>
        <ul class="pagination">

          <?php for ($i = 0; $i < $page_num; $i++) : ?>
            <li class="page-item"><a class="page-link" href="?start=<?= $i ?>&keyword=<?= $keyword ?>"><?= $i + 1 ?></a></li>
          <?php endfor; ?>

        </ul>
      </nav>
    </section>



  </div>

  <?php
  require("foot.php");
  ?>
