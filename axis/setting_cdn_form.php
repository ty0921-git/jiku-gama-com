<?php
require("head.php");

$sql = "select*from setting_cdn limit 1";
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
    if (!empty($row)) {
      foreach ($row as $key => $val) {
        $$key = h($val);
      }
    }
    ?>
    <h4>CDN設定</h4>
    <hr class="mb-5">

    <form action="db_op.php" method="POST">

      <div class="row">

        <div class="col-md-12">

          <div class="form-floating mb-3">
            <textarea class="form-control" name="cdn_header" id="cdn_header" placeholder="#" style="height:300px;"><?= $cdn_header ?></textarea>
            <label for="cdn_header">CDN header</label>
          </div>

          <div class="form-floating mb-3">
            <textarea class="form-control" name="cdn_footer" id="cdn_footer" placeholder="#" style="height:300px;"><?= $cdn_footer ?></textarea>
            <label for="cdn_footer">CDN footer</label>
          </div>

        </div>

      </div>


      <?php if ($code) : ?>
        <input type="hidden" name="code" value="<?= $code ?>">
      <?php endif; ?>
      <input type="hidden" name="table" value="setting_cdn">
      <input type="submit" class="btn btn-btn px-5" value="設定">
      <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
    </form>


  </section>



  <?php
  require("foot.php");
  ?>
  <script src="https://maps.google.com/maps/api/js?key=<?= h($map_api_key) ?>"></script>
  <script>
    var lat_input = document.querySelector("#map_lat").value;
    var lon_input = document.querySelector("#map_lon").value;
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
