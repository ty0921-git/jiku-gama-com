<section class="container mb-5 panel">
    <h2 class="heading mb-3 mb-md-5"><span>Item</span> <small>商品</small><a href="item_list.html">商品一覧</a></h2>
    <div class="row gx-2 gy-5 row-cols-2 row-cols-md-4 mb-5">
        <?php
        $cate_list=getCategoryList("item");
        $rows = get_rows("item", null, "order by code DESC limit 8");
        $i = 0;
        foreach ($rows as $row) : $code = zerop($row['code'], 7);
            $price_data = explode("\n", $row['price']);
            list(, $price) = explode("<>", $price_data[0]);
            if (empty($price)) {
                continue;
            }
        ?>
            <?php require("item01.php"); ?>
        <?php $i++;
        endforeach; ?>

    </div>

    <div class="text-center">
        <a href="item_list.html" class="btn btn-btn">商品一覧はこちら</a>
    </div>
</section>