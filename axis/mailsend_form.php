<?php
require("head.php");

// テーブル指定
$table = "contact";

// カテゴリーデータ取得
$sql = "select*from category where allocation='$table' order by sort ASC";
$stmt = connect()->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// メールフッター生成
$sql = "select*from mailtemp where call_code='footer'";
$stmt = connect()->query($sql);
$mail_footer_data = $stmt->fetch(PDO::FETCH_ASSOC);

$mail_footer = $mail_footer_data['mail_body'];


// 基本データ取得
$sql = "select*from setting limit 1";
$stmt = connect()->query($sql);
$setting = $stmt->fetch(PDO::FETCH_ASSOC);

$mail_footer = str_replace("<site_name>", $setting['site_name'], $mail_footer);
$mail_footer = str_replace("<site_url>", $setting['site_url'], $mail_footer);
$mail_footer = str_replace("<com_name>", $setting['com_name'], $mail_footer);
$mail_footer = str_replace("<com_zip>", $setting['com_zip'], $mail_footer);
$mail_footer = str_replace("<com_add>", $setting['com_add'], $mail_footer);
$mail_footer = str_replace("<com_tel>", $setting['com_tel'], $mail_footer);
$mail_footer = str_replace("<com_fax>", $setting['com_fax'], $mail_footer);


// テスト用メールアドレスの設定
isset($_SESSION['test_email']) ? $test_email = $_SESSION['test_email'] : $test_email = $setting['com_email'];
?>


<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <div class="w-100 p-5">
        <section class="container-fluid">

            <form action="mailsend_regi.php" method="POST" enctype="multipart/form-data">


                <div class="row">
                    <div class="col-md-9">


                        <div class="mb-4">
                            <?php if ($categories) : ?>
                                <?php foreach ($categories as $category) : $category_code = $category['code']; ?>
                                    <div class="form-check form-check-inline form-switch">
                                        <input class="form-check-input" type="checkbox" id="cate_code" name="cate_code[]" value="<?= $category_code ?>" <?php if (strstr($row['cate_code'], $category_code)) {
                                                                                                                                                            print "checked";
                                                                                                                                                        } ?>>
                                        <label class="form-check-label" for="cate_code"> <?= h($category['cate_name']) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="template" name="template">
                                <option selected value="0">選択してください</option>
                                <?php
                                $sql = "select*from mailtemp where support='on'";
                                $stmt = connect()->query($sql);
                                $temps = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($temps as $temp) :
                                ?>
                                    <option value="<?= h($temp['call_code']) ?>"><?= h($temp['mailtemp_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="template">テンプレート</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="mail_title" id="mail_title" placeholder="#" value="">
                            <label for="mail_title">メールタイトル</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="mail_body" id="mail_body" placeholder="#" style="height:500px;"></textarea>
                            <label for="mail_body">メール本文</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="mail_footer" id="mail_footer" placeholder="#" style="height:200px;"><?= h($mail_footer) ?></textarea>
                            <label for="mail_footer">メールフッター</label>
                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="mb-4">
                            <div class="form-check form-check-inline form-switch">
                                <input class="form-check-input" type="checkbox" id="test" name="test" value="1" checked>
                                <label class="form-check-label" for="test"> テスト送信</label>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="sender_name" id="sender_name" placeholder="#" value="<?= h($setting['com_name']) ?>">
                            <label for="sender_name">送信者</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="sender" id="sender" placeholder="#" value="<?= h($setting['com_email']) ?>">
                            <label for="sender">送信元</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="test_email" id="test_email" placeholder="#" value="<?= h($test_email) ?>">
                            <label for="test_email">テスト受信アドレス</label>
                        </div>

                    </div>


                </div>

                <input type="submit" class="btn btn-btn px-5" value="メール送信">
                <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
            </form>

        </section>



    </div>

    <?php
    require("foot.php");
    require("js_datepicker.php");
    ?>


    <script>
        let template = document.querySelector("#template");
        template.addEventListener("change", function() {
            get_temp_data(this.value);
        });

        async function get_temp_data(val) {
            const request = "get_temp_data.php?call_code=" + val;
            let res = await (await fetch(request)).json();

            document.querySelector("#mail_title").value = res.mail_title;
            document.querySelector("#mail_body").value = res.mail_body;
        }
    </script>
