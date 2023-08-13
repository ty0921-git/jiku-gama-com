<?php
require("core/config.php");
$date_today = date("Y-m-d");


/**
 * データベース接続
 * @return object $pdo
 */
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
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        echo '接続失敗' . $e->getMessage();
        exit();
    }
}


/**
 * 基本情報を取得する
 */
function get_setting()
{
    $sql = "select*from setting";
    $stmt = connect()->query($sql);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);

    foreach ($settings as $key => $val) {
        global $$key;
        $$key = h($val);
    }
}


/**
 * ヘッダー用のCDN記述を取得
 * @return string $cdn['cdn_header']
 */
function get_cdn_header()
{
    $sql = "select*from setting_cdn";
    $stmt = connect()->query($sql);
    $cdn = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cdn) {
        return $cdn['cdn_header'];
    }
}


/**
 * フッター用のCDN記述を取得
 * @return string $cdn['cdn_footer']
 */
function get_cdn_footer()
{
    $sql = "select*from setting_cdn";
    $stmt = connect()->query($sql);
    $cdn = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cdn) {
        return $cdn['cdn_footer'];
    }
}


/**
 * 0埋め
 * @param string,int $code
 * @param int $digit //桁数
 *
 * @return string $val
 */
function zerop($code, $digit)
{
    $val = str_pad($code, $digit, "0", STR_PAD_LEFT);
    return $val;
}


/**
 * データベースへのデータ保存
 * @param string $table // 保存先テーブル名
 * @param array $array // 保存データ
 *
 * @return void
 */
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


/**
 * データベースのデータ更新
 * @param string $table // 更新先テーブル名
 * @param array $array // 更新データ
 * @param string $where // 更新先指定条件
 *
 * @return void
 */
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
 * CSRF対策 - トークンを発行
 * @param void
 * @return string $csrf_token
 */
function setToken()
{
    // トークンを生成
    // フォームからそのトークンを送信
    // 送信後の画面でそのトークンを照会
    // トークンを削除

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
        $_SESSION['msg'] = "不正なリクエストです。";
        header("location:./message.html");
        exit;
    }
    unset($_SESSION['csrf_token']); // 多重リクエスト対策
}






/**
 * 画像の存在を確認し、存在したらリンク付きのHTMLを出力
 * @param string $folder // 画像が保存されているフォルダ名
 * @param string $code // 画像コード
 * @param string $size // 画像サイズ [ sm md lg ]
 * @param string $num // 画像ナンバー
 * @param string $link // リンク先
 *
 * @return void
 */
function get_image($folder, $code, $size, $num, $link)
{
    $exts = array(".jpg", ".jpeg", ".png", ".gif", ".webp");
    foreach ($exts as $ext) {
        $img = "./$folder/{$code}_{$size}_{$num}{$ext}";
        if (file_exists($img)) {
            if (strpos($link, "http")) {
                $blank = " target=\"_blank\"";
            } else {
                $blank = "";
            }
            if ($link) {
                print "<a href=\"$link\"$blank>";
            }
            print "<img src=\"$img\" class=\"img-fluid mb-3\">";
            if ($link) {
                print "</a>";
            }
        }
    }
}

/**
 * 画像があれば、画像のパスを返し、$alt=trueで代替画像を返す
 * @param string $folder // 画像のフォルダ
 * @param string $filename // ファイル名
 * @param bool $alt // 画像がない場合の代替画像の有無
 *
 * @return string $img // 画像のパス
 */
function imageCheck($folder, $filename, $alt)
{
    $exts = array(".gif", ".jpeg", ".png", ".jpg", ".svg", ".webp");
    foreach ($exts as $ext) {
        $img = "./$folder/{$filename}{$ext}";
        if (file_exists($img)) {
            return $img;
        }
    }
    if ($alt == true) {
        $img = "image/no-image.svg";
        return $img;
    }

    return false;
}


/**
 * 税込価格の計算
 * @param int $val // 価格
 * @param float $tax // 掛け数
 *
 * @return float $val*$tax
 */
function taxin($val, $tax = 1.1)
{
    if ($val) {
        return $val * $tax;
    }
}


/**
 * 数値のフォーマット（3桁カンマ区切り）
 * @param int $val
 * @return string $val
 */
function d($val)
{
    return number_format($val, 0, '.', ',');
}


/**
 * コード指定レコードデータを1行取得
 * @param string $table
 * @param string $code
 * @return array $row
 */
