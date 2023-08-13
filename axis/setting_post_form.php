<?php
require("head.php");

$sql = "select*from setting_post limit 1";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <section class="container-fluid p-5">
        <?php
        if (!empty($row)) {
            foreach ($row as $key => $val) {
                $$key = h($val);
            }
        }
        ?>
        <h4>ブログ設定</h4>
        <hr class="mb-5">

        <form action="db_op.php" method="POST">

            <div class="row">

                <div class="col-md-6">
                    <h6>ブログ情報</h6>
                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="blog_title" id="blog_title" placeholder="#" value="<?= $blog_title ?>">
                        <label for="blog_title">ブログタイトル</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="blog_url" id="blog_url" placeholder="#" value="<?= $blog_url ?>">
                        <label for="blog_url">ブログURL</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="blog_desc" id="blog_desc" placeholder="#" style="height:100px;"><?= $blog_desc ?></textarea>
                        <label for="blog_desc">ブログ説明</label>
                    </div>


                    <h6 class="mt-5">TinyMCE</h6>
                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="tiny_api_key" id="tiny_api_key" placeholder="#" value="<?= $tiny_api_key ?>">
                        <label for="tiny_api_key">tinyMCE API Key</label>
                    </div>


                </div>

            </div>


            <?php if ($code) : ?>
                <input type="hidden" name="code" value="<?= $code ?>">
            <?php endif; ?>
            <input type="hidden" name="table" value="setting_post">
            <input type="submit" class="btn btn-btn px-5" value="設定">
            <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
        </form>


    </section>



    <?php
    require("foot.php");
    ?>
