<?php
require("../core/config.php");
require("login_check.php");
require("function.php");


// $token = $_POST['csrf_token'];

// // トークンがない、もしくはトークンが一致しない場合、処理を中止
// if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
//     exit('不正なリクエストです。');
// }
// unset($_SESSION['csrf_token']);
// unset($_POST['csrf_token']);

// 送信先の取得
if ($_POST['test'] == 1) {
    $addresses = [
        [
            "con_name" => "テスト株式会社",
            "con_pic" => "テスト太郎",
            "con_email" => $_POST['test_email'],
            "con_web" => "https://xxxxxxx.com"
        ]
    ];
    $_SESSION['test_email'] = $_POST['test_email'];
} else {
    if (!empty($_POST['cate_code'])) {
        $where = "";
        foreach ($_POST['cate_code'] as $catecode) {
            if (!empty($where)) {
                $where .= " or ";
            }
            $where .= "cc.cate_code='$catecode'";
        }

        $sql = "select * from chain_category as cc inner join contact as c on cc.sj_code=c.code where $where and cc.allocation='contact'";
        $stmt = connect()->query($sql);
        $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['message'] = "送信先を選択してください。";
        header("location:./message.php");
        exit;
    }
}



// 送信元設定
$sender_name = str_replace(array("\r\n", "\r", "\n"), '', $_POST['sender_name']);
$sender = str_replace(array("\r\n", "\r", "\n"), '', $_POST['sender']);


$mb = html_entity_decode($mb, ENT_QUOTES, 'UTF-8');
mb_language("uni");
mb_internal_encoding("UTF-8");



// 送信処理
foreach ($addresses as $address) {

    print_r($address);

    // メールタイトルの生成
    if (!empty($address['con_pic'])) {
        $add_name = $address['con_name'] . "\n" . $address['con_pic'];
    } else {
        $add_name = $address['con_name'];
    }
    $mt = $_POST['mail_title'];
    $mt = str_replace("<con_name>", $add_name, $mt);

    // メール本文の生成
    $mb = $_POST['mail_body'];
    $mb = str_replace("<con_name>", $add_name, $mb);
    $mb = str_replace("<con_web>", $address['con_web'], $mb);

    // メールヘッダー生成
    $headers = [
        "MIME-Version" => "1.0",
        "Content-Transfer-Encoding" => "7bit",
        "Content-Type" => "text/plain; charset=UTF-8",
        "Return-Path" => $sender,
        "From" => mb_encode_mimeheader($sender_name) . " <$sender>",
        "Sender" => mb_encode_mimeheader($sender_name) . " <$sender>",
        "Reply-To" => $sender,
        "Organization" => $_SERVER['HTTP_HOST'],
        "X-Sender" => $sender,
        "X-Mailer" => "AXIS",
        "X-Priority" => "3",
    ];
    array_walk($headers, function ($_val, $_key) use (&$header_str) {
        $header_str .= sprintf("%s: %s \r\n", trim($_key), trim($_val));
    });

    @mb_send_mail($address['con_email'], $mt, $mb, $header_str);
}

if ($_POST['test'] != "1") {
    // メールタイトルの生成
    $mt = "[送信控え] - " . $_POST['mail_title'];
    $mt = str_replace("<con_name>", $sender_name, $mt);

    // メール本文の生成
    $mb = $_POST['mail_body'];
    $mb = str_replace("<con_name>", $sender_name, $mb);
    $mb = str_replace("<con_web>", "https://xxxxxxxxxxx.com", $mb);
    @mb_send_mail($sender, $mt, $mb, "From:$sender");
}

$_SESSION['message'] = "
<p>メール送信が完了いたしました。</p>
";



header("location:./message.html");
exit;
