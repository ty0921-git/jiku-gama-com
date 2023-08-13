<?php
require("../core/config.php");
require("login_check.php");
require("function.php");



$array=[$_GET['col']=>$_GET['val']];
db_update("order_data", $array, $dbh, "code=$_GET[code]");


// 配送完了メールの送信
if($_GET['col']=="tracking" && $_GET['code']){

// オーダーデータ取得
$sql="select*from order_data where code='$_GET[code]'";
$stmt=connect()->query($sql);
$order=$stmt->fetch(PDO::FETCH_ASSOC);

// メールタイトル・本文テンプレート取得
$sql="select*from mailtemp where call_code='product_shipping'";
$stmt=connect()->query($sql);
$temp=$stmt->fetch(PDO::FETCH_ASSOC);

// フッターテンプレート呼び出し
$sql = "select*from mailtemp where call_code='footer'";
$stmt = connect()->query($sql);
$footer = $stmt->fetch(PDO::FETCH_ASSOC);

$mt=$temp['mail_title'];
$mb=$temp['mail_body'].$footer['mail_body'];



// 基本設定データベースよりデータ取得
$sql = "select*from setting";
$stmt = connect()->query($sql);
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

foreach ($settings as $key => $val) {
    $$key = $val;
}




 // 変数置き換え
$mb = str_replace("<name>", $order['name'], $mb);
$mb = str_replace("<deli_name>", $order['deli_name'], $mb);
$mb = str_replace("<deli_zip>", $order['deli_zip'], $mb);
$mb = str_replace("<deli_add01>", $order['deli_add01'], $mb);
$mb = str_replace("<deli_add02>", $order['deli_add02'], $mb);
$mb = str_replace("<deli_add03>", $order['deli_add03'], $mb);
$mb = str_replace("<tracking>", $order['tracking'], $mb);
$mb = str_replace("<site_name>", $site_name, $mb);
$mb = str_replace("<site_url>", $site_url, $mb);
$mb = str_replace("<com_name>", $com_name, $mb);
$mb = str_replace("<com_zip>", $com_zip, $mb);
$mb = str_replace("<com_add>", $com_add, $mb);
$mb = str_replace("<com_tel>", $com_tel, $mb);
$mb = str_replace("<com_fax>", $com_fax, $mb);


$mb = html_entity_decode($mb, ENT_QUOTES, 'UTF-8');
mb_language("uni");
mb_internal_encoding("UTF-8");

// メール送信
@mb_send_mail($order['email'], $mt, $mb, "From:$com_email");
}


exit;
