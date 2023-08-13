<?php
require_once '../core/config.php';
function connect()
{
    $host = DB_HOST;
    $db = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode='ALLOW_INVALID_DATES'"
        ]);
        return $pdo;
    } catch (PDOException $e) {
        echo '接続失敗' . $e->getMessage();
        exit();
    }
}


function db_insert($table, $array)
{

    $src = "";
    foreach ($array as $key => $val) {
        $src .= "$key=?,";
    }
    $src = rtrim($src, ",");


    $sql = "insert into $table set $src";

    $stmt = connect()->prepare($sql);
    $i = 1;
    foreach ($array as $key => $val) {
        $stmt->bindValue($i, $val, PDO::PARAM_STR);
        $i++;
    }
    $stmt->execute();
}

function db_update($table, $array, $where)
{

    $src = "";
    foreach ($array as $key => $val) {
        $src .= "$key=?,";
    }
    $src = rtrim($src, ",");


    $sql = "update $table set $src where $where";

    $stmt = connect()->prepare($sql);
    $i = 1;
    foreach ($array as $key => $val) {
        $stmt->bindValue($i, $val, PDO::PARAM_STR);
        $i++;
    }
    $stmt->execute();
}


function allo_switch($allo)
{
    switch ($allo) {
        case "colle":
            $table_set = ["table" => "item", "column" => "colletion_code"];
            break;
        case "temp":
            $table_set = ["table" => "item", "column" => "temp_code"];
            break;
        case "facility":
            $table_set = ["table" => "spot", "column" => "facility_code"];
            break;
        default:
            $table_set = ["table" => $allo, "column" => "cate_code"];
    }
    return $table_set;
}



function zerop($code, $digit)
{
    $val = str_pad($code, $digit, "0", STR_PAD_LEFT);
    return $val;
}


function d($val)
{
    return number_format($val);
}

/**
 * XSS対策:エスケープ処理
 * @param string $str 対象の文字列
 * @return string 処理された文字列
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


/**
 * CSRF対策
 * @param void
 * @return string $csrf_token
 */
function setToken()
{

    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;

    return $csrf_token;
}


/**
 * CSRF対策 - トークンチェック
 * @param void
 * @return void
 */
function checkToken()
{
    $token = filter_input(INPUT_POST, 'csrf_token');
    // トークンがない、もしくはトークンが一致しない場合、処理を中止
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        $_SESSION['message'] = "不正なリクエストです。";
        header("location:./message.html");
        exit;
    }
    unset($_SESSION['csrf_token']); // 多重リクエスト対策
}


function get_category($table)
{
    $sql = "select*from category where allocation='$table' order by sort ASC";
    $stmt = connect()->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}


function get_row($table, $code)
{
    $sql = "select*from $table where code=$code";
    $stmt = connect()->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}


/**
 * カテゴリーコールコードを使ったデータの呼び出し
 * @param string $table // 呼び出し先テーブル名
 * @param string $call_code // カテゴリーコールコード
 * @param string $tails // 絞り込みSQL
 *
 * @return array $rows // 呼び出しデータ
 */
function get_rows($table, $call_code, $tails)
{
    if ($call_code === null) {
        $sql = "select*from $table where code!='' $tails";
    } else {
        $sql = "select * from category,chain_category as chain,$table where category.call_code='$call_code' and category.code=chain.cate_code and chain.sj_code=$table.code and $table.display='1' $tails";
    }
    $stmt = connect()->query($sql);
    return $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_chains($table, $code)
{
    // チェインカテゴリー取得
    $sql = "select*from chain_category where allocation='$table' and sj_code='$code'";
    $stmt = connect()->query($sql);
    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $cate_data = [];
    foreach ($datas as $chain) {
        $cate_data[] = $chain['cate_code'];
    }

    return $cate_data;
}



function get_tiny_key()
{
    // tinyMCE API Key 取得
    $sql = "select tiny_api_key from setting_post limit 1";
    $stmt = connect()->query($sql);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);

    return h($settings['tiny_api_key']);
}


function get_call_code($code)
{
    $sql = "select call_code from category where code=?";
    $stmt = connect()->prepare($sql);
    $stmt->bindValue(1, $code);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    return $category['call_code'];
}



function getFileExt($file)
{
    if (!isset($file['error']) || !is_int($file['error'])) {
        return false;
    }
    if ($file['size'] > 15000000) {
        return false;
    }

    if (!$ext = array_search(
        mime_content_type($file['tmp_name']),
        array(
            'gif' => 'image/gif',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'svg' => 'image/svg',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
        ),
        true
    )) {
        return false;
    }

    return $ext;
}



function simpleUpload($folder)
{
    foreach ($_FILES as $key => $val) {
        if ($_FILES[$key]['tmp_name']) {
            if (!$ext = getFileExt($_FILES[$key])) {
                $_SESSION['message'] = "不正なリクエストです。";
                header("location:./message.php");
                exit;
            }
            if (!move_uploaded_file($_FILES[$key]['tmp_name'], "../$folder/$key." . $ext)) {
                return false;
            }
        }
    }
    return true;
}



function singleupload($folder, $file_key, $file_name)
{
    if (!$ext = getFileExt($_FILES[$file_key])) {
        $_SESSION['message'] = "不正なイメージです。";
        header("location:./message.php");
        exit;
    }
    if (move_uploaded_file($_FILES[$file_key]['tmp_name'], "../$folder/$file_name." . $ext)) {
        return true;
    } else {
        return false;
    }
}



function err($str)
{
    $_SESSION['message'] = $str;
    header("location:./message.php");
    exit;
}



function imageCheck($folder, $filename, $alt)
{
    $exts = array(".gif", ".jpeg", ".png", ".jpg", ".svg");
    foreach ($exts as $ext) {
        $img = "$folder/{$filename}{$ext}";
        if (file_exists($img)) {
            return $img;
        }
    }
    if ($alt == true) {
        $img = "../image/no-image.svg";
        return $img;
    }

    return false;
}
