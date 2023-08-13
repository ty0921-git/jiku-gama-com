<?php
require("head.php");

// テーブル指定
$table = "item";

// ゲット変数の無害化処理
$get_code = h(filter_input(INPUT_GET, 'code'));

// カテゴリーデータ取得
$categories = get_category($table);

// コレクションデータ取得
$collections = get_category("colle");

// 温度帯データ取得
$temps = get_category("temp");


// コード指定データ取得
if ($get_code) {
    $row = get_row($table, $get_code);
    $code = zerop($row['code'], 7);
    $delivary = zerop($row['delivary'], 3);

    // コード指定データの登録コールコードを配列に取得
    $cate_data = get_chains($table, $get_code);
} else {
    $row['date_regi'] = date("Y-m-d");
}
?>
<script src="https://cdn.tiny.cloud/1/<?= get_tiny_key() ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <div class="w-100 p-5">
        <section class="container-fluid">

            <form action="db_op.php" method="POST" enctype="multipart/form-data">



                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="base-tab" data-bs-toggle="tab" href="#base" role="tab" aria-controls="base" aria-selected="true">基本情報</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="image-tab" data-bs-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false">アイテム画像</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">詳細情報</a>
                    </li>
                </ul>



                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="base" role="tabpanel" aria-labelledby="base-tab">
                        <div class="row">
                            <div class="col-md-9">

                                <div class="mb-4">
                                    <?php if ($categories) : ?>
                                        <?php foreach ($categories as $category) : $category_code = $category['code']; ?>
                                            <div class="form-check form-check-inline form-switch">
                                                <input class="form-check-input" type="checkbox" id="cate_code" name="cate_code[]" value="<?= h($category_code) ?>" <?php if ($code && in_array($category_code, $cate_data)) print "checked"; ?>>
                                                <label class="form-check-label" for="cate_code"> <?= h($category['cate_name']) ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-4">
                                    <?php if ($collections) : ?>
                                        <?php foreach ($collections as $collection) : $collection_code = $collection['code']; ?>
                                            <div class="form-check form-check-inline form-switch">
                                                <input class="form-check-input" type="checkbox" id="collection_code" name="collection_code[]" value="<?= h($collection_code) ?>" <?php if ($code && in_array($collection_code, $cate_data)) print "checked"; ?>>
                                                <label class="form-check-label" for="collection_code"> <?= h($collection['cate_name']) ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-4">
                                    <?php if ($temps) : ?>
                                        <?php foreach ($temps as $temp) : $temp_code = $temp['code']; ?>
                                            <div class="form-check form-check-inline form-switch">
                                                <input class="form-check-input" type="checkbox" id="temp_code" name="temp_code[]" value="<?= h($temp_code) ?>" <?php if ($code && in_array($temp_code, $cate_data)) print "checked"; ?>>
                                                <label class="form-check-label" for="temp_code"> <?= h($temp['cate_name']) ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <?php
                                        $exts = array(".jpg", ".jpeg", ".png", ".gif", ".webp");
                                        foreach ($exts as $ext) {
                                            $img = "../$table/{$code}_md_01{$ext}";
                                            if (file_exists($img)) {
                                                $img_url = $img . "?c=" . date("Ymdhis");
                                                break;
                                            } else {
                                                $img_url = "";
                                            }
                                        }
                                        ?>
                                        <a class="thumb01" <?php if ($img_url) : ?> style="background-image:url(<?= $img_url ?>);" <?php endif; ?>></a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="item_name" id="item_name" placeholder="#" value="<?= h($row['item_name']) ?>">
                                            <label for="item_name">商品名</label>
                                        </div>


                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="short_description" id="short_description" placeholder="#" style="height:100px;"><?= h($row['short_description']) ?></textarea>
                                            <label for="short_description">簡易説明</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="delivary" name="delivary">
                                                <option value="">選択してください</option>
                                                <?php
                                                $sql = "select*from delivary order by code ASC";
                                                $stmt = connect()->query($sql);
                                                $delis = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($delis as $deli) :
                                                ?>
                                                    <option value="<?= $deli['code'] ?>" <?php if ($delivary == $deli['code']) print "selected"; ?>><?= h($deli['delivary_name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="delivary">配送区分</label>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $price_data = explode("\n", $row['price']);
                                for ($i = 0; $i < sizeof($price_data); $i++) :
                                    if ($price_data[$i] == "" && $i != 0) continue;
                                    list($price_lavel, $price) = explode("<>", $price_data[$i]);
                                ?>
                                    <div id="price_area">
                                        <div class="row" id="price_line">
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="price_lavel[]" id="price_lavel" placeholder="#" value="<?= h($price_lavel) ?>">
                                                    <label for="price_lavel">ラベル</label>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="price[]" id="price" placeholder="#" value="<?= h($price) ?>">
                                                    <label for="price">販売価格（税抜）</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn btn-btn" id="price_add" onclick="price_add(this)"><i class="bi bi-plus"></i></a>
                                                <a class="btn btn-btn" id="price_del" onclick="price_del(this)"><i class="bi bi-dash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="description" id="article" placeholder="#" style="height:500px;"><?= h($row['description']) ?></textarea>
                                    <label for="description">商品説明</label>
                                </div>


                            </div>


                            <div class="col-md-3">

                                <div class="form-floating mb-3">
                                    <input class="form-control" type="text" name="tag" id="tag" placeholder="#" style="height:100px;" value="<?= h($row['tag']) ?>">
                                    <label for="tag" class="label-adj01">タグ</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="item_catch" id="item_catch" placeholder="#" style="height:100px;"><?= h($row['item_catch']) ?></textarea>
                                    <label for="item_catch">キャッチコピー</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" autocomplete="on" list="maker_list" class="form-control" name="maker" id="maker" placeholder="#" value="<?= h($row['maker']) ?>">
                                    <label for="maker">メーカー</label>
                                    <datalist id="maker_list">
                                        <?php
                                        $sql = "select*from category where allocation='maker' order by sort ASC";
                                        $stmt = connect()->query($sql);
                                        $makers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($makers as $maker) :
                                        ?>
                                            <option value="<?= h($maker['cate_name']) ?>"><?= h($maker['cate_name']) ?></option>
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" autocomplete="on" list="brand_list" class="form-control" name="brand" id="brand" placeholder="#" value="<?= h($row['brand']) ?>">
                                    <label for="brand">ブランド</label>
                                    <datalist id="brand_list">
                                        <?php
                                        $sql = "select*from category where allocation='brand' order by sort ASC";
                                        $stmt = connect()->query($sql);
                                        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($brands as $brand) :
                                        ?>
                                            <option value="<?= h($brand['cate_name']) ?>"><?= h($brand['cate_name']) ?></option>
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="product_code" id="product_code" placeholder="#" value="<?= h($row['product_code']) ?>">
                                    <label for="product_code">プロダクトコード</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="jan" id="jan" placeholder="#" value="<?= h($row['jan']) ?>">
                                    <label for="jan">JANコード</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="capa" id="capa" placeholder="#" value="<?= h($row['capa']) ?>">
                                    <label for="capa">内容量</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="weight" id="weight" placeholder="#" value="<?= h($row['weight']) ?>">
                                    <label for="weight">重さ（g）</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="notes" id="notes" placeholder="#" style="height:100px;"><?= h($row['notes']) ?></textarea>
                                    <label for="notes">注意事項</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="memo" id="memo" placeholder="#" style="height:100px;"><?= h($row['memo']) ?></textarea>
                                    <label for="memo">メモ</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control datepicker" name="date_regi" id="date_regi" placeholder="#" value="<?= h($row['date_regi']) ?>">
                                    <label for="date_regi">公開日</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" id="display" name="display">
                                        <option selected value="1" <?php if ($row['display'] == "1") {
                                                                        print "selected";
                                                                    } ?>>表示</option>
                                        <option value="0" <?php if ($row['display'] == "0") {
                                                                print "selected";
                                                            } ?>>非表示</option>
                                    </select>
                                    <label for="display">表示設定</label>
                                </div>



                            </div>


                        </div>
                    </div>
                    <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="profile-tab">

                        <div class="row">
                            <?php
                            for ($i = 1; $i <= 20; $i++) :
                                $num = zerop($i, 2);
                            ?>
                                <div class="col-md-3 mb-3">
                                    <div class="mb-3 imgInput">
                                        <label for="file<?= $num ?>" class="form-label"><?= $num ?></label>
                                        <input class="form-control mb-2" type="file" name="file<?= $num ?>" id="file<?= $num ?>">
                                        <div class="position-relative">
                                            <?php
                                            $exts = array(".jpg", ".jpeg", ".png", ".gif", ".webp");
                                            foreach ($exts as $ext) {
                                                $img = "../$table/{$code}_md_{$num}{$ext}";
                                                if (file_exists($img)) {
                                                    $img_url = $img . "?c=" . date("Ymdhis");
                                                    break;
                                                } else {
                                                    $img_url = "";
                                                }
                                            }
                                            ?>
                                            <img class="imgView img-fluid" src="<?= $img_url ?>">
                                            <?php if ($img_url) : ?>
                                                <div class="text-end position-absolute" style="top:5px;right:-5px;">
                                                    <a class="btn btn-cred" onclick="del('<?= $num ?>')">削除</a>
                                                </div>
                                                <div id="del<?= $num ?>" class="d-none mt-1">
                                                    <a class="btn btn-cred" href="delete_img.php?code=<?= $code ?>&table=<?= $table ?>&num=<?= $num ?>">削除実行</a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="contact-tab">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="made_in" id="made_in" placeholder="#" value="<?= h($row['made_in']) ?>">
                                    <label for="made_in">産地</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="expiration_date" id="expiration_date" placeholder="#" value="<?= h($row['expiration_date']) ?>">
                                    <label for="expiration_date">賞味期限</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="allergies" id="allergies" placeholder="#" style="height:100px;"><?= h($row['allergies']) ?></textarea>
                                    <label for="allergies">アレルギー</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="ingredients" id="ingredients" placeholder="#" style="height:100px;"><?= h($row['ingredients']) ?></textarea>
                                    <label for="ingredients">原材料</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="component" id="component" placeholder="#" style="height:100px;"><?= h($row['component']) ?></textarea>
                                    <label for="component">成分</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="usage_method" id="usage_method" placeholder="#" style="height:100px;"><?= h($row['usage_method']) ?></textarea>
                                    <label for="usage_method">用法</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="keep_method" id="keep_method" placeholder="#" style="height:100px;"><?= h($row['keep_method']) ?></textarea>
                                    <label for="keep_method">保存方法</label>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="ex_link" id="ex_link" placeholder="#" value="<?= h($row['ex_link']) ?>">
                                    <label for="ex_link">外部リンク</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="line01" id="line01" placeholder="#" value="<?= h($row['line01']) ?>">
                                    <label for="line01">line01</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="line02" id="line02" placeholder="#" value="<?= h($row['line02']) ?>">
                                    <label for="line02">line02</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="line03" id="line03" placeholder="#" value="<?= h($row['line03']) ?>">
                                    <label for="line03">line03</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="box01" id="box01" placeholder="#" style="height:100px;"><?= h($row['box01']) ?></textarea>
                                    <label for="box01">box01</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="box02" id="box02" placeholder="#" style="height:100px;"><?= h($row['box02']) ?></textarea>
                                    <label for="box02">box02</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="box03" id="box03" placeholder="#" style="height:100px;"><?= h($row['box03']) ?></textarea>
                                    <label for="box03">box03</label>
                                </div>

                            </div>
                        </div>



                    </div>
                </div>







                <input type="hidden" name="table" value="<?= $table ?>">
                <?php if ($code) : ?>
                    <input type="hidden" name="code" value="<?= $code ?>">
                <?php else : ?>
                    <input type="hidden" name="next_location" value="<?= $table ?>_list.php">
                <?php endif; ?>
                <input type="submit" class="btn btn-btn px-5" value="登録">
                <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
            </form>

        </section>

        <?php if ($code) : ?>
            <section class="container-fluid mt-5">
                <hr>
                <!-- Button trigger modal -->
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="<?= $table ?>_list.php" class="btn btn-btn">アイテム一覧</a>
                        <a href="copy.php?table=<?= $table ?>&code=<?= $code ?>" class="btn btn-btn">コピー</a>
                    </div>

                    <button type="button" class="btn btn-cred" data-bs-toggle="modal" data-bs-target="#modal">
                        データ削除
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">削除しますか？</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>データを削除すると元に戻すことはできません。</p>
                                <div class="alert alert-danger">削除対象 : <?= h($row['item_name']) ?></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a class="btn btn-cred" href="delete.php?table=<?= $table ?>&code=<?= $row['code'] ?>">削除</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>





        <script>
            function price_add(e) {
                let price_line = e.closest("#price_line");
                let elm = price_line.cloneNode(true);
                price_line.after(elm);
            }

            function price_del(e) {
                let price_line = e.closest("#price_line");
                price_line.remove();
            }
        </script>



    </div>

    <?php
    require("foot.php");
    require("js_datepicker.php");
    require("js_tinymce.php");
    require("js_thumb.php");
    require("js_tagit.php");
    require("js_panelselector.php");
    ?>
