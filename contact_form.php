<?php
require("head.php");
?>
<title>お問い合わせフォーム | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>


    <section class="container mb-5">
        <h2 class="heading"><span>Contact</span> <small>お問い合わせ</small></h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="py-4 px-4 text-md-center">
                    お客さまからのご質問をお電話・お問い合わせフォームにて受け付けております。<br class="d-md-block d-none">
                    必要事項をご記入の上、「入力内容の確認画面へ」を押してください。
                </div>
            </div>
        </div>
    </section>


    <section class="container mb-5">
        <h3 class="heading"><span>Phone</span> <small>お電話でのお問い合わせ</small></h3>
        <div class="text-center py-4">
            <?php if (!$com_free_dial && $com_tel) : ?>
                <div class="display-5"><a href="tel:<?= $com_tel ?>"><?= $com_tel ?></a></div>
            <?php endif; ?>
            <?php if ($com_free_dial) : ?>
                <div class="display-5"><a href="tel:<?= $com_free_dial ?>"><?= $com_free_dial ?></a></div>
            <?php endif; ?>
            <small>受付時間 : <?= $com_hour ?></small>
        </div>
    </section>



    <section class="container mb-5">
        <h3 class="heading"><span>Contact Form</span> <small>お問い合わせフォーム</small></h3>


        <form action="contact_regi.php" method="POST" class="py-4">
            <div class="row justify-content-center">
                <div class="col-md-7">

                    <div class="form-floating mb-3">
                        <input type="text" name="company" class="form-control" id="company" placeholder="company">
                        <label for="company">会社名</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control" id="name" placeholder="name">
                        <label for="name">お名前<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="tel" class="form-control" id="tel" placeholder="tel">
                        <label for="tel">TEL<b>*</b></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="email">
                        <label for="email">メール<b>*</b></label>
                    </div>

                    <div class="form-floating mb-5">
                        <textarea class="form-control" name="comments" placeholder="comments" id="comments" style="height: 200px"></textarea>
                        <label for="comments">メッセージ</label>
                    </div>

                    <div class="mb-5">
                        <h4 class="mb-3">個人情報の取り扱いについて</h4>
                        <p><a href="privacy.html" target="_blank">プライバシーポリシー</a>をご確認の上、同意していただける場合は「プライバシーポリシーに同意する」にチェックを入れてください。</p>
                        <div class="bg-light p-3">
                            <input type="checkbox" id="privacy_check" class="form-check-input">
                            <label for="privacy_check" class="form-check-label">プライバシーポリシーに同意する</label>
                        </div>
                    </div>

                    <div class="text-center">
                        <input class="btn btn-btn" id="submit" type="submit" value="送信する" disabled>
                        <input type="hidden" name="csrf_token" value="<?=setToken()?>">
                    </div>

                </div>
            </div>
        </form>
    </section>



    <?php
    require("foot.php");
    ?>


    <script>
        submit = document.querySelector("#submit");
        check = document.querySelector("#privacy_check");
        check.addEventListener("change", function() {
            submit.disabled = !check.checked;
        });
    </script>