<?php
require("head.php");

// テーブル指定
$table = "order_data";


// ゲット変数の無害化処理
$get_code = h(filter_input(INPUT_GET, 'code'));


// コード指定データ取得
if ($get_code) {
    $sql = "select*from $table where code=$get_code";
    $stmt = connect()->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $code = zerop($row['code'], 15);
}
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <div class="w-100">
        <section class="container-fluid p-5">

            <form action="db_op.php" method="POST">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="date_order" id="date_order" placeholder="#" value="<?= h($row['date_order']) ?>" disabled>
                    <label for="date_order">注文日</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="order_number" id="order_number" placeholder="#" value="<?= h($row['order_number']) ?>" disabled>
                    <label for="order_number">オーダーナンバー</label>
                </div>

                <hr class="my-5">

                <div class="row g-4">
                    <div class="col">
                        <h5 class="mb-4 fc-main">ご購入者情報</h5>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="#" value="<?= h($row['name']) ?>">
                            <label for="name">購入者名</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="zip" id="zip" placeholder="#" value="<?= h($row['zip']) ?>">
                            <label for="zip">郵便番号</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="add01" id="add01" placeholder="#" value="<?= h($row['add01']) ?>">
                            <label for="add01">都道府県</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="add02" id="add02" placeholder="#" value="<?= h($row['add02']) ?>">
                            <label for="add02">市区町村</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="add03" id="add03" placeholder="#" value="<?= h($row['add03']) ?>">
                            <label for="add03">番地・部屋番号</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="tel" id="tel" placeholder="#" value="<?= h($row['tel']) ?>">
                            <label for="tel">TEL</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="email" id="email" placeholder="#" value="<?= h($row['email']) ?>">
                            <label for="email">メール</label>
                        </div>
                    </div>
                    <div class="col">
                        <h5 class="mb-4 fc-main">配送先情報</h5>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="deli_name" id="deli_name" placeholder="#" value="<?= h($row['deli_name']) ?>">
                            <label for="deli_name">配送先名</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="deli_zip" id="deli_zip" placeholder="#" value="<?= h($row['deli_zip']) ?>">
                            <label for="deli_zip">郵便番号</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="deli_add01" id="deli_add01" placeholder="#" value="<?= h($row['deli_add01']) ?>">
                            <label for="deli_add01">都道府県</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="deli_add02" id="deli_add02" placeholder="#" value="<?= h($row['deli_add02']) ?>">
                            <label for="deli_add02">市区町村</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="deli_add03" id="deli_add03" placeholder="#" value="<?= h($row['deli_add03']) ?>">
                            <label for="deli_add03">番地・部屋番号</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="deli_tel" id="deli_tel" placeholder="#" value="<?= h($row['deli_tel']) ?>">
                            <label for="deli_tel">TEL</label>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <h5 class="mb-4 fc-main">ご注文内容</h5>

                <div class="row g-3">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="order_list" placeholder="#" style="height:200px;"><?= h($row['order_list']) ?></textarea>
                            <label for="order_list">オーダーリスト</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="comments" placeholder="#" style="height:200px;"><?= h($row['comments']) ?></textarea>
                            <label for="comments">備考</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="total_item" id="total_item" placeholder="#" value="<?= h($row['total_item']) ?>">
                            <label for="total_item">商品合計</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="cash_fee" id="cash_fee" placeholder="#" value="<?= h($row['cash_fee']) ?>">
                            <label for="cash_fee">代引手数料</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="total_deli_fee" id="total_deli_fee" placeholder="#" value="<?= h($row['total_deli_fee']) ?>">
                            <label for="total_deli_fee">送料</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="total_payment" id="total_payment" placeholder="#" value="<?= h($row['total_payment']) ?>">
                            <label for="total_payment">お支払い合計</label>
                        </div>

                        <div class="row g-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="payment" name="payment">
                                        <option value="credit" <?php if ($row['payment'] == "credit") {
                                                                    print "selected";
                                                                } ?>>クレジット</option>
                                        <option value="cash" <?php if ($row['payment'] == "cash") {
                                                                    print "selected";
                                                                } ?>>代金引換</option>
                                        <option value="bank" <?php if ($row['payment'] == "bank") {
                                                                    print "selected";
                                                                } ?>>銀行振込</option>
                                    </select>
                                    <label for="payment">お支払い方法</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="des_day" id="des_day" placeholder="#" value="<?= h($row['des_day']) ?>">
                                    <label for="des_day">配達希望日</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="des_time" id="des_time" placeholder="#" value="<?= h($row['des_time']) ?>">
                                    <label for="des_time">受取希望時間</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <hr class="my-5">

                <h5 class="mb-4 fc-main">トラッキングナンバー</h5>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="tracking" id="tracking" placeholder="#" value="<?= h($row['tracking']) ?>">
                    <label for="tracking">トラッキングナンバー</label>
                </div>

                <hr class="my-5">

                <h5 class="mb-4 fc-main">ステータス</h5>

                <div class="row g-3">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="st_payment" name="st_payment">
                                <option value="1" <?php if ($row['st_payment'] == 1) {
                                                        print "selected";
                                                    } ?>>ON</option>
                                <option value="" <?php if (!$row['st_payment']) {
                                                        print "selected";
                                                    } ?>>OFF</option>
                            </select>
                            <label for="st_payment">入金</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="st_delivary" name="st_delivary">
                                <option value="1" <?php if ($row['st_delivary'] == 1) {
                                                        print "selected";
                                                    } ?>>ON</option>
                                <option value="" <?php if (!$row['st_delivary']) {
                                                        print "selected";
                                                    } ?>>OFF</option>
                            </select>
                            <label for="st_delivary">配送</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="st_cancel" name="st_cancel">
                                <option value="1" <?php if ($row['st_cancel'] == 1) {
                                                        print "selected";
                                                    } ?>>ON</option>
                                <option value="" <?php if (!$row['st_cancel']) {
                                                        print "selected";
                                                    } ?>>OFF</option>
                            </select>
                            <label for="st_cancel">キャンセル</label>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <input type="hidden" name="table" value="<?= $table ?>">
                <?php if (!$code) : ?>
                    <input type="hidden" name="date_regi" value="<?= date("Y-m-d") ?>">
                <?php else : ?>
                    <input type="hidden" name="code" value="<?= $code ?>">
                <?php endif; ?>
                <input type="submit" class="btn btn-btn px-5" value="登録">
                <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
            </form>

        </section>

        <?php if ($code) : ?>
            <section class="container-fluid p-5">
                <hr>
                <!-- Button trigger modal -->
                <div class="d-flex justify-content-between">
                    <a href="order_list.php" class="btn btn-btn">オーダー一覧</a>
                </div>
            </section>
        <?php endif; ?>



    </div>

    <?php
    require("foot.php");
    ?>
