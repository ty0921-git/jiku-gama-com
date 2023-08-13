<?php
require("head.php");

// テーブル指定
$table = "contact";

// カテゴリーデータ取得
$categories = get_category($table);


// カテゴリー連想配列の作成
$category_array = array();
foreach ($categories as $category) {
  $category_array += array($category['code'] => $category['cate_name']);
}

// キーワード無害化
$keyword = h(filter_input(INPUT_GET, 'keyword'));
$get_start = h(filter_input(INPUT_GET, 'start'));


// データ件数取得
$sql = "select*from $table";
if ($keyword) {
  $sql = "select*from $table where con_name like '%$keyword%' or short_description like '%$keyword%'";
}
$stmt = connect()->query($sql);
$cnt = $stmt->rowCount();

// 表示データ設定
$disp_data = 50;

// ページ数
$page_num = ceil($cnt / $disp_data);

// 開始ページ
if ($get_start) {
  $start = $get_start * $disp_data;
} else {
  $start = 0;
}


// データ取得
$sql = "select*from $table order by code DESC limit $start,$disp_data";
if ($keyword) {
  $sql = "select*from $table where con_name like '%$keyword%' or short_description like '%$keyword%' order by code DESC limit $start,$disp_data";
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
      <h4>コンタクト一覧</h4>
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
        ?>
          <tr>
            <td>
              <div>
                <?php
                $cate_nums = get_chains($table, $code);
                foreach ($cate_nums as $cate_num) :
                ?>
                  <span class="badge bg-corange"><?= h($category_array[$cate_num]) ?></span>
                <?php endforeach; ?>
                <?php
                $tags = explode(",", $row['tag']);
                foreach ($tags as $tag) :
                ?>
                  <span class="badge bg-cblue"><?= h($tag) ?></span>
                <?php endforeach; ?>
              </div>
            </td>
            <td>
              <h5><a href="<?= $table ?>_form.php?code=<?= $code ?>"><?= h($row['con_name']) ?></a></h5>
              <div>
                <?php if ($row['con_pic']) : ?>
                  担当者 / <?= h($row['con_pic']) ?>
                <? endif; ?>
              </div>
            </td>
            <td>
              <div>
                <?php if ($row['con_zip']) : ?>
                  〒<?= h($row['con_zip']) ?>
                <? endif; ?>
              </div>
              <div>
                <?php if ($row['con_add01']) : ?>
                  <?= h($row['con_add01']) ?>
                <? endif; ?>
                <?php if ($row['con_add02']) : ?>
                  <?= h($row['con_add02']) ?>
                <? endif; ?>
                <?php if ($row['con_add03']) : ?>
                  <?= h($row['con_add03']) ?>
                <? endif; ?>
              </div>
            </td>
            <td>
              <?php if ($row['con_tel']) : ?>
                <div>TEL <?= h($row['con_tel']) ?></div>
              <? endif; ?>
              <?php if ($row['con_fax']) : ?>
                <div>FAX <?= h($row['con_fax']) ?></div>
              <? endif; ?>
            </td>
            <td>
              <?php if ($row['con_web']) : ?>
                <div><a href="<?= h($row['con_web']) ?>" target="_blank"><?= h($row['con_web']) ?></a></div>
              <? endif; ?>
              <?php if ($row['con_email']) : ?>
                <div><?= h($row['con_email']) ?></div>
              <? endif; ?>
            </td>
            <td>
              <a class="btn btn-btn" href="<?= $table ?>_form.php?code=<?= $code ?>">編集</a>
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
