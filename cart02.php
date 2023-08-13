<?php
require("head.php");
if (empty($_SESSION['cart'])) {
    $_SESSION['msg'] = "カートには何も入っていません。";
    header("location:./message.html");
    exit;
}

// ショップ設定読み込み
$sql = "select*from setting_shop limit 1";
$stmt = connect()->query($sql);
$shop = $stmt->fetch(PDO::FETCH_ASSOC);

// クッキー取得
if (!empty($_COOKIE)) {
    foreach ($_COOKIE as $key => $val) {
        $$key = $val;
    }
}
?>
<title>お客様情報入力 | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>


    <section class="container mb-5">
        <h2 class="heading"><span>Customer Info</span> <small>お客様情報</small></h2>
    </section>


    <form action="cart_confirm.php" method="POST">

        <section class="container mb-5">
            <h3 class="heading"><span>Customer</span> <small>お客様情報</small></h3>
            <div class="row justify-content-center py-4">
                <div class="col-md-7">

                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control" id="name" placeholder="name" value="<?= h($name) ?>" required>
                        <label for="name">お名前<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="zip" class="form-control" id="zip" placeholder="zip" pattern="\d{3}-?\d{4}" onKeyUp="AjaxZip3.zip2addr(this,'','add01','add02');" value="<?= h($zip) ?>" required>
                        <label for="zip">郵便番号<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="add01" name="add01" required>
                            <option value="">選択してください</option>
                            <?php
                            $sql = "select*from area_data";
                            $stmt = connect()->query($sql);
                            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($areas as $area) :
                            ?>
                                <option value="<?= $area['area_name'] ?><><?= zerop($area['code'], 3) ?>" <?php if ($add01 == $area['area_name']) {
                                                                                                                print "selected";
                                                                                                            } ?>><?= h($area['area_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="add01">都道府県</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="add02" class="form-control" id="add02" placeholder="add02" value="<?= h($add02) ?>" required>
                        <label for="add02">市区町村<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="add03" class="form-control" id="add03" placeholder="add03" value="<?= h($add03) ?>" required>
                        <label for="add03">番地・号室<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="tel" class="form-control" id="tel" placeholder="tel" value="<?= h($tel) ?>" required>
                        <label for="tel">TEL<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="email" value="<?= h($email) ?>" required>
                        <label for="email">メール<b>*</b></label>
                    </div>

                </div>
            </div>
        </section>


        <div class="mb-5 text-center">
            <a id="deli_btn" class="btn btn-btn">別の配送先を指定する</a>
        </div>

        <section id="deli_form" class="container mb-5 d-none">
            <h3 class="heading"><span>Shipping Address</span> <small>配送先情報</small></h3>
            <div class="row justify-content-center py-4">
                <div class="col-md-7">

                    <div class="form-floating mb-3">
                        <input type="text" name="deli_name" class="form-control" id="deli_name" placeholder="deli_name" value="<?= h($deli_name) ?>">
                        <label for="deli_name">お名前<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="deli_zip" class="form-control" id="deli_zip" placeholder="deli_zip" pattern="\d{3}-?\d{4}" onKeyUp="AjaxZip3.zip2addr(this,'','deli_add01','deli_add02');" value="<?= h($deli_zip) ?>">
                        <label for="deli_zip">郵便番号<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="deli_add01" name="deli_add01">
                            <option value="">選択してください</option>
                            <?php
                            $sql = "select*from area_data";
                            $stmt = connect()->query($sql);
                            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($areas as $area) :
                            ?>
                                <option value="<?= $area['area_name'] ?><><?= $area['code'] ?>" <?php if ($deli_add01 == $area['area_name']) {
                                                                                                    print "selected";
                                                                                                } ?>><?= h($area['area_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="deli_add01">都道府県</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="deli_add02" class="form-control" id="deli_add02" placeholder="deli_add02" value="<?= h($deli_add02) ?>">
                        <label for="deli_add02">市区町村<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="deli_add03" class="form-control" id="deli_add03" placeholder="deli_add03" value="<?= h($deli_add03) ?>">
                        <label for="deli_add03">番地・号室<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="deli_tel" class="form-control" id="deli_tel" placeholder="deli_tel" value="<?= h($deli_tel) ?>">
                        <label for="deli_tel">TEL<b>*</b></label>
                    </div>

                </div>
            </div>
        </section>


        <section class="container mb-5">
            <hr>
        </section>


        <section class="container mb-5">
            <h3 class="heading"><span>Desired delivery time</span> <small>配送希望日</small></h3>
            <div class="row justify-content-center py-4">
                <div class="col-md-7">

                    <div class="form-floating mb-3">
                        <input id="datepicker" type="text" name="des_day" class="form-control" id="des_day" placeholder="des_day" readonly="readonly" value="<?= h($des_day) ?>">
                        <label for="des_day">配送希望日</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="des_time" name="des_time">
                            <option value="">希望なし</option>
                            <?php
                            $des_times = explode("<>", $shop['des_time']);
                            foreach ($des_times as $des_time_val) : if (empty($des_time_val)) continue;
                            ?>
                                <option value="<?= $des_time_val ?>" <?php if ($des_time_val == $des_time) {
                                                                            print "selected";
                                                                        } ?>><?= h($des_time_val) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="des_time">お受取ご希望時間帯</label>
                    </div>

                </div>
            </div>
        </section>


        <section class="container mb-5">
            <hr>
        </section>


        <section class="container mb-5">
            <h3 class="heading"><span>Payment</span> <small>お支払い方法</small></h3>
            <div class="row justify-content-center py-4">
                <div class="col-md-8">

                    <?php if ($shop['pay_credit'] == 1 && $shop['public_key'] && $shop['secret_key']) : ?>
                        <div class="row g-3 mb-4 border-bottom pb-3">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="credit" value="credit" <?php if ($payment == "credit") print "checked"; ?> required>
                                    <label class="form-check-label" for="credit">
                                        クレジットカード決済
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <i class="fab fa-cc-visa fa-2x"></i>
                                <i class="fab fa-cc-mastercard fa-2x"></i>
                                <i class="fab fa-cc-jcb fa-2x"></i>
                                <i class="fab fa-cc-amex fa-2x"></i>
                                <i class="fab fa-cc-diners-club fa-2x"></i>
                                <i class="fab fa-cc-discover fa-2x"></i>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($shop['pay_cash'] == 1) : ?>
                        <div class="row g-3 mb-4 border-bottom pb-3">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="cash" value="cash" <?php if ($payment == "cash") print "checked"; ?> required>
                                    <label class="form-check-label" for="cash">
                                        代金引換
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                商品配達時に配達員の方に代金をお支払いください。
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($shop['pay_bank'] == 1 && $shop['bank_name'] && $shop['bank_branch'] && $shop['bank_kind'] && $shop['bank_number'] && $shop['bank_holder']) : ?>
                        <div class="row g-3 mb-4 border-bottom pb-3">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="bank" value="bank" <?php if ($payment == "bank") print "checked"; ?> required>
                                    <label class="form-check-label" for="bank">
                                        銀行振込
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">下記の口座に代金をお振込ください。発送は、お振込確認後となります。</div>
                                <div class="alert-kc p-3 text-md-center">
                                    <?= h($shop['bank_name']) ?> <?= h($shop['bank_branch']) ?>　<br class="d-block d-md-none"><?= h($shop['bank_kind']) ?> <?= h($shop['bank_number']) ?>　<?= h($shop['bank_holder']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>


        <section class="container mb-5">
            <hr>
        </section>


        <section class="container mb-5">
            <h3 class="heading"><span>Remarks</span> <small>備考</small></h3>
            <div class="row justify-content-center py-4">
                <div class="col-md-7">

                    <div class="form-floating mb-5">
                        <textarea class="form-control" name="comments" placeholder="comments" id="comments" style="height: 200px"><?= h($comments) ?></textarea>
                        <label for="comments">メッセージ</label>
                    </div>

                    <div class="text-center">
                        <input class="btn btn-btn" id="submit" type="submit" value="ご購入内容確認">
                    </div>

                </div>
            </div>
        </section>








    </form>
    <?php
    require("foot.php");
    ?>

    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <script>
        let deli_btn = document.querySelector("#deli_btn");
        let deli_form = document.querySelector("#deli_form");

        deli_btn.addEventListener("click", () => {
            deli_form.classList.toggle("d-none");
        });
    </script>



    <!-- カレンダー -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css">
    <script>
        $(function() {
            $("#datepicker").datepicker({
                minDate: '<?= h($shop['des_day_min']) ?>',
                maxDate: '<?= h($shop['des_day_max']) ?>',
                format: 'yyyy-mm-dd'
            });
        });
    </script>
