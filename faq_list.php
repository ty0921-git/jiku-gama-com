<?php
require("head.php");

$table = "faq";
$call_code = null;
?>
<title>よくあるご質問一覧 | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>

    <section class="p-2 p-md-4"></section>


    <section class="container mb-5">
        <h2 class="heading mb-5"><span>FAQ</span> <small>よくあるご質問</small></h2>
        <?php
        $sql = "select code,cate_name,call_code from category where allocation='faq'";
        $stmt = connect()->query($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categories as $category) :
        ?><div class="mb-5">
                <div class="fs16 text-center"><?= h($category['cate_name']) ?></div>
                <?php
                $tails = "order by date_regi DESC";
                $rows = get_rows($table, $category['call_code'], $tails);
                $i = 0;
                foreach ($rows as $row) :
                    require("faq01.php");
                ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </section>




    <?php
    require("foot.php");
    ?>
