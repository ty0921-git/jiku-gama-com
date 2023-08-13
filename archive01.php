<?php
$img = imageCheck("archive","{$code}_md_01", true);
$cate_codes = getChainCode($code,"archive");
?>
<div class="col data-list01 wow fadeInUp" data-wow-delay="0.1s">
    <div class="row g-3 g-md-0">
        <div class="col-4 col-md-12">
            <a href="archive_detail_<?= $code ?>.html" class="thumb01" style="background-image:url(<?= $img ?>);"></a>
        </div>
        <div class="col-8 col-md-12">
            <div class="py-1 px-0 py-md-3 px-md-1">
                <div class="category mb-md-2">
                    <?php
                    foreach ($cate_codes as $cate_code) :
                        if ($cate_code == "") {
                            continue;
                        };
                    ?>
                        <span class="badge bg-sc"><?=h($cate_list[$cate_code['call_code']])?></span>
                    <?php endforeach; ?>
                    <?php if ($row['date_regi']) : ?>
                            <span class="fs09"><?= h($row['date_regi']) ?></span>
                        <?php endif; ?>
                        <?php if ($row['archive_area']) : ?>
                            <span class="fs09"><?= h($row['archive_area']) ?></span>
                        <?php endif; ?>
                </div>
                <?php if ($row['archive_catch']) : ?>
                    <div><small><?= h($row['archive_catch']) ?></small></div>
                <?php endif; ?>
                <a class="title" href="archive_detail_<?= $code ?>.html"><?= h($row['archive_title']) ?></a>
                <div class="mt-2 d-none d-md-block"><?= h($row['short_description']) ?></div>
            </div>
        </div>
    </div>
</div>
