<?php
require("../core/config.php");
require("login_check.php");
require("function.php");

$sql = "select*from mailtemp where call_code='$_GET[call_code]'";
$stmt = connect()->query($sql);
$temp = $stmt->fetch(PDO::FETCH_ASSOC);

$data = [
    "mail_title" => $temp['mail_title'],
    "mail_body" => $temp['mail_body'],
    "call_code" => $_GET['call_code']
];


header('Content-type: application/json');
echo json_encode($data);

exit;
