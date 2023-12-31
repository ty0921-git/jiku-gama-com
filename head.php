<?php
require("function.php");
get_setting();
?>
<!DOCTYPE html>
<html lang="ja" prefix="og: https://ogp.me/ns#">
<?php
require_once('head_ogp.php');
?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
$favicon = "./image/favicon.svg";
if (file_exists($favicon)) :
?>
  <link rel="shortcut icon" href="<?= $favicon ?>">
  <link rel="apple-touch-icon" href="<?= $favicon ?>">
<?php endif; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?= get_cdn_header() ?>

<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/style.min.css">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@300&display=swap" rel="stylesheet">
<?= PHP_EOL ?>

<?php
$num = [56, 70, 45, 21, 74, 79, 58, 66, 55, 47, 48, 23, 6, 4, 75, 65, 42, 62, 54, 24, 60, 61, 71, 67, 31, 36, 29, 32, 72, 76, 50, 77, 49, 20, 80];
?>
