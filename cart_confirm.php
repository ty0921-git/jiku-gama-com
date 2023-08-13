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

list($_POST['add01'], $_POST['addcode']) = explode("<>", $_POST['add01']);
list($_POST['deli_add01'], $_POST['deli_addcode']) = explode("<>", $_POST['deli_add01']);

foreach ($_POST as $key => $val) {
    $$key = h($val);
    setcookie($key, $val, time() + 60 * 60 * 24);
}

// 半角変換
$tel = mb_convert_kana($tel, "r", "UTF-8");
$email = mb_convert_kana($email, "r", "UTF-8");
$deli_tel = mb_convert_kana($tel, "r", "UTF-8");

// 配送エリアコード
if ($deli_addcode) {
    $deli_code = $deli_addcode;
} else {
    $deli_code = $addcode;
}

if (empty($des_day)) {
    $des_day = "希望なし";
}
if (empty($des_time)) {
    $des_time = "希望なし";
}
?>
<title>ご購入内容確認 | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>


    <section class="container mb-5">
        <h2 class="heading"><span>Order</span> <small>ご購入内容確認</small></h2>
        <div class="bg-red p-3 text-white">
            購入手続きは、完了していません。下記の内容を確認して、「購入するボタン」を押してください。
        </div>
    </section>

    <div class="container mb-5">
        <h3 class="heading mb-4"><span>Order</span> <small>ご注文内容</small></h3>
        <table class="table table-cart">
            <tr>
                <th class="text-center wsnw" style="min-width:80px;">画像</th>
                <th>商品名</th>
                <th class="text-center wsnw">小計</th>
            </tr>
            <?php
            $num = 0;
            $total_item = 0;
            $total_deli_fee = 0;
            $array_deli_fee = array();
            foreach ($_SESSION['cart'] as $cart) :
                list($code, $item_name, $price_label, $price, $qty, $delivary, $flag_include, $delivary_group) = explode("<>", $cart);
                $subtotal = $price * $qty;
                $total_item += $subtotal;
                $img = imageCheck("item", "{$code}_sm_01", false);
                $item_name = $item_name . " " . $price_label;

                // 配送区別なしの商品
                if ($delivary == "000") $delivary = "001";

                // 送料カラム名
                $col_name = "delivary_" . $delivary;

                // 個別送料算出
                $sql = "select*from area_data where code='$deli_code' limit 1";
                $stmt = connect()->query($sql);
                $deli_fee = $stmt->fetch(PDO::FETCH_ASSOC);

                // 同梱不可振り分け
                if ($flag_include == 1) {
                    $total_deli_fee += intval($deli_fee[$col_name]);
                } else {
                    if (!$delivary_group) {
                        $delivary_group = "def";
                    }
                    $array_deli_fee[$delivary_group][] = $deli_fee[$col_name];
                }
            ?>
                <tr>
                    <td>
                        <a class="thumb01" href="item_detail_<?= $code ?>.html" style="background-image:url(<?= $img ?>)"></a>
                    </td>
                    <td>
                        <div><a class="fs-md-12" href="item_detail_<?= $code ?>.html"><?= h($item_name) ?></a></div>
                        <div class="text-md-end"><?= d($price) ?> <small>円</small> × <?= h($qty) ?></div>
                    </td>
                    <td class="text-end wsnw fs-md-16"><?= d($subtotal) ?> <small>円</small></td>
                </tr>
            <?php $num++;
            endforeach; ?>
        </table>
    </div>

    <div class="container mb-1">
        <div class="row g-1">
            <div class="col-5 col-md-3 offset-md-6">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">商品合計</div>
            </div>
            <div class="col-7 col-md-3">
                <div class="bg-light text-end fs18 h-100 px-3"><?= d($total_item) ?> <small>円</small></div>
            </div>
        </div>
    </div>


    <?php if ($payment == "cash") :
        if ($total_item < 10000) {
            $cash_fee = $shop['cash_fee_1'];
        } elseif ($total_item >= 10000 and $total_item < 30000) {
            $cash_fee = $shop['cash_fee_2'];
        } elseif ($total_item >= 30000 and $total_item < 300000) {
            $cash_fee = $shop['cash_fee_3'];
        } else {
            $cash_fee = $shop['cash_fee_4'];
        }
    ?>
        <div class="container mb-1">
            <div class="row g-1">
                <div class="col-5 col-md-3 offset-md-6">
                    <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">代引手数料</div>
                </div>
                <div class="col-7 col-md-3">
                    <div class="bg-light text-end fs18 h-100 px-3"><?= d($cash_fee) ?> <small>円</small></div>
                </div>
            </div>
        </div>
    <?php endif; ?>



    <?php
    // 送料計算
    if ($total_item >= $shop['deli_fee_free'] && $shop['deli_fee_free'] > 0) {
        $total_deli_fee = 0;
    } else {
        foreach ($array_deli_fee as $adf) {
            rsort($adf);
            $total_deli_fee += $adf[0];
        }
    }
    ?>

    <section class="container mb-1">
        <div class="row g-1">
            <div class="col-5 col-md-3 offset-md-6">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">送料</div>
            </div>
            <div class="col-7 col-md-3">
                <div class="bg-light text-end fs18 h-100 px-3"><?= d($total_deli_fee) ?> <small>円</small></div>
            </div>
        </div>
    </section>


    <?php
    // お支払い合計計算
    $total_payment = $total_item + $cash_fee + $total_deli_fee;
    ?>

    <section class="container mb-5">
        <div class="row g-1">
            <div class="col-5 col-md-3 offset-md-6">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center fs14">お支払い合計</div>
            </div>
            <div class="col-7 col-md-3">
                <div class="bg-light text-end fs25 h-100 px-3"><?= d($total_payment) ?> <small>円</small></div>
            </div>
        </div>
    </section>


    <section class="container mb-5">
        <hr>
    </section>


    <section class="container mb-5">
        <h3 class="heading mb-4"><span>Customer</span> <small>お客様情報</small></h3>

        <div class="row g-1 justify-centent-center mb-1">
            <div class="col-5 col-md-2 offset-md-2">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">お名前</div>
            </div>
            <div class="col-7 col-md-6">
                <div class="bg-light h-100 p-3"><?= h($name) ?></div>
            </div>
        </div>
        <div class="row g-1 justify-centent-center mb-1">
            <div class="col-5 col-md-2 offset-md-2">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">郵便番号</div>
            </div>
            <div class="col-7 col-md-6">
                <div class="bg-light h-100 p-3">〒<?= h($zip) ?></div>
            </div>
        </div>
        <div class="row g-1 justify-centent-center mb-1">
            <div class="col-5 col-md-2 offset-md-2">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">ご住所</div>
            </div>
            <div class="col-7 col-md-6">
                <div class="bg-light h-100 p-3"><?= h($add01) ?><?= h($add02) ?><?= h($add03) ?></div>
            </div>
        </div>
        <div class="row g-1 justify-centent-center mb-1">
            <div class="col-5 col-md-2 offset-md-2">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">お電話番号</div>
            </div>
            <div class="col-7 col-md-6">
                <div class="bg-light h-100 p-3"><?= h($tel) ?></div>
            </div>
        </div>
        <div class="row g-1 justify-centent-center mb-1">
            <div class="col-5 col-md-2 offset-md-2">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">メール</div>
            </div>
            <div class="col-7 col-md-6">
                <div class="bg-light h-100 p-3"><?= h($email) ?></div>
            </div>
        </div>
    </section>



    <section class="container mb-5">
        <hr>
    </section>


    <?php if ($deli_name) : ?>

        <section class="container mb-5">
            <h3 class="heading mb-4"><span>Shipping Address</span> <small>配送先</small></h3>

            <div class="row g-1 justify-centent-center mb-1">
                <div class="col-5 col-md-2 offset-md-2">
                    <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">お名前</div>
                </div>
                <div class="col-7 col-md-6">
                    <div class="bg-light h-100 p-3"><?= h($deli_name) ?></div>
                </div>
            </div>
            <div class="row g-1 justify-centent-center mb-1">
                <div class="col-5 col-md-2 offset-md-2">
                    <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">郵便番号</div>
                </div>
                <div class="col-7 col-md-6">
                    <div class="bg-light h-100 p-3">〒<?= h($deli_zip) ?></div>
                </div>
            </div>
            <div class="row g-1 justify-centent-center mb-1">
                <div class="col-5 col-md-2 offset-md-2">
                    <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">ご住所</div>
                </div>
                <div class="col-7 col-md-6">
                    <div class="bg-light h-100 p-3"><?= h($deli_add01) ?><?= h($deli_add02) ?><?= h($deli_add03) ?></div>
                </div>
            </div>
            <div class="row g-1 justify-centent-center mb-1">
                <div class="col-5 col-md-2 offset-md-2">
                    <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">お電話番号</div>
                </div>
                <div class="col-7 col-md-6">
                    <div class="bg-light h-100 p-3"><?= h($deli_tel) ?></div>
                </div>
            </div>
        </section>



        <section class="container mb-5">
            <hr>
        </section>


    <?php endif; ?>





    <section class="container mb-5">
        <h3 class="heading mb-4"><span>Desired delivery time</span> <small>配送希望日</small></h3>

        <div class="row g-1 justify-centent-center mb-1">
            <div class="col-5 col-md-2 offset-md-2">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">配送希望日</div>
            </div>
            <div class="col-7 col-md-6">
                <div class="bg-light h-100 p-3"><?= h($des_day) ?></div>
            </div>
        </div>
        <div class="row g-1 justify-centent-center mb-1">
            <div class="col-5 col-md-2 offset-md-2">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">受取希望時間帯</div>
            </div>
            <div class="col-7 col-md-6">
                <div class="bg-light h-100 p-3"><?= h($des_time) ?></div>
            </div>
        </div>
    </section>



    <section class="container mb-5">
        <hr>
    </section>




    <section class="container mb-5">
        <h3 class="heading mb-4"><span>Payment</span> <small>お支払い方法</small></h3>

        <div class="row g-1 justify-centent-center mb-1">
            <div class="col-5 col-md-2 offset-md-2">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">お支払い方法</div>
            </div>
            <div class="col-7 col-md-6">
                <div class="bg-light h-100 p-3">
                    <?php if ($payment == "credit") : ?>クレジットカード<?php endif; ?>
                    <?php if ($payment == "cash") : ?>代金引換<?php endif; ?>
                    <?php if ($payment == "bank") : ?>銀行振込<?php endif; ?>
                </div>
            </div>
        </div>
    </section>



    <section class="container mb-5">
        <hr>
    </section>





    <?php if ($comments) : ?>

        <section class="container mb-5">
            <h3 class="heading mb-4"><span>Remarks</span> <small>備考</small></h3>

            <div class="row g-1 justify-centent-center mb-1">
                <div class="col-5 col-md-2 offset-md-2">
                    <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">内容</div>
                </div>
                <div class="col-7 col-md-6">
                    <div class="bg-light h-100 p-3"><?= h($comments) ?></div>
                </div>
            </div>
        </section>



        <section class="container mb-5">
            <hr>
        </section>


    <?php endif; ?>






    <section class="container mb-5">
        <form action="cart_regi.php" method="POST">
            <div class="text-center">
                <?php if ($payment == "credit") : ?>
                    <script type="text/javascript" src="https://checkout.pay.jp/" class="payjp-button" data-key="<?= $shop['public_key'] ?>" data-submit-text="カード情報を入力" data-partial="false">
                    </script>
                <?php else : ?>
                    <input type="submit" class="btn btn-btn" value="購入する">
                <?php endif; ?>
            </div>

            <?php
            foreach ($_POST as $key => $val) :
            ?>
                <input type="hidden" name="<?= $key ?>" value="<?= $val ?>">
            <?php endforeach; ?>
            <input type="hidden" name="cash_fee" value="<?= $cash_fee ?>">
            <input type="hidden" name="total_item" value="<?= $total_item ?>">
            <input type="hidden" name="total_deli_fee" value="<?= $total_deli_fee ?>">
            <input type="hidden" name="total_payment" value="<?= $total_payment ?>">
            <input type="hidden" name="csrf_token" value="<?= setToken() ?>">
        </form>
    </section>








    <?php
    require("foot.php");
    ?>

    <?php if ($payment == "credit") : ?>
        <script>
            let credit_btn = document.querySelector("#payjp_checkout_box").querySelector("input");
            credit_btn.value = "クレジットカードで購入する";
        </script>
    <?php endif; ?>