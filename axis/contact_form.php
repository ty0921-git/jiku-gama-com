<?php
require("head.php");

// テーブル指定
$table = "contact";

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


                <div class="row mb-4">
                  <div class="col-md-6">

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="con_name" id="con_name" placeholder="#" value="<?= h($row['con_name']) ?>">
                      <label for="con_name">コンタクト名</label>
                    </div>

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="con_pic" id="con_pic" placeholder="#" value="<?= h($row['con_pic']) ?>">
                      <label for="con_pic">担当者</label>
                    </div>

                    <div class="row">
                      <div class="col-md-6">

                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="con_zip" id="con_zip" placeholder="#" value="<?= h($row['con_zip']) ?>" pattern="\d{3}-?\d{4}" onKeyUp="AjaxZip3.zip2addr(this,'','con_add01','con_add02');">
                          <label for="con_zip">〒</label>
                        </div>

                      </div>
                      <div class="col-md-6">

                        <div class="form-floating mb-3">
                          <select class="form-select" id="con_add" name="con_add01">
                            <option value="">選択してください</option>
                            <?php
                            $sql = "select area_name from area_data";
                            $stmt = connect()->query($sql);
                            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($areas as $area) :
                              if ($area['area_name'] == $row['con_add01']) {
                                $sel = "selected";
                              } else {
                                $sel = "";
                              }
                            ?>
                              <option value="<?= h($area['area_name']) ?>" <?= $sel ?>><?= h($area['area_name']) ?></option>
                            <?php endforeach; ?>
                          </select>
                          <label for="con_add01">都道府県</label>
                        </div>

                      </div>
                    </div>

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="con_add02" id="con_add" placeholder="#" value="<?= h($row['con_add02']) ?>">
                      <label for="con_add02">市区町村</label>
                    </div>

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="con_add03" id="con_add" placeholder="#" value="<?= h($row['con_add03']) ?>">
                      <label for="con_add03">番地 / 号室</label>
                    </div>

                    <div class="row">
                      <div class="col-md-6">

                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="con_tel" id="con_tel" placeholder="#" value="<?= h($row['con_tel']) ?>">
                          <label for="con_tel">TEL</label>
                        </div>

                      </div>
                      <div class="col-md-6">

                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="con_fax" id="con_fax" placeholder="#" value="<?= h($row['con_fax']) ?>">
                          <label for="con_fax">FAX</label>
                        </div>

                      </div>
                    </div>


                  </div>
                  <div class="col-md-6">

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="con_email" id="con_email" placeholder="#" value="<?= h($row['con_email']) ?>">
                      <label for="con_email">メールアドレス</label>
                    </div>

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="con_web" id="con_web" placeholder="#" value="<?= h($row['con_web']) ?>">
                      <label for="con_web">ウェブサイト</label>
                    </div>

                    <div class="form-floating mb-3">
                      <textarea class="form-control" name="short_description" id="short_description" placeholder="#" style="height:180px;"><?= h($row['short_description']) ?></textarea>
                      <label for="short_description">簡易説明</label>
                    </div>

                  </div>
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
                  <label for="date_regi">登録日</label>
                </div>



              </div>


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
          <a href="<?= $table ?>_list.php" class="btn btn-btn">コンタクト一覧</a>
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
                <div class="alert alert-danger">削除対象 : <?= h($row['con_name']) ?></div>
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
  require("js_tagit.php");
  ?>
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>


  <script>
    let con_add = document.querySelectorAll("#con_add");

    for (let i = 0; i < con_add.length; i++) {
      con_add[i].addEventListener("change", function() {
        get_zipcode();
      });
    }

    function get_zipcode() {
      let con_add = document.querySelectorAll("#con_add");
      let address = con_add[0].value + con_add[1].value + con_add[2].value;
      $.ajax({
          url: 'https://zipcoda.net/api',
          dataType: 'jsonp',
          data: {
            address: address,
          }
        })
        .then(function(r) {
          document.querySelector("#con_zip").value = r.items[0].zipcode;
        });
    }
  </script>
