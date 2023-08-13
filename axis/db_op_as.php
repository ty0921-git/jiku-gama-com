<?php
// ini_set('display_errors', "On");
require("function.php");
require("login_check.php");

checkToken();
unset($_POST['csrf_token']);

if (isset($_FILES)) {
    if (!$folder = filter_input(INPUT_POST, 'folder')) err('フォルダーの指定がありません');
    if (!simpleUpload($folder)) err("ファイルのアップロード失敗しました。");
}

unset($_POST['folder']);


// 処理後の移動先指定
if ($_POST['next_location']) {
    $next_location = $_POST['next_location'];
    unset($_POST['next_location']);
} else {
    $next_location = $_SERVER['HTTP_REFERER'];
}


if (isset($_POST) && $table = filter_input(INPUT_POST, 'table')) {
    unset($_POST['table']);
    $_POST['code'] ? db_update($table, $_POST, "code=$_POST[code]") : db_insert($table, $_POST);
}


header("location:$next_location");
$dbh = null;
exit;
