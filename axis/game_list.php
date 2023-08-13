<?php
require("head.php");

// テーブル指定
$table = "game";

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
    $sql = "select*from $table where game_title like '%$keyword%' or game_opponent like '%$keyword%'";
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


// データ取得
$sql = "select*from $table order by game_date DESC limit $start,$disp_data";
if ($keyword) {
    $sql = "select*from $table where game_title like '%$keyword%' or game_opponent like '%$keyword%' order by game_date DESC limit $start,$disp_data";
}
$stmt = connect()->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


// チームデータ取得
$team = get_row("setting_game", "0000001");
$team_name = $team['team_name'];
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <div class="w-100">
        <section class="container-fluid p-5">
            <h4>ゲーム一覧</h4>
            <hr class="mb-4">

            <form action="" method="GET">
                <div class="row g-1 mb-5">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="text" name="keyword" class="form-control" placeholder="キーワード" value="<?= h($keyword) ?>">
                            <button class="btn btn-btn" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row g-5 mb-5">
                <?php
                foreach ($rows as $row) :
                    $code = zerop($row['code'], 7);
                ?>

                    <div class="col-md-6 col-lg-4">
                        <a href="<?= $table ?>_form.php?code=<?= $code ?>" class="d-flex flex-column justify-content-center align-items-center p-3 p-md-4 border mb-3">
                            <h5 class="mb-4"><?= h($row['game_date']) ?></h5>
                            <?php if ($row['game_catch']) : ?>
                                <div class="mb-2"><?= h($row['game_catch']) ?></div>
                            <?php endif; ?>
                            <h5 class="mb-4"><?= h($row['game_title']) ?></h5>


                            <div class="d-flex justify-content-around align-items-center w-100 mb-4">
                                <div class="text-center">
                                    <?php if ($logo_team = imageCheck("../image", "team-logo", false)) : ?>
                                        <img src="<?= h($logo_team) ?>" class="img-fluid mb-3" style="height:50px; width:auto;">
                                    <?php endif; ?>
                                    <div class="fs7"><?= h($team_name) ?></div>
                                </div>
                                <div class="fs20 fc-main" style="white-space:nowrap;">
                                    <?= $row['game_score_team'] ?> - <?= $row['game_score_opponent'] ?>
                                </div>
                                <div class="text-center">
                                    <?php if ($logo_opponent = imageCheck("../game", "{$code}_logo_opponent", false)) : ?>
                                        <img src="<?= h($logo_opponent) ?>" class="img-fluid mb-3" style="height:50px; width:auto;">
                                    <?php endif; ?>
                                    <div class="fs7"><?= h($row['game_opponent']) ?></div>
                                </div>
                            </div>


                            <div class="row row-cols-5 d-none d-lg-flex fs8">
                                <?php
                                $game_score_details = explode("\n", $row['game_score_details']);
                                for ($i = 0; $i < sizeof($game_score_details); $i++) :
                                    list($detail_team_label, $detail_team_score, $detail_set, $detail_opponent_score, $detail_opponent_label) = explode("<>", $game_score_details[$i]);
                                ?>
                                    <div class="col text-center"><?= h($detail_team_label) ?></div>
                                    <div class="col text-center"><?= h($detail_team_score) ?></div>
                                    <div class="col text-center"><?= h($detail_set) ?></div>
                                    <div class="col text-center"><?= h($detail_opponent_score) ?></div>
                                    <div class="col text-center"><?= h($detail_opponent_label) ?></div>
                                <?php endfor; ?>
                            </div>
                        </a>
                        <div class="mb-3">
                            <span class="badge bg-dark"><?= $code ?></span>
                            <?php if ($row['display'] == 1) : ?>
                                <span class="badge bg-cgreen">表示中</span>
                            <?php else : ?>
                                <span class="badge bg-cred">非表示</span>
                            <?php endif; ?>
                            <?php
                            $cate_nums = get_chains($table, $code);
                            foreach ($cate_nums as $cate_num) :
                            ?>
                                <span class="badge bg-corange"><?= h($category_array[$cate_num]) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-end">
                            <a class="btn btn-btn" href="<?= $table ?>_form.php?code=<?= $code ?>">編集</a>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>


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
