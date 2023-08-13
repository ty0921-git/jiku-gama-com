<?php
require("head.php");
?>
<title>ショッピングカート | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>


    <section class="container mb-4 mb-md-5">
        <h2 class="heading"><span>Shopping Cart</span> <small>ショッピングカート</small></h2>
    </section>

    <?php if (empty($_SESSION['cart'])) : ?>
        <div class="container mb-5">
            <div class="alert alert-danger" role="alert">
                カートに商品がありません。
            </div>
        </div>
    <?php endif; ?>


    <div class="container mb-5">
        <table class="table table-cart">
            <tr>
                <th class="text-center wsnw" style="min-width:80px;">画像</th>
                <th>商品名</th>
                <th class="text-center wsnw">小計</th>
                <th class="text-center wsnw">削除</th>
            </tr>
            <?php if (!empty($_SESSION['cart'])) : ?>
                <?php
                $num = 0;
                $item_total = 0;
                foreach ($_SESSION['cart'] as $cart) :
                    list($code, $item_name, $price_label, $price, $qty) = explode("<>", $cart);
                    $subtotal = $price * $qty;
                    $item_total += $subtotal;
                    $img = imageCheck("item", "{$code}_sm_01", false);
                ?>
                    <tr>
                        <td>
                            <a class="thumb01" href="item_detail_<?= $code ?>.html" style="background-image:url(<?= $img ?>)"></a>
                        </td>
                        <td>
                            <div><a class="fs-md-12" href="item_detail_<?= $code ?>.html"><?= h($item_name) ?><?= h($price_label) ?></a></div>
                            <div class="text-md-end"><?= d($price) ?> <small>円</small> × <?= h($qty) ?></div>
                        </td>
                        <td class="text-end wsnw fs-md-16"><?= d($subtotal) ?> <small>円</small></td>
                        <td class="text-center"><a href="cart_out.php?num=<?= $num ?>"><i class='bx bx-trash bx-sm mt-2'></i></a></td>
                    </tr>
                <?php $num++;
                endforeach; ?>
            <?php endif; ?>
        </table>
    </div>

    <div class="container mb-5">
        <div class="row g-1">
            <div class="col-6 col-md-3 offset-md-6">
                <div class="bg-kc text-white h-100 d-flex align-items-center justify-content-center">商品合計</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="bg-light text-end fs18 h-100 px-3"><?= d($item_total) ?> <small>円</small></div>
            </div>
        </div>
    </div>



    <div class="container mb-5">
        <div class="d-flex justify-content-between">
            <a class="btn btn-btn col-5 col-md-2" href="item_list.html">買い物を続ける</a>
            <a class="btn btn-btn col-5 col-md-2" href="cart02.html">購入手続き</a>
        </div>
    </div>



    <?php
    require("foot.php");
    ?>
