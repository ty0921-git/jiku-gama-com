<?php
require("../core/config.php");
require("login_check.php");
require("function.php");

if ($_GET['code']) {
    $code = $_GET['code'];
} else {
    exit;
}
if ($_GET['key']) {
    $key = $_GET['key'];
} else {
    exit;
}
if ($_GET['call_code']) {
    $call_code = $_GET['call_code'];
} else {
    exit;
}


$sql = "delete from category where code={$code} and allocation='{$key}'";
$stmt = connect()->query($sql);
$stmt->execute();

$table_set = allo_switch($key);
$table = $table_set['table'];
$column = $table_set['column'];

// $sql = "select*from $table where $column regexp '(<>|^){$call_code}<>'";
// $stmt = connect()->query($sql);
// $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// foreach ($rows as $row) {
//     $cate_code = preg_replace("/(<>|^)$call_code<>/u", "", $row[$column]);
//     $sql = "update $table set $column='$cate_code' where code='$row[code]'";
//     connect()->query($sql);
// }

header("location:./category_form.php?key={$key}");
exit;
