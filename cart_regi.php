<?php
require("function.php");
checkToken();
get_setting();

if (empty($_SESSION['cart'])) {
    header("location:./cart01.php");
}


// ショップ設定読み込み
$sql = "select*from setting_shop limit 1";
$stmt = connect()->query($sql);
$shop = $stmt->fetch(PDO::FETCH_ASSOC);



// PAY.JP処理 ////////////////////////////////////////////////////////////////////////

if ($_POST['payment'] == "credit") {


    require_once 'init.php';

    //支払い以外のアクセスは弾く
    if (!isset($_POST['payjp-token'])) {
        echo "トークンがセットされていません";
        exit;
    }

    //失敗時のメッセージ
    $err            = 'エラー';
    //送られてきた、顧客のカード情報を使って作成されたトークン
    $token          = $_POST['payjp-token'];
    //支払い価格
    $amount = $_POST['total_payment'];
    //秘密鍵
    $secret = $shop['secret_key'];
    //通貨(通常は日本円を表す'jpy'を指定する)
    $currency = 'jpy';

    try {
        //新しい課金の作成
        Payjp\Payjp::setApiKey($secret);
        $result = Payjp\Charge::create(array(
            "card" => $token,
            "amount" => $amount,
            "currency" => $currency
        ));
        if (isset($result['error'])) {
            throw new Exception();
        }
    } catch (Exception $e) {
        // カードが拒否された場合
        $err = $result['error']['message'];
        echo $err;
        exit;
    }


    $st_payment = 1;
} elseif ($_POST['payment'] == "cash") {
    $st_payment = 1;
} else {
    $st_payment = 0;
}

////////////////////////////////////////////////////////////////////////////////////////////////





// オーダーナンバーの発行
$ot = gmdate("Ymdhms", time() + 9 * 3600);
$rand_num = rand(10000, 99999);
$_SESSION['order_number'] = $ot . "-D-" . $rand_num;


// 購入内容書き出し
$order_list = "";
foreach ($_SESSION['cart'] as $cart) {
    list($code, $item_name, $price_lavel, $price, $qty) = explode("<>", $cart);
    $s_total = $price * $qty;
    $order_list .= "$code : $item_name $price_lavel " . d($price) . " 円 x $qty = " . d($s_total) . " 円 \n";
}


// 代金引換手数料表示
if ($_POST['payment'] == "cash") {
    $cod = "\n[ 代引き手数料 ] " . d($_POST['cash_fee']) . " 円\n";
}



// フッターテンプレート呼び出し
$sql = "select*from mailtemp where call_code='footer'";
$stmt = connect()->query($sql);
$footer = $stmt->fetch(PDO::FETCH_ASSOC);

// 本文テンプレート呼び出し
$sql = "select*from mailtemp where call_code='confirm_purchase'";
$stmt = connect()->query($sql);
$cp = $stmt->fetch(PDO::FETCH_ASSOC);

$mt = $cp['mail_title'];
$mb = $cp['mail_body'] . $footer['mail_body'];



// 表示整形
switch ($_POST['payment']) {
    case "credit":
        $payment_type = "クレジットカード";
        break;
    case "cash":
        $payment_type = "代金引換";
        break;
    case "bank":
        $payment_type = "銀行振込";
        break;
}


// 配送先の指定
if (!$_POST['deli_name']) {
    $_POST['deli_name'] = $_POST['name'];
}
if (!$_POST['deli_zip']) {
    $_POST['deli_zip'] = $_POST['zip'];
}
if (!$_POST['deli_add01']) {
    $_POST['deli_add01'] = $_POST['add01'];
}
if (!$_POST['deli_add02']) {
    $_POST['deli_add02'] = $_POST['add02'];
}
if (!$_POST['deli_add03']) {
    $_POST['deli_add03'] = $_POST['add03'];
}
if (!$_POST['deli_tel']) {
    $_POST['deli_tel'] = $_POST['tel'];
}



foreach ($_POST as $key => $val) {
    $ex = "<$key>";
    if (strpos($key, "total") !== false) {
        $val = d($val);
    }
    if (strpos($key, "cash_fee") !== false) {
        $val = d($val);
    }
    if (strpos($key, "des_day") !== false) {
        if (empty($val)) $val = "希望なし";
    }
    if (strpos($key, "des_time") !== false) {
        if (empty($val)) $val = "希望なし";
    }
    $de = $val;
    $mb = str_replace($ex, $de, $mb);
}

$mb = str_replace("<date>", $date_today, $mb);
$mb = str_replace("<order_number>", $_SESSION['order_number'], $mb);
$mb = str_replace("<cod>", $cod, $mb);
$mb = str_replace("<payment_type>", $payment_type, $mb);
$mb = str_replace("<order_list>", $order_list, $mb);
$mb = str_replace("<site_name>", $site_name, $mb);
$mb = str_replace("<site_url>", $site_url, $mb);
$mb = str_replace("<com_name>", $com_name, $mb);
$mb = str_replace("<com_zip>", $com_zip, $mb);
$mb = str_replace("<com_add>", $com_add, $mb);
$mb = str_replace("<com_tel>", $com_tel, $mb);
$mb = str_replace("<com_fax>", $com_fax, $mb);


$mb = html_entity_decode($mb, ENT_QUOTES, 'UTF-8');


mb_language('uni');
mb_internal_encoding("UTF-8");

// メール送信
mb_send_mail($com_email, $mt, $mb, createMailHeader($_POST['email'], "注文控え"));
mb_send_mail($_POST['email'], $mt, $mb, createMailHeader($com_email, $site_name));

// オーダーデータ格納
$order = [
    "date_order" => $date_today,
    "order_number" => $_SESSION['order_number'],
    "name" => $_POST['name'],
    "zip" => $_POST['zip'],
    "add01" => $_POST['add01'],
    "add02" => $_POST['add02'],
    "add03" => $_POST['add03'],
    "tel" => $_POST['tel'],
    "email" => $_POST['email'],
    "deli_name" => $_POST['deli_name'],
    "deli_zip" => $_POST['deli_zip'],
    "deli_add01" => $_POST['deli_add01'],
    "deli_add02" => $_POST['deli_add02'],
    "deli_add03" => $_POST['deli_add03'],
    "deli_tel" => $_POST['deli_tel'],
    "order_list" => $order_list,
    "payment" => $_POST['payment'],
    "des_day" => $_POST['des_day'],
    "des_time" => $_POST['des_time'],
    "cash_fee" => $_POST['cash_fee'],
    "total_deli_fee" => $_POST['total_deli_fee'],
    "total_item" => $_POST['total_item'],
    "total_payment" => $_POST['total_payment'],
    "comments" => $_POST['comments'],
    "st_payment" => $st_payment
];


db_insert("order_data", $order);


header("location:cart_thanks.php");
exit;
