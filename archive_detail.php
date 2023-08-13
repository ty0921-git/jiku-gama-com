<?php
require("head.php");

if ($_GET['code']) {
    $code = $_GET['code'];
} else {
    header("location:./");
    exit;
}

$sql = "select*from archive where code='$code'";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row['display'] == "0") {
    header("location:./");
    exit;
}

$row['code'] = zerop($row['code'], 7);
list($date_update) = explode(" ", $row['date_update']);


// カテゴリーリスト生成
$cate_list = getCategoryList("archive");
?>
<link rel="stylesheet" href="css/article.css">
<title><?= h($row['archive_title']) ?> | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>

    <section class="container mb-4">
        <a href="./">Home</a> <i class='bx bx-chevron-right'></i> <a href="archive_list.html">実績一覧</a>
    </section>

    <div class="container">
        <div class="row g-4">
            <div class="col-md-7">


                <?php if ($img = imageCheck("archive", "{$code}_lg_01", false)) : ?>
                    <section>
                        <img src="<?= $img ?>" name="archive_image" class="img-fluid mb-md-3">
                    </section>
                <?php endif; ?>



            </div>
            <div class="col-md-5">


                <div class="d-flex flex-column">
                    <div class="mb-md-4 order-md-1 order-2">
                        <div class="category mb-2">
                            <?php
                            $cate_codes = getChainCode($code, "archive");
                            foreach ($cate_codes as $cate_code) :
                                if ($cate_code == "") {
                                    continue;
                                };
                            ?>
                                <span class="badge bg-sc"><?= $cate_list[$cate_code['call_code']] ?></span>
                            <?php endforeach; ?>
                            <?php if ($row['date_regi']) : ?>
                                <span class="fs09"><?= h($row['date_regi']) ?></span>
                            <?php endif; ?>
                            <?php if ($row['archive_area']) : ?>
                                <span class="fs09"><?= h($row['archive_area']) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($row['archive_catch']) : ?>
                            <div class="mb-2"><?= h($row['archive_catch']) ?></div>
                        <?php endif; ?>
                        <h2 class="mb-4"><?= h($row['archive_title']) ?></h2>
                        <?php if ($row['short_description']) : ?>
                            <div class="mb-2"><?= h($row['short_description']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="row row-cols-6 g-1 mb-4 order-md-2 order-1">
                        <?php
                        for ($i = 1; $i <= 20; $i++) : $num = zerop($i, 2);
                            $img = imageCheck("archive", "{$code}_sm_{$num}", false);
                            if (empty($img)) {
                                continue;
                            } else {
                                $ext = pathinfo($img, PATHINFO_EXTENSION);
                            }
                        ?>
                            <div class="col">
                                <div class="thumb01" style="cursor:pointer;background-image:url(<?= $img ?>)" onclick="document.archive_image.src='archive/<?= $code ?>_lg_<?= $num ?>.<?= $ext ?>'"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <?php require("sns_button.php"); ?>

            </div>
        </div>
    </div>




    <section class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div id="article"><?= $row['description'] ?></div>
            </div>
        </div>
    </section>



    <section class="container mb-5">
        <h2 class="heading mb-4 mb-md-5"><span>Others</span> <small>その他の実績</small><a href="archive_list.html">実績一覧</a></h2>
        <?php require("archive01_side.php"); ?>
    </section>
    <?php
    require("foot.php");
    ?>
