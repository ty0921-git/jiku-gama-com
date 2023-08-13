<?php
require("../core/config.php");
require("function.php");
require("login_check.php");

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


$files = glob("../$table/$code*");
foreach ($files as $file) {
    unlink($file);
}

$sql = "delete from {$table} where code={$code}";
$stmt = connect()->query($sql);
$stmt->execute();

header("location:./{$table}_list.php");
exit;
