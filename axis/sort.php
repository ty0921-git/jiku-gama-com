<?php
require("../core/config.php");
require("login_check.php");
require("function.php");


// 操作テーブルの取得とPOSTデータの調整
if (empty($_POST['table'])) {
    $_SESSION['message'] = "テーブル指定がありません。";
    header("location:./message.php");
    exit;
}else{
    $table=$_POST['table'];
}

$code=$_POST['code'];
$sort=$_POST['sort'];

for($i=0;$i<sizeof($code);$i++){
    $sql="update $table set sort='$sort[$i]' where code='$code[$i]'";
    $stmt=connect()->query($sql);
    $stmt->execute();
}



header("location:$_SERVER[HTTP_REFERER]");
$dbh = null;
exit;
