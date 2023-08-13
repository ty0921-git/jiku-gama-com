<?php
$img = imageCheck("post","{$code}_md_01", true);
$cate_codes = getChainCode($code,$table);
?>
<div class="col mb-2 data-list01 wow fadeInUp" data-wow-delay="0.1s">
  <div class="row g-3 g-md-0">
    <div class="col-4 col-md-12">
      <a href="blog_detail_<?= $code ?>.html" class="thumb01" style="background-image:url(<?= $img ?>);"></a>
    </div>
    <div class="col-8 col-md-12">
      <div class="py-1 px-0 py-md-3 px-md-1">
        <div class="category mb-2 d-none d-md-block">
          <?php
          foreach ($cate_codes as $cate_code) :
            if ($cate_code == "") {
              continue;
            };
          ?>
            <span class="badge bg-sc"><?=h($cate_list[$cate_code['call_code']])?></span>
          <?php endforeach; ?>
        </div>
        <a class="title" href="blog_detail_<?= $code ?>.html"><?= h($row['title']) ?></a>
        <div class="update"><?= h($date_update) ?></div>
      </div>
    </div>
  </div>
</div>
