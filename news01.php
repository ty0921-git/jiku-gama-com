<div class="d-flex flex-column flex-md-row border-bottom px-2 py-3 px-md-3 py-md-3 wow fadeInRight" data-wow-delay="<?= ($i * 0.1) ?>s">
  <div class="me-3 wsnw fc-kc"><?= $row['date_regi'] ?></div>
  <?php if ($row['article']) : ?>
    <div><a href="news_detail_<?= $row['code'] ?>.html"><?= h($row['title']) ?></a></div>
  <?php elseif ($row['link']) : ?>
    <div><a href="<?= $row['link'] ?>" target="_blank"><?= h($row['title']) ?></a></div>
  <?php else : ?>
    <div><?= h($row['title']) ?></div>
  <?php endif; ?>
</div>
<?php $i++; ?>
