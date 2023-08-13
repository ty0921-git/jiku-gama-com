<?php
require("head.php");

// テーブル指定
$table = "page";

// ゲット変数の無害化処理
$get_code = h(filter_input(INPUT_GET, 'code'));


// コード指定データ取得
if ($get_code) {
    $sql = "select*from $table where code=$get_code";
    $stmt = connect()->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $code = zerop($row['code'], 7);
} else {
    $row['date_regi'] = date("Y-m-d");
}


// tinyMCE API Key 取得
$sql = "select tiny_api_key from setting_post limit 1";
$stmt = connect()->query($sql);
$settings = $stmt->fetch(PDO::FETCH_ASSOC);
?>





<script src="https://cdn.tiny.cloud/1/<?= h($settings['tiny_api_key']) ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
                        <a class="nav-link" id="image-tab" data-bs-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false">ページ画像</a>
                    </li>
                </ul>



                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="base" role="tabpanel" aria-labelledby="base-tab">
                        <div class="row">
                            <div class="col-md-9">

                                <div class="form-floating mb-5">
                                    <input type="text" class="form-control" name="page_name" id="page_name" placeholder="#" value="<?= h($row['page_name']) ?>">
                                    <label for="page_name">ページ名</label>
                                </div>

                                <?php
                                for ($i = 1; $i <= 10; $i++) :
                                    $num = str_pad($i, 2, "0", STR_PAD_LEFT);
                                ?>
                                    <div class="mb-5">

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="title<?= $num ?>" id="title<?= $num ?>" placeholder="#" value="<?= h($row['title' . $num]) ?>">
                                            <label for="title<?= $num ?>">タイトル<?= $num ?></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="text<?= $num ?>" placeholder="#" style="height:300px;"><?= h($row['text' . $num]) ?></textarea>
                                            <label for="text<?= $num ?>">テキスト<?= $num ?></label>
                                        </div>

                                    </div>
                                <?php endfor; ?>

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
                    <a href="<?= $table ?>_list.php" class="btn btn-btn">ページ一覧</a>
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
                                <div class="alert alert-danger">削除対象 : <?= h($row['page_name']) ?></div>
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
    require("js_thumb.php");
    ?>
