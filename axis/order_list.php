<?php
require("head.php");


$today = gmdate("Y-m-d", time() + 9 * 3600);
$month = gmdate("Y-m", time() + 9 * 3600);

if (!$start_date = filter_input(INPUT_GET, 'start_date')) {
    $start_date = $month . "-01";
}

if (!$end_date = filter_input(INPUT_GET, 'end_date')) {
    $end_date = $today;
}

// テーブル指定
$table = "order_data";


// キーワード無害化
$keyword = h(filter_input(INPUT_GET, 'keyword'));
$get_start = h(filter_input(INPUT_GET, 'start'));


// データ件数取得
$sql = "select*from $table where date_order >= '$start_date' and date_order <= '$end_date'";
if ($keyword) {
    $sql = "select*from $table where order_number like '%$keyword%' or name like '%$keyword%' or deli_name like '%$keyword%'";
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
$sql = "select*from $table where date_order >= '$start_date' and date_order <= '$end_date' order by code DESC limit $start,$disp_data";
if ($keyword) {
    $sql = "select*from $table where order_number like '%$keyword%' or name like '%$keyword%' or deli_name like '%$keyword%' order by code DESC limit $start,$disp_data";
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
            <h4>注文一覧</h4>
            <hr class="mb-4">

            <form action="" method="GET">
                <div class="row g-1 mb-5">
                    <div class="col-md-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="#" value="<?= $keyword ?>">
                            <label for="keyword">キーワード</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" name="start_date" id="start_date" placeholder="#" value="<?= $start_date ?>">
                            <label for="start_date">データ取得開始日</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" name="end_date" id="end_date" placeholder="#" value="<?= $end_date ?>">
                            <label for="end_date">データ取得終了日</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <input class="btn btn-btn p-3" type="submit" value="確定">
                    </div>
                </div>
            </form>


            <?php
            foreach ($rows as $row) :
                $code = zerop($row['code'], 15);
            ?>

                <div class="row g-3 mb-5">
                    <div class="col-md-2">
                        <?php if ($row['st_cancel'] != 1) : ?>
                            <?php if ($row['st_payment'] == 1) : ?>
                                <a class="btn btn-cgreen">入金</a>
                            <?php else : ?>
                                <a id="st_payment" class="btn btn-light" data-code="<?= $code ?>">入金</a>
                            <?php endif; ?>
                            <?php if ($row['st_delivary'] == 1) : ?>
                                <a class="btn btn-cgreen">配送</a>
                                <div class="mt-3">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tracking" id="tracking" placeholder="追跡番号" value="<?= h($row['tracking']) ?>" disabled>
                                            <button id="btn-tracking" class="btn btn-btn" type="button" data-code="<?= $code ?>" disabled><i class="bi bi-envelope"></i></button>
                                        </div>
                                    </form>
                                </div>
                            <?php else : ?>
                                <a id="st_delivary" class="btn btn-light" data-stcode="<?= $code ?>">配送</a>
                                <div class="mt-3">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tracking" id="tracking" placeholder="追跡番号" value="<?= h($row['tracking']) ?>">
                                            <button id="btn-tracking" class="btn btn-btn" type="button" data-code="<?= $code ?>"><i class="bi bi-envelope"></i></button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($row['st_cancel'] == 1) : ?>
                            <div class="mt-3 bg-cred text-center p-2 rounded">キャンセル</div>
                        <?php endif; ?>

                        <a class="btn btn-btn mt-3" href="order_detail.php?code=<?= $code ?>">編集</a>
                    </div>
                    <div class="col-md-5">
                        <div class="row row-cols-1 row-cols-md-3 mb-2">
                            <div class="col">
                                <span class="badge bg-accent">ご注文日</span> <?= h($row['date_order']) ?>
                            </div>
                            <div class="col">
                                <?php if ($row['des_day'] != "0000-00-00") : ?>
                                    <span class="badge bg-accent">配送希望</span> <?= h($row['des_day']) ?>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <?php if ($row['des_time']) : ?>
                                    <span class="badge bg-accent">受取時間</span> <?= h($row['des_time']) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-4"><span class="badge bg-accent">注文番号</span> <?= h($row['order_number']) ?></div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-2"><span class="badge bg-accent">ご購入者</span></div>
                                <div><?= h($row['name']) ?> <small>様</small></div>
                                <div>〒<?= h($row['zip']) ?></div>
                                <div><?= h($row['add01']) ?><?= h($row['add02']) ?><?= h($row['add03']) ?></div>
                                <div>TEL <?= h($row['tel']) ?></div>
                                <div><a href="mailto:<?= h($row['email']) ?>"><?= h($row['email']) ?></a></div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2"><span class="badge bg-accent">配送先</span></div>
                                <div><?= h($row['deli_name']) ?> <small>様</small></div>
                                <div>〒<?= h($row['deli_zip']) ?></div>
                                <div><?= h($row['deli_add01']) ?><?= h($row['deli_add02']) ?><?= h($row['deli_add03']) ?></div>
                                <div>TEL <?= h($row['deli_tel']) ?></div>
                                <?php if ($row['name'] != $row['deli_name'] || $row['zip'] != $row['deli_zip'] || $row['add01'] != $row['deli_add01'] || $row['add02'] != $row['deli_add02'] || $row['add03'] != $row['deli_add03']) : ?>
                                    <div class="mt-3"><span class="small bg-cred p-2">配送先確認</span></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-2"><span class="badge bg-accent">ご注文内容</span></div>
                        <div class="mb-3"><?= nl2br($row['order_list']) ?></div>
                        <div class="fs14">
                            <small>商品合計</small> <?= d($row['total_item']) ?> <small>円 / </small>
                            <small>送料</small> <?= d($row['total_deli_fee']) ?> <small>円 / </small>
                            <small>代引手数料</small> <?= d($row['cash_fee']) ?> <small>円</small>
                        </div>
                        <div class="fs20"><small><span class="badge bg-accent">お支払い金額</span></small> <?= d($row['total_payment']) ?> <small>円</small></div>
                        <div>
                            <span class="badge bg-accent me-1">お支払い方法</span>
                            <?php if ($row['payment'] == "credit") : ?>クレジットカード<?php endif; ?>
                            <?php if ($row['payment'] == "cash") : ?>代金引換<?php endif; ?>
                            <?php if ($row['payment'] == "bank") : ?>銀行振込<?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-10 offset-2">
                        <div>
                            <div class="mb-2"><span class="badge bg-accent">備考</span></div><?= h(nl2br($row['comments'])) ?>
                        </div>
                    </div>
                </div>
                <hr class="mb-5">

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

    <script>
        let btn = document.querySelectorAll("#st_payment");
        for (let i = 0; i < btn.length; i++) {
            btn[i].addEventListener("click", function() {
                let code = btn[i].dataset.code;
                let col = btn[i].id;
                let val = 1;
                switch_val(code, col, val);
                btn[i].classList.add("btn-cgreen");
                btn[i].classList.remove("btn-light");
            });
        }

        let btn_tracking = document.querySelectorAll("#btn-tracking");
        for (let i = 0; i < btn_tracking.length; i++) {
            btn_tracking[i].addEventListener("click", function() {
                let code = btn_tracking[i].dataset.code;
                let tracking = btn_tracking[i].previousElementSibling;

                switch_val(code, "st_delivary", 1);
                switch_val(code, "tracking", tracking.value);
                let st_delivary = document.querySelector("[data-stcode=\"" + code + "\"]");
                st_delivary.classList.add("btn-cgreen");
                st_delivary.classList.remove("btn-light");
                tracking.disabled = true;
                btn_tracking[i].disabled = true;
            });
        }


        async function switch_val(code, col, val) {
            const request = "switch_val.php?code=" + code + "&col=" + col + "&val=" + val;
            await (await fetch(request, {
                method: 'GET'
            }));
        }
    </script>
