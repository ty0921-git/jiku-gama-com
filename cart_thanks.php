<?php
require("head.php");
?>
<title>ご購入ありがとうございました | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
  <?php
  require("nav.php");
  ?>
  <section class="p-2 p-md-4"></section>


  <section class="container mb-5">
    <h2 class="heading"><span>Thank you</span> <small>ご購入ありがとうございました</small></h2>
  </section>

  <section class="container mb-5">
    <div>
        <p>ご購入ありがとうございました。</p>
        <p>ご指定のメールアドレスにご購入内容確認のメールを送信しておりますので、ご確認お願い致します。</p>
    </div>
  </section>

  <section class="container mb-5">
    <a href="./" class="btn btn-btn">HOME</a>
  </section>



  <?php
  require("foot.php");
  session_destroy();
  ?>