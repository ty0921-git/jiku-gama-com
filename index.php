<?php
require("head.php");
?>
<title><?= h($site_catch) ?> | <?= h($site_name) ?></title>
</head>

<body>
  <?php
  require("nav.php");
  require("slider_swiper.php");
  require("block_contents.php");
  require("foot.php");
  ?>

  <script>
    let navFixed = document.querySelector('nav');
    navFixed.classList.add('fixed-top');
  </script>
