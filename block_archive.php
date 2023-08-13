<section class="container mb-5 panel">
    <h2 class="heading mb-3 mb-md-5"><span>Archive</span> <small>実績</small><a href="archive_list.html">実績一覧</a></h2>
    <div class="row gx-2 gy-3 row-cols-1 row-cols-md-4 mb-5">
        <?php
        $cate_list=getCategoryList("archive");
        $rows = get_rows("archive", null, "order by code DESC limit 4");
        $i = 0;
        foreach ($rows as $row) : $code = zerop($row['code'], 7);
        ?>
            <?php require("archive01.php"); ?>
        <?php $i++;
        endforeach; ?>

    </div>

    <div class="text-center">
        <a href="archive_list.html" class="btn btn-btn">実績一覧はこちら</a>
    </div>
</section>