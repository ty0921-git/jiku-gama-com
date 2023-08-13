<?php
require("head.php");

// テーブル指定
$table = "post";

// ゲット変数の無害化処理
$get_code = h(filter_input(INPUT_GET, 'code'));

// カテゴリーデータ取得
$categories = get_category($table);

// コード指定データ取得
if ($get_code) {
  $row = get_row($table, $get_code);
  $code = zerop($row['code'], 7);
  $chains = get_chains($table, $get_code);
} else {
  $row['date_regi'] = date("Y-m-d");
}
?>
<script src="https://cdn.tiny.cloud/1/<?= get_tiny_key() ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<title>AXIS</title>
</head>

<body class="d-flex">
  <?php
  require("nav.php");
  ?>

  <div class="w-100 p-5">
    <section class="container-fluid">

      <form action="db_op.php" method="POST" enctype="multipart/form-data">

        <div class="row">
          <div class="col-md-9">

            <div class="mb-4">
              <?php if ($categories) : ?>
                <?php foreach ($categories as $category) : $category_code = h($category['code']); ?>
                  <div class="form-check form-check-inline form-switch">
                    <input class="form-check-input" type="checkbox" id="cate_code" name="cate_code[]" value="<?= h($category_code) ?>" <?php if ($code && in_array($category_code, $chains)) print "checked"; ?>>
                    <label class="form-check-label" for="cate_code"> <?= h($category['cate_name']) ?></label>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="title" id="title" placeholder="#" value="<?= h($row['title']) ?>">
              <label for="title">タイトル</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="link" id="link" placeholder="#" value="<?= h($row['link']) ?>">
              <label for="link">外部リンク</label>
            </div>

            <div class="form-floating mb-3">
              <textarea class="form-control" name="article" id="article" placeholder="#" style="height:500px;"><?= h($row['article']) ?></textarea>
              <label for="article">記事</label>
            </div>


          </div>


          <div class="col-md-3">

            <div class="form-floating mb-3">
              <input class="form-control" type="text" name="tag" id="tag" placeholder="#" style="height:100px;" value="<?= h($row['tag']) ?>">
              <label for="tag" class="label-adj01">タグ</label>
            </div>

            <div class="form-floating mb-3">
              <textarea class="form-control" name="memo" id="memo" placeholder="#" style="height:100px;"><?= h($row['memo']) ?></textarea>
              <label for="memo">メモ</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control datepicker" name="date_regi" id="date_regi" placeholder="#" value="<?= h($row['date_regi']) ?>">
              <label for="date_regi">公開日</label>
            </div>

            <div class="form-floating mb-3">
              <select class="form-select" id="display" name="display">
                <option selected value="1" <?php if (h($row['display']) == "1") {
                                              print "selected";
                                            } ?>>表示</option>
                <option value="0" <?php if (h($row['display']) == "0") {
                                    print "selected";
                                  } ?>>非表示</option>
              </select>
              <label for="display">表示設定</label>
            </div>


            <div class="mb-3 imgInput">
              <label for="file01" class="form-label">アイキャッチ画像</label>
              <input class="form-control mb-2" type="file" name="file01" id="file01">
              <div class="position-relative">
                <?php
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
                <img class="imgView img-fluid" src="<?= $img_url ?>">
                <?php if ($img_url) : ?>
                  <div class="text-end position-absolute" style="top:5px;right:-5px;">
                    <a class="btn btn-cred" onclick="del('01')">削除</a>
                  </div>
                  <div id="del01" class="d-none mt-1">
                    <a class="btn btn-cred" href="delete_img.php?code=<?= $code ?>&table=<?= $table ?>&num=01">削除実行</a>
                  </div>
                <?php endif; ?>
              </div>
            </div>



          </div>


        </div>


        <input type="hidden" name="table" value="<?= $table ?>">
        <?php if ($code) : ?>
          <input type="hidden" name="code" value="<?= $code ?>">
        <?php else : ?>
          <input type="hidden" name="next_location" value="<?= $table ?>_list.php">
        <?php endif; ?>
        <input type="submit" class="btn btn-btn px-5" value="登録">
        <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
      </form>

    </section>

    <?php if ($code) : ?>
      <section class="container-fluid mt-5">
        <hr>
        <!-- Button trigger modal -->
        <div class="d-flex justify-content-between">
          <a href="<?= $table ?>_list.php" class="btn btn-btn">ポスト一覧</a>
          <button type="button" class="btn btn-cred" data-bs-toggle="modal" data-bs-target="#modal">
            データ削除
          </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">削除しますか？</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>データを削除すると元に戻すことはできません。</p>
                <div class="alert alert-danger">削除対象 : <?= h($row['title']) ?></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a class="btn btn-cred" href="delete.php?table=<?= $table ?>&code=<?= $row['code'] ?>">削除</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>



  </div>

  <?php
  require("foot.php");
  require("js_datepicker.php");
  require("js_tinymce.php");
  require("js_thumb.php");
  require("js_tagit.php");
  ?>
