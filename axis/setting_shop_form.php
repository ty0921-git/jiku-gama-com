<?php
require("head.php");

$sql = "select*from setting_shop limit 1";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <section class="container-fluid p-5">
        <?php
        if (!empty($row)) {
            foreach ($row as $key => $val) {
                $$key = h($val);
            }
        }
        ?>
        <h4>ショップ設定</h4>
        <hr class="mb-5">

        <form action="db_op.php" method="POST">

            <div class="row">

                <div class="col-md-6">
                    <h6>APIキー</h6>
                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="public_key" id="public_key" placeholder="#" value="<?= $public_key ?>">
                        <label for="public_key">PAY.JP 公開鍵</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="secret_key" id="secret_key" placeholder="#" value="<?= $secret_key ?>">
                        <label for="secret_key">PAY.JP 秘密鍵</label>
                    </div>


                    <h6 class="mt-5">配送希望日時</h6>
                    <hr>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="des_day_min" name="des_day_min">
                                    <?php for ($i = 0; $i <= 30; $i++) : ?>
                                        <option value="<?= $i ?>" <?php if ($i == $des_day_min) {
                                                                        print "selected";
                                                                    } ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="des_day_min">最短</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="des_day_max" name="des_day_max">
                                    <?php for ($i = 0; $i <= 30; $i++) : ?>
                                        <option value="<?= $i ?>" <?php if ($i == $des_day_max) {
                                                                        print "selected";
                                                                    } ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="des_day_max">最長</label>
                            </div>
                        </div>
                    </div>


                    <?php
                    $des_time_data = explode("<>", $row['des_time']);
                    for ($i = 0; $i < sizeof($des_time_data); $i++) :
                        if ($des_time_data[$i] == "" && $i != 0) continue;
                    ?>
                        <div id="des_time_area" class="mb-3">
                            <div class="row g-3" id="line">
                                <div class="col-md-7">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="des_time[]" id="des_time" placeholder="#" value="<?= $des_time_data[$i] ?>">
                                        <label for="des_time">配送希望時間</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <a class="btn btn-btn" id="line_add" onclick="line_add(this)"><i class="bi bi-plus"></i></a>
                                    <a class="btn btn-btn" id="line_del" onclick="line_del(this)"><i class="bi bi-dash"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>


                    <h6 class="mt-5">お支払い方法</h6>
                    <hr>

                    <div class="row row-cols-3 g-3">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="pay_credit" name="pay_credit">
                                    <option selected value="1" <?php if ($row['pay_credit'] == "1") {
                                                                    print "selected";
                                                                } ?>>ON</option>
                                    <option value="0" <?php if ($row['pay_credit'] == "0") {
                                                            print "selected";
                                                        } ?>>OFF</option>
                                </select>
                                <label for="pay_credit">クレジットカード</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="pay_cash" name="pay_cash">
                                    <option selected value="1" <?php if ($row['pay_cash'] == "1") {
                                                                    print "selected";
                                                                } ?>>ON</option>
                                    <option value="0" <?php if ($row['pay_cash'] == "0") {
                                                            print "selected";
                                                        } ?>>OFF</option>
                                </select>
                                <label for="pay_cash">代金引換</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="pay_bank" name="pay_bank">
                                    <option selected value="1" <?php if ($row['pay_bank'] == "1") {
                                                                    print "selected";
                                                                } ?>>ON</option>
                                    <option value="0" <?php if ($row['pay_bank'] == "0") {
                                                            print "selected";
                                                        } ?>>OFF</option>
                                </select>
                                <label for="pay_bank">銀行振込</label>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-6">

                    <h6>銀行振込先</h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="#" value="<?= $bank_name ?>">
                                <label for="bank_name">銀行名</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="bank_branch" id="bank_branch" placeholder="#" value="<?= $bank_branch ?>">
                                <label for="bank_branch">支店名</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" id="bank_kind" name="bank_kind">
                                    <option value="普通" <?php if ($bank_kind == "普通") {
                                                            print "selected";
                                                        } ?>>普通</option>
                                    <option value="当座" <?php if ($bank_kind == "当座") {
                                                            print "selected";
                                                        } ?>>当座
                                    </option>
                                </select>
                                <label for="bank_kind">最短</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="bank_number" id="bank_number" placeholder="#" value="<?= $bank_number ?>">
                                <label for="bank_number">口座番号</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="bank_holder" id="bank_holder" placeholder="#" value="<?= $bank_holder ?>">
                                <label for="bank_holder">名義</label>
                            </div>
                        </div>




                    </div>


                    <h6 class="mt-5">代引手数料</h6>
                    <hr>
                    <div class="row row-cols-2 g-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="cash_fee_1" id="cash_fee_1" placeholder="#" value="<?= $cash_fee_1 ?>">
                                <label for="cash_fee_1">〜1万円未満</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="cash_fee_2" id="cash_fee_2" placeholder="#" value="<?= $cash_fee_2 ?>">
                                <label for="cash_fee_2">1万円〜3万円未満</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="cash_fee_3" id="cash_fee_3" placeholder="#" value="<?= $cash_fee_3 ?>">
                                <label for="cash_fee_3">3万円〜30万円未満</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="cash_fee_4" id="cash_fee_4" placeholder="#" value="<?= $cash_fee_4 ?>">
                                <label for="cash_fee_4">30万円以上</label>
                            </div>
                        </div>
                    </div>


                    <h6 class="mt-5">送料無料購入金額</h6>
                    <hr>
                    <div class="form-floating">
                        <input type="text" class="form-control" name="deli_fee_free" id="deli_fee_free" placeholder="#" value="<?= $deli_fee_free ?>">
                        <label for="deli_fee_free">購入金額</label>
                    </div>


                </div>

            </div>


            <?php if ($code) : ?>
                <input type="hidden" name="code" value="<?= $code ?>">
            <?php endif; ?>
            <input type="hidden" name="table" value="setting_shop">
            <input type="submit" class="btn btn-btn px-5" value="設定">
            <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
        </form>


    </section>



    <?php
    require("foot.php");
    ?>


    <script>
        function line_add(e) {
            let line = e.closest("#line");
            let elm = line.cloneNode(true);
            line.after(elm);
            console.log(elm.querySelector("#des_time").value = "");
        }

        function line_del(e) {
            let line = e.closest("#line");
            line.remove();
        }
    </script>
