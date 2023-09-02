<?php
require("head.php");
?>
<title>プロフィール | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
  <?php
  require("nav.php");
  ?>
  <section class="p-2 p-md-4"></section>


  <section class="container mb-5 min">
    <h2 class="heading mb-4 mb-md-5"><span>Potter</span> <small>陶芸家</small></h2>

    <div class="row g-md-5">
      <div class="col-md-4">
        <img src="image/potter3.jpg" class="img-fluid mb-4 mb-md-0">
      </div>
      <div class="col-md-8">

        <div class="mb-5">
          <span>陶芸家</span>
          <h2 class="fs20 mb-4">峰 とし子 <small>- Mine Toshiko -</small></h2>
          <p>陶器の魅力に導かれ独学で一心不乱、陶芸に没頭。その後、人間国宝「井上萬二」氏に師事し、陶芸の基礎を習得。既成に捉われない自由な発想で作陶活動を展開。</p>
        </div>

      </div>
    </div>
  </section>



  <?php
  require("foot.php");
  ?>
