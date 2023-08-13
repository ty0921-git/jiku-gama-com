<?php
require("head.php");

// テーブル指定
$table = "archive";

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



        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="base-tab" data-bs-toggle="tab" href="#base" role="tab" aria-controls="base" aria-selected="true">基本情報</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="image-tab" data-bs-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false">アーカイブ画像</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">詳細情報</a>
          </li>
        </ul>



        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="base" role="tabpanel" aria-labelledby="base-tab">
            <div class="row">
              <div class="col-md-9">

                <div class="mb-4">
                  <?php if ($categories) : ?>
                    <?php foreach ($categories as $category) : $category_code = $category['code']; ?>
                      <div class="form-check form-check-inline form-switch">
                        <input class="form-check-input" type="checkbox" id="cate_code" name="cate_code[]" value="<?= h($category_code) ?>" <?php if ($code && in_array($category_code, $chains)) print "checked"; ?>>
                        <label class="form-check-label" for="cate_code"> <?= h($category['cate_name']) ?></label>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>


                <div class="row mb-4">
                  <div class="col-md-6">
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
                    <a class="thumb01" <?php if ($img_url) : ?> style="background-image:url(<?= $img_url ?>);" <?php endif; ?>></a>
                  </div>
                  <div class="col-md-6">

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="archive_title" id="archive_title" placeholder="#" value="<?= h($row['archive_title']) ?>">
                      <label for="archive_title">アーカイブタイトル</label>
                    </div>

                    <div class="form-floating mb-3">
                      <textarea class="form-control" name="short_description" id="short_description" placeholder="#" style="height:180px;"><?= h($row['short_description']) ?></textarea>
                      <label for="short_description">簡易説明</label>
                    </div>
                  </div>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="description" id="article" placeholder="#" style="height:500px;"><?= h($row['description']) ?></textarea>
                  <label for="description">商品説明</label>
                </div>


              </div>


              <div class="col-md-3">

                <div class="form-floating mb-3">
                  <input class="form-control" type="text" name="tag" id="tag" placeholder="#" style="height:100px;" value="<?= h($row['tag']) ?>">
                  <label for="tag" class="label-adj01">タグ</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="archive_area" id="archive_area" placeholder="#" value="<?= h($row['archive_area']) ?>">
                  <label for="archive_area">エリア</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="archive_catch" id="archive_catch" placeholder="#" style="height:100px;"><?= h($row['archive_catch']) ?></textarea>
                  <label for="archive_catch">キャッチコピー</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="memo" id="memo" placeholder="#" style="height:100px;"><?= h($row['memo']) ?></textarea>
                  <label for="memo">メモ</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control datepicker" name="date_regi" id="date_regi" placeholder="#" value="<?= h($row['date_regi']) ?>">
                  <label for="date_regi">日付</label>
                </div>

                <div class="form-floating mb-3">
                  <select class="form-select" id="display" name="display">
                    <option selected value="1" <?php if ($row['display'] == "1") {
                                                  print "selected";
                                                } ?>>表示</option>
                    <option value="0" <?php if ($row['display'] == "0") {
                                        print "selected";
                                      } ?>>非表示</option>
                  </select>
                  <label for="display">表示設定</label>
                </div>



              </div>


            </div>
          </div>
          <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="profile-tab">

            <div class="row">
              <?php
              for ($i = 1; $i <= 20; $i++) :
                $num = zerop($i, 2);
              ?>
                <div class="col-md-3 mb-3">
                  <div class="mb-3 imgInput">
                    <label for="file<?= $num ?>" class="form-label"><?= $num ?></label>
                    <input class="form-control mb-2" type="file" name="file<?= $num ?>" id="file<?= $num ?>">
                    <div class="position-relative">
                      <?php
                      $exts = array(".jpg", ".jpeg", ".png", ".gif", ".webp");
                      foreach ($exts as $ext) {
                        $img = "../$table/{$code}_md_{$num}{$ext}";
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
                          <a class="btn btn-cred" onclick="del('<?= $num ?>')">削除</a>
                        </div>
                        <div id="del<?= $num ?>" class="d-none mt-1">
                          <a class="btn btn-cred" href="delete_img.php?code=<?= $code ?>&table=<?= $table ?>&num=<?= $num ?>">削除実行</a>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endfor; ?>
            </div>

          </div>
          <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="contact-tab">

            <div class="row">
              <div class="col-md-6">

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="ex_link" id="ex_link" placeholder="#" value="<?= h($row['ex_link']) ?>">
                  <label for="ex_link">外部リンク</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="line01" id="line01" placeholder="#" value="<?= h($row['line01']) ?>">
                  <label for="line01">line01</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="line02" id="line02" placeholder="#" value="<?= h($row['line02']) ?>">
                  <label for="line02">line02</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="line03" id="line03" placeholder="#" value="<?= h($row['line03']) ?>">
                  <label for="line03">line03</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="box01" id="box01" placeholder="#" style="height:100px;"><?= h($row['box01']) ?></textarea>
                  <label for="box01">box01</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="box02" id="box02" placeholder="#" style="height:100px;"><?= h($row['box02']) ?></textarea>
                  <label for="box02">box02</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="box03" id="box03" placeholder="#" style="height:100px;"><?= h($row['box03']) ?></textarea>
                  <label for="box03">box03</label>
                </div>

              </div>
              <div class="col-md-6">

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
          <div>
            <a href="<?= $table ?>_list.php" class="btn btn-btn">アーカイブ一覧</a>
            <a href="copy.php?table=<?= $table ?>&code=<?= $code ?>" class="btn btn-btn">コピー</a>
          </div>
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
                <div class="alert alert-danger">削除対象 : <?= h($row['archive_title']) ?></div>
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
  require("js_panelselector.php");
  ?>
