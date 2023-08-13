<?php
require("head.php");

if ($_GET['code']) {
    $code = $_GET['code'];
} else {
    header("location:./");
    exit;
}

$sql = "select*from faq where code='$code'";
$stmt = connect()->query($sql);
$faq = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<title><?= h($faq['faq_que']) ?> | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>



    <section class="container mb-4">
        <a href="./">Home</a> <i class='bx bx-chevron-right'></i> <a href="faq_list.html">FAQ一覧</a>
    </section>



    <section class="container mb-4 mb-md-5">
        <h2 class="heading"><span><?= $faq['faq_que'] ?></span></h2>
    </section>



    <section class="container mb-5">
        <div class="px-3"><?= $faq['faq_ans'] ?></div>
    </section>



    <?php
    require("foot.php");
    ?>
