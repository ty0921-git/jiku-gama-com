<?php
require("head.php");
?>
<title>アクセス | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>

    <img src="image/band-about.jpg" class="img-fluid mb-5">

    <section class="container mb-4 mb-md-5 min">
        <h2 class="heading mb-4 mb-md-5"><span>時空窯</span> <small>Gallery</small></h2>
        <div class="row g-1 mb-4">
            <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".1s"><img src="image/jiku01-1.jpg" class="img-fluid" loading="lazy"></div>
            <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".2s"><img src="image/jiku01-2.jpg" class="img-fluid" loading="lazy"></div>
            <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".3s"><img src="image/jiku02.jpg" class="img-fluid" loading="lazy"></div>
            <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".4s"><img src="image/jiku03.jpg" class="img-fluid" loading="lazy"></div>
            <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".1s"><img src="image/jiku04.jpg" class="img-fluid" loading="lazy"></div>
            <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".2s"><img src="image/jiku05.jpg" class="img-fluid" loading="lazy"></div>
            <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".3s"><img src="image/jiku06.jpg" class="img-fluid" loading="lazy"></div>
            <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay=".4s"><img src="image/jiku07.jpg" class="img-fluid" loading="lazy"></div>
        </div>
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



    <section class="container mb-5 min">
        <h2 class="heading"><span>アクセス</span> <small>Access</small></h2>
    </section>


    <section id="map" class="container mb-5" style="height:500px;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5669.387752509722!2d129.97158329848318!3d33.453889297544265!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x356a7870e7f84c39%3A0xf39bd4f884a5616c!2z44CSODQ3LTAwMTYg5L2Q6LOA55yM5ZSQ5rSl5biC5p2x5Z-O5YaF77yU4oiS77yV77yV!5e0!3m2!1sja!2sjp!4v1692214073748!5m2!1sja!2sjp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>


    <?php
    require("foot.php");
    ?>
