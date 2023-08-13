<?php
require("head.php");

// テーブル指定
$table = "item";

// カテゴリーデータ取得
$categories = get_category($table);

// カテゴリー連想配列の作成
$category_array = array();
foreach ($categories as $category) {
  $category_array += array($category['code'] => $category['cate_name']);
}

// コレクションデータ取得
$colles = get_category("colle");

// コレクション連想配列の作成
$colle_array = array();
foreach ($colles as $colle) {
  $colle_array += array($colle['code'] => $colle['cate_name']);
}

// 温度帯データ取得
$temps = get_category("temp");

// 温度帯連想配列の作成
$temp_array = array();
foreach ($temps as $temp) {
  $temp_array += array($temp['code'] => $temp['cate_name']);
}



// 配送区分データ取得
$sql = "select*from delivary order by code ASC";
$stmt = connect()->query($sql);
$delis = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 配送区分配列の作成
$delivary_array = array();
foreach ($delis as $deli) {
  $delivary_array += array($deli['code'] => $deli['delivary_name']);
}


// キーワード無害化
$keyword = h(filter_input(INPUT_GET, 'keyword'));
$get_start = h(filter_input(INPUT_GET, 'start'));


// データ件数取得
$sql = "select*from $table";
if ($keyword) {
  $sql = "select*from $table where item_name like '%$keword%' or description like '%$keword%' or short_description like '%$keword%'";
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


// アイテムデータ取得
$sql = "select*from $table order by code DESC limit $start,$disp_data";
if ($keyword) {
  $sql = "select*from $table where item_name like '%$keword%' or description like '%$keword%' or short_description like '%$keword%' order by code DESC limit $start,$disp_data";
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
      <h4>アイテム一覧</h4>
      <hr class="mb-4">

      <form action="" method="GET">
        <div class="row g-1 mb-5">
          <div class="col-md-6">
            <div class="input-group mb-3">
              <input type="text" name="keyword" class="form-control" placeholder="キーワード" value="<?= h($keyword) ?>">
              <button class="btn btn-btn" type="submit"><i class="bi bi-search"></i></button>
            </div>
          </div>
        </div>
      </form>

      <div class="row g-4 mb-5">
        <?php
        foreach ($rows as $row) :
          $code = zerop($row['code'], 7);
          $article = strip_tags($row['article']);
          $limit = 200;
          if (mb_strlen($article) > $limit) {
            $article = mb_substr($article, 0, $limit) . " ...";
          }

          $exts = array(".jpg", ".jpeg", ".png", ".gif", ".webp");
          foreach ($exts as $ext) {
            $img = "../$table/{$code}_md_01{$ext}";
            if (file_exists($img)) {
              $img_url = $img . "?c=" . date("Ymdhis");
              break;
            } else {
              $img_url = "";
            }
          }
        ?>

          <div class="col-md-4">
            <a href="<?= $table ?>_form.php?code=<?= $code ?>" class="thumb01 mb-3 border" style="background-image:url(<?= $img_url ?>)"></a>



            <div>
              <div class="mb-1">
                <span class="badge bg-dark"><?= $code ?></span>
                <?php if ($row['display'] == 1) : ?>
                  <span class="badge bg-cgreen">表示中</span>
                <?php else : ?>
                  <span class="badge bg-cred">非表示</span>
                <?php endif; ?>
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
              <div class="mb-1">
                <?php
                $colle_nums = get_chains($table, $code);
                foreach ($colle_nums as $colle_num) :
                ?>
                  <span class="badge bg-cred"><?= h($colle_array[$colle_num]) ?></span>
                <?php endforeach; ?>
              </div>
              <div class="mb-1">
                <?php
                $temp_nums = get_chains($table, $code);
                foreach ($temp_nums as $temp_num) :
                  $temp_name = get_call_code($temp_num);
                ?>
                  <span class="badge bg-<?= $temp_name ?>"><?= h($temp_array[$temp_num]) ?></span>
                <?php endforeach; ?>
              </div>
              <div class="mb-3">
                <?php
                $delivary = $row['delivary'];
                ?>
                <span class="badge bg-cred"><?= h($delivary_array[$delivary]) ?></span>
              </div>
            </div>



            <div>
              <h5><a href="<?= $table ?>_form.php?code=<?= $code ?>"><?= h($row['item_name']) ?></a></h5>
              <table class="table">
                <?php
                $price_data = explode("\n", $row['price']);
                for ($i = 0; $i < sizeof($price_data); $i++) :
                  list($price_lavel, $price) = explode("<>", $price_data[$i]);
                  if (empty($price)) continue;
                  if (empty($price_lavel)) $price_lavel = "価格";
                ?>
                  <tr>
                    <td><?= h($price_lavel) ?></td>
                    <td class="text-end"><?= h(d($price)) ?><small>円</small></td>
                  </tr>
                <?php endfor; ?>
              </table>
            </div>
            <div class="text-end">
              <a class="btn btn-btn" href="<?= $table ?>_form.php?code=<?= $code ?>">編集</a>
            </div>
          </div>

        <?php endforeach; ?>
      </div>


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
