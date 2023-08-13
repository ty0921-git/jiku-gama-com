<?php
require("head.php");
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <section class="container-fluid p-5">
        <h4>イメージ設定</h4>
        <hr class="mb-5">

        <form action="db_op_as.php" method="POST" enctype="multipart/form-data">

            <div class="row">

                <div class="col-md-6">
                    <h6>ロゴイメージ</h6>
                    <hr>

                    <div class="row">
                        <?php
                        $filenames = ["logo-light", "logo-dark", "favicon"];
                        foreach ($filenames as $filename) :
                        ?>
                            <div class="col-md-6 mb-3">
                                <div class="mb-3 imgInput">
                                    <label for="<?= $filename ?>" class="form-label"><?= $filename ?></label>
                                    <input class="form-control mb-2" type="file" name="<?= $filename ?>" id="<?= $filename ?>">
                                    <div>
                                        <?php
                                        $exts = array(".jpg", ".jpeg", ".png", ".gif", ".svg");
                                        foreach ($exts as $ext) {
                                            $img = "../image/{$filename}{$ext}";
                                            if (file_exists($img)) {
                                                $img_url = $img . "?c=" . date("Ymdhis");
                                                break;
                                            } else {
                                                $img_url = "";
                                            }
                                        }
                                        ?>
                                        <div class="bg-gray p-4 mb-3">
                                            <img class="imgView img-fluid" src="<?= $img_url ?>">
                                        </div>
                                        <?php if ($img_url) : ?>
                                            <div class="text-end">
                                                <a class="btn btn-cred" onclick="del('<?= $filename ?>')">削除</a>
                                            </div>
                                            <div id="del<?= $filename ?>" class="d-none mt-1">
                                                <a class="btn btn-cred" href="delete_img.php?img=<?= $img ?>">削除実行</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>



                <div class="col-md-6">
                    <h6>システムイメージ</h6>
                    <hr>

                    <div class="row">
                        <?php
                        $filenames = ["no-image", "ogp-image"];
                        foreach ($filenames as $filename) :
                        ?>
                            <div class="col-md-6 mb-3">
                                <div class="mb-3 imgInput">
                                    <label for="<?= $filename ?>" class="form-label"><?= $filename ?></label>
                                    <input class="form-control mb-2" type="file" name="<?= $filename ?>" id="<?= $filename ?>">
                                    <div>
                                        <?php
                                        $exts = array(".jpg", ".jpeg", ".png", ".gif", ".svg");
                                        foreach ($exts as $ext) {
                                            $img = "../image/{$filename}{$ext}";
                                            if (file_exists($img)) {
                                                $img_url = $img . "?c=" . date("Ymdhis");
                                                break;
                                            } else {
                                                $img_url = "";
                                            }
                                        }
                                        ?>
                                        <div class="bg-gray p-4 mb-3">
                                            <img class="imgView img-fluid" src="<?= $img_url ?>">
                                        </div>
                                        <?php if ($img_url) : ?>
                                            <div class="text-end">
                                                <a class="btn btn-cred" onclick="del('<?= $filename ?>')">削除</a>
                                            </div>
                                            <div id="del<?= $filename ?>" class="d-none mt-1">
                                                <a class="btn btn-cred" href="delete_img.php?img=<?= $img ?>">削除実行</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>

            <input type="submit" class="btn btn-btn px-5" value="設定">
            <input type="hidden" name="folder" value="image">
            <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
        </form>


    </section>



    <?php
    require("foot.php");
    require("js_thumb.php");
    ?>
