<?php
require("head.php");

// テーブル指定
$table = "faq";

// カテゴリーデータ取得
$categories = get_category($table);

// カテゴリー連想配列の作成
$category_array = array();
foreach ($categories as $category) {
    $category_array += array($category['code'] => $category['cate_name']);
}

// キーワード無害化
$keyword = h(filter_input(INPUT_GET, 'keyword'));
$get_start = h(filter_input(INPUT_GET, 'start'));

// データ件数取得
$sql = "select*from $table";
if ($keyword) {
    $sql = "select*from $table where faq_que like '%$keyword%' or faq_ans like '%$keyword%'";
}
$stmt = connect()->query($sql);
$cnt = $stmt->rowCount();

// 表示データ設定
$disp_data = 50;

// ページ数
$page_num = ceil($cnt / $disp_data);

// 開始ページ
if ($get_start) {
    $start = $get_start * $disp_data;
} else {
    $start = 0;
}


// FAQデータ取得
$sql = "select*from $table order by code DESC limit $start,$disp_data";
if ($keyword) {
    $sql = "select*from $table where faq_que like '%$keyword%' or faq_ans like '%$keyword%' order by code DESC limit $start,$disp_data";
}
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
            <h4>FAQ一覧</h4>
            <hr class="mb-4">

            <form action="" method="GET">
                <div class="row g-1 mb-5">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="text" name="keyword" class="form-control" placeholder="キーワード" value="<?= $keyword ?>">
                            <button class="btn btn-btn" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>


            <?php
            foreach ($rows as $row) :
                $code = zerop($row['code'], 7);
                $faq_ans = strip_tags($row['faq_ans']);
                $limit = 200;
                if (mb_strlen($faq_ans) > $limit) {
                    $faq_ans = mb_substr($faq_ans, 0, $limit) . " ...";
                }
            ?>

                <div class="row g-3 mb-5">
                    <div class="col-md-11">
                        <div class="mb-3">
                            <span class="badge bg-dark"><?= $code ?></span>
                            <?php if ($row['display'] == 1) : ?>
                                <span class="me-3 badge bg-cgreen">表示中</span>
                            <?php else : ?>
                                <span class="me-3 badge bg-cred">非表示</span>
                            <?php endif; ?>
                            <?php
                            $cate_nums = get_chains($table, $code);
                            foreach ($cate_nums as $cate_num) :
                            ?>
                                <span class="badge bg-corange"><?= h($category_array[$cate_num]) ?></span>
                            <?php endforeach; ?>
                        </div>

                        <h5><a href="<?= $table ?>_form.php?code=<?= $code ?>"><?= h($row['faq_que']) ?></a></h5>
                        <div><?= $faq_ans ?></div>
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
                        <li class="page-item"><a class="page-link" href="?start=<?= $i ?>&keyword=<?= $keyword ?>"><?= $i + 1 ?></a></li>
                    <?php endfor; ?>


                </ul>
            </nav>
        </section>



    </div>

    <?php
    require("foot.php");
    ?>
