<?php
ini_set('display_errors', "On");
require("../core/config.php");
require("login_check.php");
require("function.php");

checkToken();
unset($_POST['csrf_token']);

// カテゴリーコードの受取
if (!empty($_POST['cate_code'])) {
    $cate_codes = $_POST['cate_code'];
    unset($_POST['cate_code']);
}
if (!empty($_POST['collection_code'])) {
    $collection_codes = $_POST['collection_code'];
    unset($_POST['collection_code']);
}
if (!empty($_POST['temp_code'])) {
    $temp_codes = $_POST['temp_code'];
    unset($_POST['temp_code']);
}
if (!empty($_POST['facility_code'])) {
    $facility_codes = $_POST['facility_code'];
    unset($_POST['facility_code']);
}



// GAMEテーブルのみの処理
if ($_POST['table'] == "game") {
    if ($_POST['detail_set']) {
        $_POST['game_score_details'] = "";
        for ($i = 0; $i < sizeof($_POST['detail_set']); $i++) {
            $_POST['game_score_details'] .= $_POST['detail_team_label'][$i] . "<>" . $_POST['detail_team_score'][$i] . "<>" . $_POST['detail_set'][$i] . "<>" . $_POST['detail_opponent_score'][$i] . "<>" . $_POST['detail_opponent_label'][$i] . "\n";
        }
    }
    unset($_POST['detail_team_label']);
    unset($_POST['detail_team_score']);
    unset($_POST['detail_set']);
    unset($_POST['detail_opponent_score']);
    unset($_POST['detail_opponent_label']);

    if (isset($_FILES['logo_opponent'])) {
        if (!$folder = filter_input(INPUT_POST, 'folder')) err('フォルダーの指定がありません');
    }
    unset($_POST['folder']);
}




// SHOP設定のみの処理
if ($_POST['table'] == "setting_shop") {
    $des_time = "";
    foreach ($_POST['des_time'] as $data) {
        $des_time .= $data . "<>";
    }
    $_POST['des_time'] = $des_time;
}


// CATEGORYテーブルのみの処理
if ($_POST['table'] == "category" && isset($_POST['code'])) {
    // 同じallocationに同一名のコールコードを生成しない
    $sql = "select*from category where (call_code='$_POST[call_code]' and allocation='$_POST[allocation]') && code!='$_POST[code]'";
    $stmt = connect()->query($sql);
    $cnt = $stmt->rowCount();

    if ($cnt > 0) err("すでに存在しているカテゴリーです。");
    unset($_POST['call_code_ex']);
}




// STAFFテーブルのみの処理
if ($_POST['table'] == "staff") {

    if (!empty($_POST['staff_birth_y']) && !empty($_POST['staff_birth_m']) && !empty($_POST['staff_birth_d'])) {
        $_POST['staff_birth_day'] = $_POST['staff_birth_y'] . "-" . $_POST['staff_birth_m'] . "-" . $_POST['staff_birth_d'];
    } else {
        $_POST['staff_birth_day'] = "";
    }

    unset($_POST['staff_birth_y']);
    unset($_POST['staff_birth_m']);
    unset($_POST['staff_birth_d']);
}



