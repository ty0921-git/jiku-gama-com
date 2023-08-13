<?php
require("head.php");
?>
<title>特定商取引法に基づく表記 | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>


    <section class="container mb-4 mb-md-5">
        <h2 class="heading"><span>SCTL</span> <small>特定商取引法に基づく表記</small></h2>
    </section>


    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="py-md-4 py-0 px-md-4 px-2 privacy">



                    <h3>販売価格について</h3>

                    <div class="p-md-4">
                        <p>
                            販売価格は、表示された金額（表示価格・消費税込）とします。
                        </p>
                        <p>なお、商品代金以外に送料や各種手数料がかかる場合がございます。各商品ページや、お支払方法の選択ページ、注文内容のご確認ページをご確認ください。</p>
                    </div>


                    <h3>代金の支払時期と方法</h3>
                    <div class="p-md-4">
                        <h4>支払方法</h4>
                        <p>クレジットカード、代金引換がご利用いただけます。</p>
                        <h4>支払時期</h4>
                        <p>クレジットカードは商品ご注文時点でお支払いが確定します。 </p>
                        <p>代金引換は商品の配達時に配達員の方にお支払いください。 </p>
                    </div>

                    <h3>返品についての特約事項</h3>
                    <div class="p-md-4">
                        <p>商品に欠陥がある場合を除き、返品には応じません。</p>
                    </div>


                    <h3>引き渡し時期</h3>
                    <div class="p-md-4">
                        <p>
                            予約商品などを除き、通常は配送のご依頼を受けてから7日以内に発送いたします。
                        </p>
                    </div>

                    <h3>事業者の名称および連絡先</h3>
                    <div class="p-md-4">
                        <p>

                        <table class="table table-base">
                            <tbody>
                                <tr>
                                    <th>社名</th>
                                    <td><?= $com_name ?></td>
                                </tr>
                                <tr>
                                    <th>代表者</th>
                                    <td><?= $com_boss ?></td>
                                </tr>
                                <tr>
                                    <th>所在地</th>
                                    <td>〒<?= $com_zip ?> <?= $com_add ?></td>
                                </tr>
                                <tr>
                                    <th>連絡先</th>
                                    <td><a href="tel:<?= $com_tel ?>"><?= $com_tel ?></a></td>
                                </tr>
                            </tbody>
                        </table>

                        </p>

                        <p>
                            以上
                        </p>
                    </div>



                </div>
            </div>
        </div>
    </section>


    <?php
    require("foot.php");
    ?>