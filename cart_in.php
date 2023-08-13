<?php
session_start();
if (!$_POST['price']) {
    header("location:cart01.php");
    exit;
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
$_SESSION['cart'][] = "$_POST[code]<>$_POST[item_name]<>$_POST[price]<>$_POST[qty]<>$_POST[delivary]<>$_POST[flag_include]<>$_POST[delivary_group]<>";

header("location:cart01.php");
exit;
