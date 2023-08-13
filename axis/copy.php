<?php
require("../core/config.php");
require("login_check.php");
require("function.php");

if ($_GET['code']) {
  $code = $_GET['code'];
} else {
  exit;
}

if ($_GET['table']) {
  $table = $_GET['table'];
} else {
  exit;
}


// データ取得
$sql = "select*from $table where code='$code'";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// データ挿入
$today = date("Y-m-d");
unset($row['code']);
unset($row['date_update']);
$row['date_regi'] = $today;

db_insert($table, $row, $dbh);

// $files = glob("../$table/$code*");
// foreach ($files as $file) {
//   unlink($file);
// }

header("location:./{$table}_list.php");
exit;
