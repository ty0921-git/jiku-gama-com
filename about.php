<?php
require("head.php");
require("map.php");
?>
<title>会社概要 | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>



    <section class="container mb-4 mb-md-5">
        <h2 class="heading"><span>About us</span> <small>会社概要</small></h2>
    </section>


    <section class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-base">
                    <?php if ($site_name) : ?>
                        <tr>
                            <th>サイト名</th>
                            <td><?= $site_name ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($site_url) : ?>
                        <tr>
                            <th>サイトURL</th>
                            <td><?= $site_url ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_name) : ?>
                        <tr>
                            <th>商号</th>
                            <td><?= $com_name ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_boss) : ?>
                        <tr>
                            <th>代表者</th>
                            <td><?= $com_boss ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_add) : ?>
                        <tr>
                            <th>所在地</th>
                            <td><?php if ($com_zip) : ?>〒<?= $com_zip ?> <?php endif; ?><?= $com_add ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_tel) : ?>
                        <tr>
                            <th>TEL</th>
                            <td><a href="tel:<?= $com_tel ?>"><?= $com_tel ?></a></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_fax) : ?>
                        <tr>
                            <th>FAX</th>
                            <td><?= $com_fax ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_free_dial) : ?>
                        <tr>
                            <th>フリーダイヤル</th>
                            <td><a href="tel:<?= $com_free_dial ?>"><?= $com_free_dial ?></a></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_hour) : ?>
                        <tr>
                            <th>営業時間</th>
                            <td><?= $com_hour ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_est > 0) : ?>
                        <tr>
                            <th>設立日</th>
                            <td><?= $com_est ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_cap) : ?>
                        <tr>
                            <th>資本金</th>
                            <td><?= $com_cap ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_emp) : ?>
                        <tr>
                            <th>従業員数</th>
                            <td><?= $com_emp ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($main_bank) : ?>
                        <tr>
                            <th>取引先金融機関</th>
                            <td><?= $main_bank ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_license) : ?>
                        <tr>
                            <th>免許・許可</th>
                            <td><?= $com_license ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($com_affiliation) : ?>
                        <tr>
                            <th>所属団体</th>
                            <td><?= $com_affiliation ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </section>



    <section class="container mb-5">
        <h2 class="heading"><span>Access</span> <small>アクセス</small></h2>
    </section>


    <section id="map" class="container mb-5" style="height:500px;">

    </section>


    <?php
    require("foot.php");
    ?>