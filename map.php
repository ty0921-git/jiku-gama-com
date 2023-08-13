<script src="https://maps.google.com/maps/api/js?key=<?= $map_api_key ?>"></script>
<script>
  function initialize() {
    var latlng = new google.maps.LatLng(<?= $map_lat ?>, <?= $map_lon ?>);
    var myOptions = {
      zoom: <?= $map_zoom ?>,
      /*拡大比率*/
      center: latlng,
      /*表示枠内の中心点*/
      mapTypeControlOptions: {
        mapTypeIds: ['adimap', google.maps.MapTypeId.ROADMAP]
      },
      /*表示タイプの指定*/
      scrollwheel: false
    };
    var map = new google.maps.Map(document.getElementById('map'), myOptions);

    /*アイコン設定▼*/
    var icon = new google.maps.MarkerImage('image/pin.png',
      new google.maps.Size(<?= $map_isw ?>, <?= $map_ish ?>), /*アイコンサイズ設定*/
      new google.maps.Point(0, 0) /*アイコン位置設定*/
    );
    var markerOptions = {
      position: latlng,
      map: map,
      /*    icon: icon, */
      title: '<?= $map_title ?>'
    };
    var marker = new google.maps.Marker(markerOptions);
    /*アイコン設定ここまで▲*/

    /*取得スタイルの貼り付け*/
    var styleOptions = [{
      "stylers": [{
          "gamma": "<?= $map_gam ?>"
        },
        {
          "saturation": "<?= $map_sat ?>"
        },
        {
          "hue": "<?= $map_hue ?>"
        }
      ]
    }, {}];
    var styledMapOptions = {
      name: '<?= $map_title ?>'
    }
    var adimapType = new google.maps.StyledMapType(styleOptions, styledMapOptions);
    map.mapTypes.set('adimap', adimapType);
    map.setMapTypeId('adimap');
  }
  window.addEventListener('load', initialize);
</script>
