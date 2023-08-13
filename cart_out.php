<?php
session_start();
$num=$_GET['num'];
unset($_SESSION['cart'][$num]);
$_SESSION['cart']=array_merge($_SESSION['cart']);

header("location:cart01.php");
exit;
?>