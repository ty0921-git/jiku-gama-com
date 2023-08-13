<div class="row row-cols-1 row-cols-md-4 g-1 g-md-3">
  <?php
  $tails = "and archive.code!='$_GET[code]' order by archive.code DESC";
  $rows = get_rows("archive",null,$tails);
  $i = 0;
  foreach ($rows as $row) : $code = zerop($row['code'], 7);
    list($date_regi) = explode(" ", $row['date_regi']);      ?>
    <?php require("archive01.php"); ?>
  <?php endforeach; ?>
</div>
