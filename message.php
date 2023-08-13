<?php
require("head.php");
?>
<title>メッセージ | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>

    <section class="container mb-4 mb-md-5">
        <h2 class="heading"><span>Message</span> <small>メッセージ</small></h2>
    </section>

    <section class="container mb-5">
        <?= $_SESSION['msg'] ?>
    </section>

    <?php
    require("foot.php");
    ?>