// ITEMテーブルのみの処理
if ($_POST['table'] == "item") {

    // 価格データの整形
    if (isset($_POST['price'])) {
        $price_lavel_data = $_POST['price_lavel'];
        $price_data = $_POST['price'];
        unset($_POST['price_lavel']);
        $_POST['price'] = "";
        for ($i = 0; $i < sizeof($price_data); $i++) {
            $_POST['price'] .= "$price_lavel_data[$i]<>$price_data[$i]\n";
        }
    }

    // メーカー
    if (!empty($_POST['maker'])) {
        $sql = "select*from category where cate_name='$_POST[maker]' and allocation='maker'";
        $stmt = connect()->query($sql);
        $cnt = $stmt->rowCount();
        if ($cnt == 0) {
            $sql = "insert into category set cate_name=?,allocation='maker'";
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(1, $_POST['maker'], PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    // ブランド
    if (!empty($_POST['brand'])) {
        $sql = "select*from category where cate_name='$_POST[brand]' and allocation='brand'";
        $stmt = connect()->query($sql);
        $cnt = $stmt->rowCount();
        if ($cnt == 0) {
            $sql = "insert into category set cate_name=?,allocation='brand'";
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(1, $_POST['brand'], PDO::PARAM_STR);
            $stmt->execute();
        }
    }
}


// タグデータの取得
if (isset($_POST['tag'])) {
    $tags = explode(",", $_POST['tag']);
    $table = $_POST['table'];
    for ($i = 0; $i < sizeof($tags); $i++) {
        $sql = "insert into tag(allocation,tag) select ?,? from dual where not exists(select*from tag where allocation=? and tag=?)";
        $stmt = connect()->prepare($sql);
        $stmt->bindValue(1, $table, PDO::PARAM_STR);
        $stmt->bindValue(2, $tags[$i], PDO::PARAM_STR);
        $stmt->bindValue(3, $table, PDO::PARAM_STR);
        $stmt->bindValue(4, $tags[$i], PDO::PARAM_STR);
        $stmt->execute();
    }
}


// 操作テーブルの取得とPOSTデータの調整
if (empty($_POST['table'])) {
    err("テーブル指定がありません。");
} else {
    $table = $_POST['table'];
    unset($_POST['table']);
}


// 処理後の移動先指定
if (isset($_POST['next_location'])) {
    $next_location = $_POST['next_location'];
    unset($_POST['next_location']);
} else {
    $next_location = $_SERVER['HTTP_REFERER'];
}



//コード取得
if (isset($_POST['code'])) {
    $code = h($_POST['code']);
}

if (empty($code)) {
    db_insert($table, $_POST);

    $sql = "select code from $table order by code DESC limit 1";
    $stmt = connect()->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $code = zerop($row['code'], 7);
} else {
    db_update($table, $_POST, "code=$code");

    // カテゴリーデータを削除
    $sql = "delete from chain_category where allocation=? and sj_code=?";
    $stmt = connect()->prepare($sql);
    $stmt->bindValue(1, $table);
    $stmt->bindValue(2, $code);
    $stmt->execute();
}


// カテゴリーデータ登録
if (!empty($cate_codes)) {
    foreach ($cate_codes as $cate_code) {
        $sql = "insert into chain_category set cate_code=?,allocation=?,sj_code=?";
        $stmt = connect()->prepare($sql);
        $stmt->bindValue(1, $cate_code);
        $stmt->bindValue(2, $table);
        $stmt->bindValue(3, $code);
        $stmt->execute();
    }
}

if (!empty($collection_codes)) {
    foreach ($collection_codes as $cate_code) {
        $sql = "insert into chain_category set cate_code=?,allocation=?,sj_code=?";
        $stmt = connect()->prepare($sql);
        $stmt->bindValue(1, $cate_code);
        $stmt->bindValue(2, $table);
        $stmt->bindValue(3, $code);
        $stmt->execute();
    }
}

if (!empty($temp_codes)) {
    foreach ($temp_codes as $cate_code) {
        $sql = "insert into chain_category set cate_code=?,allocation=?,sj_code=?";
        $stmt = connect()->prepare($sql);
        $stmt->bindValue(1, $cate_code);
        $stmt->bindValue(2, $table);
        $stmt->bindValue(3, $code);
        $stmt->execute();
    }
}

if (!empty($facility_codes)) {
    foreach ($facility_codes as $cate_code) {
        $sql = "insert into chain_category set cate_code=?,allocation=?,sj_code=?";
        $stmt = connect()->prepare($sql);
        $stmt->bindValue(1, $cate_code);
        $stmt->bindValue(2, $table);
        $stmt->bindValue(3, $code);
        $stmt->execute();
    }
}




// 画像ファイル
if (isset($_FILES['logo_opponent']['tmp_name'])) {
    singleupload($folder, "logo_opponent", "{$code}_logo_opponent");
}



for ($i = 1; $i <= 20; $i++) {

    $num = zerop($i, 2);
    $file = "file" . $num;
    if (!empty($_FILES[$file]['tmp_name'])) {

        if (!$ext = getFileExt($_FILES[$file])) {
            err("不正なイメージです。");
        }

        $size_sets = [
            ["size_name" => "sm", "width" => 200, "height" => 200],
            ["size_name" => "md", "width" => 500, "height" => 500],
            ["size_name" => "lg", "width" => 1000, "height" => 1000],
        ];

        foreach ($size_sets as $size_set) {
            $size_name = $size_set['size_name'];
            $max_width = $size_set['width'];
            $max_height = $size_set['height'];

            $size = @getimagesize($_FILES[$file]['tmp_name']);
            $resize = $size;

            $magni_width = $size[0] / $max_width;
            $magni_height = $size[1] / $max_height;
            if ($magni_width > 1 || $magni_height > 1) {
                if ($magni_width > $magni_height) {
                    $resize[0] = $max_width;
                    $resize[1] = $size[1] * $max_width / $size[0];
                } else {
                    $resize[0] = $size[0] * $max_height / $size[1];
                    $resize[1] = $max_height;
                }
            }
            $new_image = imagecreatetruecolor($resize[0], $resize[1]);

            if ($size[2] == 1) {
                $default_image = imagecreatefromgif($_FILES[$file]['tmp_name']);
            } elseif ($size[2] == 2) {
                $default_image = imagecreatefromjpeg($_FILES[$file]['tmp_name']);
            } elseif ($size[2] == 3) {
                $default_image = imagecreatefrompng($_FILES[$file]['tmp_name']);
            } elseif ($size[2] == 18) {
                $default_image = imagecreatefromwebp($_FILES[$file]['tmp_name']);
            }

            //透過処理
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);

            imagecopyresampled($new_image, $default_image, 0, 0, 0, 0, $resize[0], $resize[1], $size[0], $size[1]);

            //前回画像があれば削除
            $ests = array("gif", "jpg", "png", "svg", "webp");
            foreach ($ests as $est) {
                if (file_exists("../$table/" . $code . "_{$size_name}_{$num}.{$est}")) {
                    unlink("../$table/" . $code . "_{$size_name}_{$num}.{$est}");
                };
            }

            if ($size[2] == 1) {
                imagegif($new_image, "../$table/" . $code . "_{$size_name}_{$num}.gif");
            } elseif ($size[2] == 2) {
                imagejpeg($new_image, "../$table/" . $code . "_{$size_name}_{$num}.jpg", 90);
            } elseif ($size[2] == 3) {
                imagepng($new_image, "../$table/" . $code . "_{$size_name}_{$num}.png");
            } elseif ($size[2] == 18) {
                imagewebp($new_image, "../$table/" . $code . "_{$size_name}_{$num}.webp");
            }

            imagedestroy($new_image);
            imagedestroy($default_image);
        }
    } else {
        continue;
    }
}



header("location:$next_location");
$dbh = null;
exit;
