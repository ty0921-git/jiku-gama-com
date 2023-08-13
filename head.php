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
<link rel="stylesheet" href="css/style.min.css?d=<?= date("is") ?>">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<?= PHP_EOL ?>
