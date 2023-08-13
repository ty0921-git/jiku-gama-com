<?php
$img = imageCheck("item", "{$code}_md_01", true);
$cate_codes = getChainCode($code,"item");
?>
<div class="col data-list01 wow fadeInUp" data-wow-delay="0.1s">
  <div class="row row-cols-1 g-3 g-md-0">
    <div class="col">
      <a href="item_detail_<?= $code ?>.html" class="thumb01" style="background-image:url(<?= $img ?>);"></a>
    </div>
    <div class="col">
      <div class="py-1 px-0 py-md-3 px-md-1">
        <?php if (!empty($cate_codes[0])) : ?>
          <div class="category mb-2">
            <?php
            foreach ($cate_codes as $cate_code) :
              if ($cate_code == "") {
                continue;
              };
            ?>
              <span class="badge bg-sc"><?=h($cate_list[$cate_code['call_code']])?></span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <div>
          <?php if ($row['maker']) : ?>
            <small><?= h($row['maker']) ?></small>
          <?php endif; ?>
          <?php if ($row['brand']) : ?>
            <small><?= h($row['brand']) ?></small>
          <?php endif; ?>
        </div>
        <a class="title" href="item_detail_<?= $code ?>.html"><?= h($row['item_name']) ?></a>
        <div class="fs16 text-end mb-3"><small>価格</small> <?= d(taxin($price)) ?> <small>円（税込）</small></div>
        <div><?=h($row['short_description'])?></div>
      </div>
    </div>
  </div>
</div>