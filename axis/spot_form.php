<?php
require("head.php");

// テーブル指定
$table = "spot";

// ゲット変数の無害化処理
$get_code = h(filter_input(INPUT_GET, 'code'));

// カテゴリーデータ取得
$categories = get_category($table);

// 設備データ取得
$facilities = get_category("facility");

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
            <a class="nav-link" id="image-tab" data-bs-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false">スポット画像</a>
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
                        <input class="form-check-input" type="checkbox" id="cate_code" name="cate_code[]" value="<?= $category_code ?>" <?php if ($code && in_array($category_code, $chains)) print "checked"; ?>>
                        <label class="form-check-label" for="cate_code"> <?= h($category['cate_name']) ?></label>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>


                <div class="mb-4">
                  <?php if ($facilities) : ?>
                    <?php foreach ($facilities as $faci) : $facility_code = $faci['code']; ?>
                      <div class="form-check form-check-inline form-switch">
                        <input class="form-check-input" type="checkbox" id="facility_code" name="facility_code[]" value="<?= $facility_code ?>" <?php if ($code && in_array($facility_code, $chains)) print "checked"; ?>>
                        <label class="form-check-label" for="facility_code"> <?= h($faci['cate_name']) ?></label>
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
                      <input type="text" class="form-control" name="spot_name" id="spot_name" placeholder="#" value="<?= h($row['spot_name']) ?>">
                      <label for="spot_name">スポット名</label>
                    </div>

                    <div class="row">
                      <div class="col-md-6">

                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="spot_zip" id="spot_zip" placeholder="#" value="<?= h($row['spot_zip']) ?>" pattern="\d{3}-?\d{4}" onKeyUp="AjaxZip3.zip2addr(this,'','spot_add01','spot_add02');">
                          <label for="spot_zip">〒</label>
                        </div>

                      </div>
                      <div class="col-md-6">

                        <div class="form-floating mb-3">
                          <select class="form-select" id="spot_add" name="spot_add01">
                            <option value="">選択してください</option>
                            <?php
                            $sql = "select area_name from area_data";
                            $stmt = connect()->query($sql);
                            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($areas as $area) :
                              if ($area['area_name'] == $row['spot_add01']) {
                                $sel = "selected";
                              } else {
                                $sel = "";
                              }
                            ?>
                              <option value="<?= h($area['area_name']) ?>" <?= $sel ?>><?= h($area['area_name']) ?></option>
                            <?php endforeach; ?>
                          </select>
                          <label for="spot_add01">都道府県</label>
                        </div>

                      </div>
                    </div>

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="spot_add02" id="spot_add" placeholder="#" value="<?= h($row['spot_add02']) ?>">
                      <label for="spot_add02">市区町村</label>
                    </div>

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="spot_add03" id="spot_add" placeholder="#" value="<?= h($row['spot_add03']) ?>">
                      <label for="spot_add03">番地 / 号室</label>
                    </div>


                    <div class="row">
                      <div class="col-md-6">

                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="spot_tel" id="spot_tel" placeholder="#" value="<?= h($row['spot_tel']) ?>">
                          <label for="spot_tel">TEL</label>
                        </div>

                      </div>
                      <div class="col-md-6">

                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="spot_fax" id="spot_fax" placeholder="#" value="<?= h($row['spot_fax']) ?>">
                          <label for="spot_fax">FAX</label>
                        </div>

                      </div>
                    </div>


                  </div>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="short_description" id="short_description" placeholder="#" style="height:100px;"><?= h($row['short_description']) ?></textarea>
                  <label for="short_description">簡易説明</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="description" id="article" placeholder="#" style="height:500px;"><?= h($row['description']) ?></textarea>
                  <label for="description">スポット説明</label>
                </div>


              </div>


              <div class="col-md-3">

                <div class="form-floating mb-3">
                  <input class="form-control" type="text" name="tag" id="tag" placeholder="#" style="height:100px;" value="<?= h($row['tag']) ?>">
                  <label for="tag" class="label-adj01">タグ</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="spot_catch" id="spot_catch" placeholder="#" style="height:100px;"><?= h($row['spot_catch']) ?></textarea>
                  <label for="spot_catch">キャッチコピー</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="spot_budget" id="spot_budget" placeholder="#" style="height:100px;"><?= h($row['spot_budget']) ?></textarea>
                  <label for="spot_budget">料金・予算</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="spot_capa" id="spot_capa" placeholder="#" style="height:100px;"><?= h($row['spot_capa']) ?></textarea>
                  <label for="spot_capa">収容・席数</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="spot_time" id="spot_time" placeholder="#" style="height:100px;"><?= h($row['spot_time']) ?></textarea>
                  <label for="spot_time">営業時間</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="spot_holiday" id="spot_holiday" placeholder="#" style="height:100px;"><?= h($row['spot_holiday']) ?></textarea>
                  <label for="spot_holiday">定休日</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" name="memo" id="memo" placeholder="#" style="height:100px;"><?= h($row['memo']) ?></textarea>
                  <label for="memo">メモ</label>
                </div>


                <div class="row g-2">
                  <div class="col">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="spot_lat" id="spot_lat" placeholder="#" value="<?= h($row['spot_lat']) ?>">
                      <label for="spot_lat">緯度</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="spot_lon" id="spot_lon" placeholder="#" value="<?= h($row['spot_lon']) ?>">
                      <label for="spot_lon">経度</label>
                    </div>
                  </div>
                </div>


                <div class="form-floating mb-3">
                  <input type="text" class="form-control datepicker" name="date_regi" id="date_regi" placeholder="#" value="<?= h($row['date_regi']) ?>">
                  <label for="date_regi">公開日</label>
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
                  <input type="text" class="form-control" name="spot_web" id="spot_web" placeholder="#" value="<?= h($row['spot_web']) ?>">
                  <label for="spot_web">ウェブサイト</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="spot_facebook" id="spot_facebook" placeholder="#" value="<?= h($row['spot_facebook']) ?>">
                  <label for="spot_facebook">Facebook</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="spot_twitter" id="spot_twitter" placeholder="#" value="<?= h($row['spot_twitter']) ?>">
                  <label for="spot_twitter">Twitter</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="spot_instagram" id="spot_instagram" placeholder="#" value="<?= h($row['spot_instagram']) ?>">
                  <label for="spot_instagram">Instagram</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="spot_line" id="spot_line" placeholder="#" value="<?= h($row['spot_line']) ?>">
                  <label for="spot_line">LINE</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="spot_youtube" id="spot_youtube" placeholder="#" value="<?= h($row['spot_youtube']) ?>">
                  <label for="spot_youtube">YouTube</label>
                </div>

              </div>
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
            <a href="<?= $table ?>_list.php" class="btn btn-btn">スポット一覧</a>
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
                <div class="alert alert-danger">削除対象 : <?= h($row['spot_name']) ?></div>
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

  <?php
  $sql = "select*from setting limit 1";
  $stmt = connect()->query($sql);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $map_api_key = $row['map_api_key'];
  ?>
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>


  <script src="https://maps.google.com/maps/api/js?key=<?= $map_api_key ?>"></script>
  <script>
    let spot_add = document.querySelectorAll("#spot_add");

    for (let i = 0; i < spot_add.length; i++) {
      spot_add[i].addEventListener("change", function() {
        get_geo();
        get_zipcode();
      });
    }

    function get_geo() {
      let geocoder = new google.maps.Geocoder();
      let address = spot_add[0].value + spot_add[1].value + spot_add[2].value;
      geocoder.geocode({
        'address': address
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var lat = results[0].geometry.location.lat();
          var lng = results[0].geometry.location.lng();
          // 小数点第六位以下を四捨五入した値を緯度経度にセット、小数点以下の値が第六位に満たない場合は0埋め
          document.getElementById("spot_lat").value = (Math.round(lat * 1000000) / 1000000).toFixed(6);
          document.getElementById("spot_lon").value = (Math.round(lng * 1000000) / 1000000).toFixed(6);
        }
      });
    }

    function get_zipcode() {
      let spot_add = document.querySelectorAll("#spot_add");
      let address = spot_add[0].value + spot_add[1].value + spot_add[2].value;
      $.ajax({
          url: 'https://zipcoda.net/api',
          dataType: 'jsonp',
          data: {
            address: address,
          }
        })
        .then(function(r) {
          document.querySelector("#spot_zip").value = r.items[0].zipcode;
        });
    }
  </script>