function get_row($table, $code)
{
    $sql = "select*from $table where code=$code";
    $stmt = connect()->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}


/**
 * コード指定の前のレコードデータを1行取得
 * @param string $table
 * @param string $code
 * @param string $tail
 * @return array $row
 */
function getPrevRow($table, $code, $tail = null)
{
    $sql = "select*from $table where display=1 and code < $code $tail order by code DESC limit 1";
    $stmt = connect()->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}


/**
 * コード指定の次のレコードデータを1行取得
 * @param string $table
 * @param string $code
 * @param string $tail
 * @return array $row
 */
function getNextRow($table, $code, $tail = null)
{
    $sql = "select*from $table where display=1 and code > $code $tail order by code ASC limit 1";
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
        $sql = "select*from $table where display='1' $tails";
    } else {
        $sql = "select * from category,chain_category as chain,$table where chain.allocation='$table' and category.call_code='$call_code' and category.code=chain.cate_code and chain.sj_code=$table.code and $table.display='1' $tails";
    }
    $stmt = connect()->query($sql);
    return $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * カテゴリーコールコードを使ったデータの件数取得
 * @param string $table // 呼び出し先テーブル名
 * @param string $call_code // カテゴリーコールコード
 * @param string $tails // 絞り込みSQL
 *
 * @return int $cnt // データ数
 */
function get_rows_cnt($table, $call_code, $tails)
{
    if ($call_code === null) {
        $sql = "select*from $table where display='1' $tails";
    } else {
        $sql = "select * from category,chain_category as chain,$table where category.call_code='$call_code' and category.code=chain.cate_code and chain.sj_code=$table.code and $table.display='1' $tails";
    }
    $stmt = connect()->query($sql);
    return $cnt = $stmt->rowCount();
}



/**
 * アロケーションに該当するカテゴリーのリストを取得
 * @param string $allocation // アロケーション
 * @return array $cate_list // カテゴリーリスト
 */
function getCategoryList($allocation)
{
    // カテゴリーリスト生成
    $sql = "select*from category where allocation='$allocation'";
    $stmt = connect()->query($sql);
    $cates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $cate_list = array();
    foreach ($cates as $cate) {
        $cate_list[$cate['call_code']] = $cate['cate_name'];
    }
    return $cate_list;
}



/**
 * データがもつカテゴリーコールコードを取得
 * @param string $sj_code // データコード
 * @param string $allocation // アロケーション
 * @return array $cate_codes // コールコード配列
 */
function getChainCode($sj_code, $allocation)
{
    $sql = "select call_code from chain_category as cc,category as c where cc.sj_code=? and c.allocation=? and cc.cate_code=c.code";
    $stmt = connect()->prepare($sql);
    $stmt->bindValue(1, $sj_code, PDO::PARAM_STR);
    $stmt->bindValue(2, $allocation, PDO::PARAM_STR);
    $stmt->execute();

    $cate_codes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $cate_codes;
}



/**
 * 文字列を特定の長さに調整
 * @param string $article // 文章データ
 * @param int $num // 切り取る文字数
 * @return string $article // 整形された文章データ
 */
function abb($article, $num)
{
    $article = strip_tags($article);
    $article = mb_substr($article, 0, $num, "UTF-8") . " ...";
    return $article;
}



/**
 * メール送信用のヘッダーを生成
 * @param string $sender // 送信者メールアドレス
 * @param string $sender_name // 送信者名
 * @return string $header_str // メールヘッダー
 */
function createMailHeader($sender, $sender_name)
{
    $header_str = "";
    $from = mb_encode_mimeheader($sender_name) . " <" . $sender . ">";
    $from_name = mb_encode_mimeheader($sender_name);

    $header_str = "";
    $header_str .= "MIME-Version:1.0\r\n";
    $header_str .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $header_str .= "Return-Path: " . $sender . " \r\n";
    $header_str .= "From: " . $from . " \r\n";
    $header_str .= "Sender: " . $from . " \r\n";
    $header_str .= "Reply-To: " . $sender . " \r\n";
    $header_str .= "Organization: " . $from_name . " \r\n";
    $header_str .= "X-Sender: " . $sender . " \r\n";
    $header_str .= "X-Priority: 3 \r\n";

    return $header_str;
}


function getDayOfWeek($day)
{
    $datetime = new DateTime($day);
    $week = array("SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT");
    $w = (int)$datetime->format('w');
    return $week[$w];
}
