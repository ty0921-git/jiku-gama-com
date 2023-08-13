<?php
require("head.php");

// テーブル指定
$table = "faq";

// ゲット変数の無害化処理
$get_code=h(filter_input(INPUT_GET,'code'));

// カテゴリーデータ取得
$categories = get_category($table);

// コード指定データ取得
if ($get_code) {
    $row = get_row($table, $get_code);
    $code = zerop($row['code'], 7);
    $chains = get_chains($table, $get_code);
}
?>
<script src="https://cdn.tiny.cloud/1/<?= get_tiny_key() ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <div class="w-100">
        <section class="container-fluid p-5">

            <form action="db_op.php" method="POST">

                <div class="mb-4">
                    <?php if ($categories) : ?>
                        <?php foreach ($categories as $category) : $category_code = $category['code']; ?>
                            <div class="form-check form-check-inline form-switch">
                                <input class="form-check-input" type="checkbox" id="cate_code" name="cate_code[]" value="<?= $category_code ?>" <?php if($code && in_array($category_code,$chains)) print "checked"; ?>>
                                <label class="form-check-label" for="cate_code"> <?= h($category['cate_name']) ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="faq_que" id="faq_que" placeholder="#" value="<?= h($row['faq_que']) ?>">
                    <label for="faq_que">質問</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" name="faq_ans" id="article" placeholder="#" style="height:500px;"><?= h($row['faq_ans']) ?></textarea>
                    <label for="faq_ans">回答</label>
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

                <input type="hidden" name="table" value="<?= $table ?>">
                <?php if (!$code) : ?>
                    <input type="hidden" name="date_regi" value="<?= date("Y-m-d") ?>">
                <?php else : ?>
                    <input type="hidden" name="code" value="<?= $code ?>">
                <?php endif; ?>
                <input type="submit" class="btn btn-btn px-5" value="登録">
                <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
            </form>

        </section>

        <?php if ($code) : ?>
            <section class="container-fluid p-5">
                <hr>
                <!-- Button trigger modal -->
                <div class="d-flex justify-content-between">
                    <a href="<?= $table ?>_list.php" class="btn btn-btn">FAQ一覧</a>
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
                                <div class="alert alert-danger">削除対象 : <?= h($row['faq_que']) ?></div>
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



    </div>

    <?php
    require("foot.php");
    require("js_tinymce.php");
    ?>