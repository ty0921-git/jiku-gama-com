<div class="border-bottom px-2 py-3 px-md-3 py-md-5 wow fadeInRight" data-wow-delay="<?= ($i * 0.1) ?>s">
    <div class="fs16 mb-2"><a href="faq_detail_<?= h($row['code']) ?>.html"><?= h($row['faq_que']) ?></a></div>
    <div><?= abb($row['faq_ans'],250) ?></div>
</div>
<?php $i++; ?>
