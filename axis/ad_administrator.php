<?php
require("../function.php");
// セットアップ設定
$admin_id = "";
$admin_pass = "";

// 初期ユーザー登録
$admin_pass = password_hash($admin_pass, PASSWORD_DEFAULT);
$sql = "insert into administrator set id='$admin_id',password='$admin_pass'";
connect()->query($sql);

print "登録完了";
