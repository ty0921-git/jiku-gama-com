<?php
$tails = "and date_regi<='$date_today' and post.code!='$code' order by date_update DESC limit 5";
$rows = get_rows("post","blog",$tails);
foreach ($rows as $row) : $row['code'] = zerop($row['code'], 7);
  list($date_update) = explode(" ", $row['date_update']);
  if ($row['article']) {
    $link = "href=\"blog_detail_$row[code].html\"";
  } elseif ($row['link']) {
    $link = "href=\"$row[link]\" target=\"_blank\"";
  } else {
    $link = "";
  }
?>
  <div class="row mb-3 pb-3 border-bottom">
    <?php if ($img = imageCheck("post", "{$row['code']}_md_01", true)) : ?>
      <div class="col-4 col-md-12">
        <a <?= $link ?> class="thumb01 mb-2" style="background-image:url(<?= $img ?>);"></a>
      </div>
    <?php endif; ?>
    <?php if ($img) {
      $cols = 8;
    } else {
      $cols = 12;
    } ?>
    <div class="col-<?= $cols ?> col-md-12">
      <a <?= $link ?>><?= h($row['title']) ?></a>
      <div class="mb-2 text-end fc-gray"><small> <?= h($date_update) ?></small></div>
    </div>
  </div>

<?php endforeach; ?>
