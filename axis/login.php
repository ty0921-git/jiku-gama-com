<?php
require("../core/config.php");
require("function.php");

$token = filter_input(INPUT_POST, 'csrf_token');
// トークンがない、もしくはトークンが一致しない場合、処理を中止
if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
  exit('不正なリクエストです。');
}
unset($_SESSION['csrf_token']);


foreach ($_POST as $key => $val) {
  $$key = h($val);
}



$sql = "select*from administrator where id='$id'";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!empty($row['id'])) {
  if (password_verify($password, $row['password'])) {
    $_SESSION['user_id'] = $row['id'];
    header("location:./main.php");
  } else {
    $_SESSION['message'] = "ID・パスワードが一致しません";
    header("location:./message.php");
    exit;
  }
}
