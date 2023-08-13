<section class="container mb-5">
    <h2 class="heading"><span>News</span> <small>新着情報</small><a href="news_list.html">新着一覧</a></h2>
    <?php
    $tails="and date_regi<='$date_today' order by date_regi DESC limit 5";
    $rows=get_rows("post","news",$tails);
    $i = 0;
    foreach ($rows as $row) : $row['code'] = zerop($row['code'], 7);
    ?>
      <?php require("news01.php"); ?>
    <?php endforeach; ?>
  </section>