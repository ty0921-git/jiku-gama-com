<?php
require("head.php");

$sql = "select*from setting limit 1";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<title>AXIS</title>
</head>

<body class="d-flex">
  <?php
  require("nav.php");
  ?>

  <section class="container-fluid p-5">
    <?php
    foreach ($row as $key => $val) {
      $$key = h($val);
    }
    ?>
    <h4>基本設定</h4>
    <hr class="mb-5">

    <form action="db_op.php" method="POST">

      <div class="row">

        <div class="col-md-6">
          <h6>運営団体情報</h6>
          <hr>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="site_url" id="site_url" placeholder="#" value="<?= $site_url ?>">
            <label for="site_url">URL</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="site_catch" id="site_catch" placeholder="#" value="<?= $site_catch ?>">
            <label for="site_catch">サイトキャッチコピー</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="site_name" id="site_name" placeholder="#" value="<?= $site_name ?>">
            <label for="site_name">サイト名</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_copyright_name" id="com_copyright_name" placeholder="#" value="<?= $com_copyright_name ?>">
            <label for="com_copyright_name">コピーライト表示</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_name" id="com_name" placeholder="#" value="<?= $com_name ?>">
            <label for="com_name">会社名</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_boss" id="com_boss" placeholder="#" value="<?= $com_boss ?>">
            <label for="com_boss">代表者</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_zip" id="com_zip" placeholder="#" value="<?= $com_zip ?>">
            <label for="com_zip">郵便番号</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_add" id="com_add" placeholder="#" value="<?= $com_add ?>">
            <label for="com_add">所在地</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_tel" id="com_tel" placeholder="#" value="<?= $com_tel ?>">
            <label for="com_tel">TEL</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_fax" id="com_fax" placeholder="#" value="<?= $com_fax ?>">
            <label for="com_fax">FAX</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_free_dial" id="com_free_dial" placeholder="#" value="<?= $com_free_dial ?>">
            <label for="com_free_dial">フリーダイアル</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_hour" id="com_hour" placeholder="#" value="<?= $com_hour ?>">
            <label for="com_hour">営業時間</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_holiday" id="com_holiday" placeholder="#" value="<?= $com_holiday ?>">
            <label for="com_holiday">定休日</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_email" id="com_email" placeholder="#" value="<?= $com_email ?>">
            <label for="com_email">メール</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_est" id="com_est" placeholder="#" value="<?= $com_est ?>">
            <label for="com_est">設立日</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_cap" id="com_cap" placeholder="#" value="<?= $com_cap ?>">
            <label for="com_cap">資本金</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="com_emp" id="com_emp" placeholder="#" value="<?= $com_emp ?>">
            <label for="com_emp">従業員数</label>
          </div>

          <div class="form-floating mb-3">
            <textarea class="form-control" name="main_bank" id="main_bank" placeholder="#" style="height:100px;"><?= $main_bank ?></textarea>
            <label for="main_bank">取引銀行</label>
          </div>

          <div class="form-floating mb-3">
            <textarea class="form-control" name="com_license" id="com_license" placeholder="#" style="height:100px;"><?= $com_license ?></textarea>
            <label for="com_license">免許・許可</label>
          </div>

          <div class="form-floating mb-3">
            <textarea class="form-control" name="com_affiliation" id="com_affiliation" placeholder="#" style="height:100px;"><?= $com_affiliation ?></textarea>
            <label for="com_affiliation">所属団体</label>
          </div>


        </div>

        <div class="col-md-6">
          <h6>マップ情報</h6>
          <hr>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_api_key" id="map_api_key" placeholder="#" value="<?= $map_api_key ?>">
            <label for="map_api_key">Google Map API Key</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_title" id="map_title" placeholder="#" value="<?= $map_title ?>">
            <label for="map_title">マップタイトル</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_lat" id="map_lat" placeholder="#" value="<?= $map_lat ?>">
            <label for="map_lat">緯度</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_lon" id="map_lon" placeholder="#" value="<?= $map_lon ?>">
            <label for="map_lon">経度</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_zoom" id="map_zoom" placeholder="#" value="<?= $map_zoom ?>">
            <label for="map_zoom">ズーム</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_isw" id="map_isw" placeholder="#" value="<?= $map_isw ?>">
            <label for="map_isw">アイコン幅</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_ish" id="map_ish" placeholder="#" value="<?= $map_ish ?>">
            <label for="map_ish">アイコン高</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_gam" id="map_gam" placeholder="#" value="<?= $map_gam ?>">
            <label for="map_gam">ガンマ</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_sat" id="map_sat" placeholder="#" value="<?= $map_sat ?>">
            <label for="map_sat">彩度</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="map_hue" id="map_hue" placeholder="#" value="<?= $map_hue ?>">
            <label for="map_hue">色合い</label>
          </div>

          <h6 class="mt-5">SNS情報</h6>
          <hr>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="facebook" id="facebook" placeholder="#" value="<?= $facebook ?>">
            <label for="facebook">facebook</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="instagram" id="instagram" placeholder="#" value="<?= $instagram ?>">
            <label for="instagram">Instagram</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="twitter" id="twitter" placeholder="#" value="<?= $twitter ?>">
            <label for="twitter">Twitter</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="youtube" id="youtube" placeholder="#" value="<?= $youtube ?>">
            <label for="youtube">Youtube</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="line" id="line" placeholder="#" value="<?= $line ?>">
            <label for="line">LINE</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="tiktok" id="tiktok" placeholder="#" value="<?= $tiktok ?>">
            <label for="tiktok">TikTok</label>
          </div>

        </div>

      </div>



      <input type="hidden" name="code" value="<?= $code ?>">
      <input type="hidden" name="table" value="setting">
      <input type="submit" class="btn btn-btn px-5" value="設定">
      <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
    </form>


  </section>



  <?php
  require("foot.php");
  ?>
  <script src="https://maps.google.com/maps/api/js?key=<?= $map_api_key ?>"></script>
  <script>
    var add_input = document.querySelector("#com_add");

    add_input.addEventListener("change", function() {
      get_geo();
    });

    function get_geo() {
      var geocoder = new google.maps.Geocoder();
      var address = document.getElementById("com_add").value;
      geocoder.geocode({
        'address': address
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var lat = results[0].geometry.location.lat();
          var lng = results[0].geometry.location.lng();
          // 小数点第六位以下を四捨五入した値を緯度経度にセット、小数点以下の値が第六位に満たない場合は0埋め
          document.getElementById("map_lat").value = (Math.round(lat * 1000000) / 1000000).toFixed(6);
          document.getElementById("map_lon").value = (Math.round(lng * 1000000) / 1000000).toFixed(6);
        }
      });
    }
  </script>