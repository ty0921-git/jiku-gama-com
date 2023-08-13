<?php
require("head.php");

// テーブル指定
$table = "delivary";


// ポストデータ取得
$sql = "select*from $table order by code DESC";
$stmt = connect()->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <div class="w-100">
        <section class="container-fluid p-5">
            <h4>送料設定一覧</h4>
            <hr class="mb-4">

            <div class="mb-5">
                <a class="btn btn-btn" href="delivary_form.php">新規追加</a>
            </div>


            <?php
            foreach ($rows as $row) :
                $code = zerop($row['code'], 3);
            ?>
                <div class="row g-3 mb-3 border-bottom pb-2">
                    <div class="col-md-7">
                        <h5><a href="<?= $table ?>_form.php?code=<?= $code ?>"><?= h($row['delivary_name']) ?></a></h5>
                        <div><?= $article ?></div>
                    </div>
                    <div class="col-md-2">
                        <?php if ($row['flag_include'] == 1) : ?>
                            同梱不可
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2">
                        <?php if ($row['delivary_group']) : ?>
                            <?= h($row['delivary_group']) ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-1">
                        <a class="btn btn-btn" href="<?= $table ?>_form.php?code=<?= $code ?>">編集</a>
                    </div>
                </div>
            <?php endforeach; ?>


        </section>



        <section class="d-flex justify-content-center">
            <nav>
                <ul class="pagination">


                    <?php for ($i = 0; $i < $page_num; $i++) : ?>
                        <li class="page-item"><a class="page-link" href="?start=<?= $i ?>&keyword=<?= $_GET['keyword'] ?>"><?= $i + 1 ?></a></li>
                    <?php endfor; ?>


                </ul>
            </nav>
        </section>



    </div>

    <?php
    require("foot.php");
    ?>
