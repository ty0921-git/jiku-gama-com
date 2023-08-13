<?php
$login_check="off";
require("head.php");
?>
<title>AXIS</title>
</head>

<body>

<div class="text-end p-3">
<a href="./" class="btn btn-sm btn-main">Login</a>
</div>

  <section class="px-5">
    <h1 class="fc-main">AXIS</h1>
    <div class="mb-5"><?= $_SESSION['message']; ?></div>
     <a class="btn btn-btn" href="<?=$_SERVER['HTTP_REFERER']?>">戻る</a>
  </section>



  <?php
  require("foot.php");
  ?>