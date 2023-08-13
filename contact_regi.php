<?php
require("./core/config.php");
require("function.php");
checkToken();
get_setting();

// コメントにひらがなが1文字でも含まれるか？
$comments = $_POST['comments'];
if ($comments !== "" && !preg_match('/[ぁ-ん]/u', $comments)) {
    print "error comments";
    exit;
}


foreach ($_POST as $key => $val) {
    $$key = htmlspecialchars($val);
}

// 半角変換
$email = mb_convert_kana($email, "a", "utf-8");
$tel = mb_convert_kana($tel, "a", "utf-8");


// メールテンプレート取得
$sql = "select*from mailtemp where call_code='contact' limit 1";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);


// メールタイトル
$ttl = $row['mail_title'];
$ttl = str_replace("<site_name>", $site_name, $ttl);

// メール本文
$mb = $row['mail_body'];
$mb = str_replace("<company>", $company, $mb);
$mb = str_replace("<name>", $name, $mb);
$mb = str_replace("<email>", $email, $mb);
$mb = str_replace("<tel>", $tel, $mb);
$mb = str_replace("<comments>", $comments, $mb);


// フッターテンプレート取得
$sql = "select*from mailtemp where call_code='footer' limit 1";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$footer = $row['mail_body'];
$footer = str_replace("<site_name>", $site_name, $footer);
$footer = str_replace("<site_url>", $site_url, $footer);
$footer = str_replace("<com_name>", $com_name, $footer);
$footer = str_replace("<com_zip>", $com_zip, $footer);
$footer = str_replace("<com_add>", $com_add, $footer);
$footer = str_replace("<com_tel>", $com_tel, $footer);
$footer = str_replace("<com_fax>", $com_fax, $footer);


$mb .= $footer;


$mb = html_entity_decode($mb, ENT_QUOTES, 'UTF-8');
mb_language("uni");
mb_internal_encoding("UTF-8");


@mb_send_mail($com_email, $ttl, $mb, createMailHeader($_POST['email'], $site_name . "お問い合わせ控え"));
@mb_send_mail($_POST['email'], $ttl, $mb, createMailHeader($com_email, $site_name));

$_SESSION['msg'] = "
<p>お問い合わせありがとうございます。</p>
<p>自動返信にてご指定のアドレスへメールをお送りしました。</p>
<p>内容を確認後、3営業日以内にご連絡致します。</p>
";

header("location:./message.html");
exit;
