<?php
require("../core/config.php");
require("login_check.php");

if ($_GET['code']) $code = $_GET['code'];
if ($_GET['table']) $table = $_GET['table'];
if ($_GET['num']) $num = $_GET['num'];

if ($code && $table && $num) {
    $files = glob("../$table/$code*$num*");
    foreach ($files as $file) {
        unlink($file);
    }
}


if ($_GET['img']) $img = $_GET['img'];
if ($img) {
    unlink($img);
}

if ($table && $code) {
    header("location:./{$table}_form.php?code=$code");
} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}

exit;
