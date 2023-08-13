<?php
if(empty($_SESSION['user_id']) && $login_check!="off"){
    $_SESSION['message']="ログインが必要です。";
    header("location:message.php");
    exit;
}else{
    session_regenerate_id(true);
    return;
}
?>