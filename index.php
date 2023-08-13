<?php
require("head.php");
?>
<title><?= h($site_catch) ?> | <?= h($site_name) ?></title>
</head>

<body>
  <?php
  require("nav.php");
  require("slider_swiper.php");
  require("block_news.php");
  require("block_contents.php");
  require("block_archive.php");
  require("block_items.php");
  require("block_staff.php");
  require("block_spot.php");
  require("foot.php");
  ?>