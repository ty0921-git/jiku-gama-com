<?php
require("head.php");
?>
<title>送料一覧 | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
    <?php
    require("nav.php");
    ?>
    <section class="p-2 p-md-4"></section>


    <section class="container mb-5">
        <h2 class="heading"><span>Shipping Fee</span> <small>送料一覧</small></h2>
    </section>

    <section class="container mb-5">
        <form action="">
            <div class="row">
                <div class="col-6 col-md-4">
                    <div class="mb-3">
                        <select class="form-select" id="area_code" name="area_code">
                            <option value="">日本全国</option>
                            <?php
                            $sql = "select*from area_data";
                            $stmt = connect()->query($sql);
                            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($areas as $area) :
                            ?>
                                <option value="<?= zerop($area['code'], 3) ?>" <?php if ($_GET['area_code'] == $area['code']) print "selected"; ?>><?= $area['area_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <input class="btn btn-btn" type="submit" value="配送エリア指定">
                </div>
            </div>
        </form>
    </section>

    <?php
    $sql = "select*from delivary order by code ASC";
    $stmt = connect()->query($sql);
    $delis = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($delis as $deli) :
        $deli_num = str_pad($deli['code'], 3, 0, STR_PAD_LEFT);
        $deli_code = "delivary_" . $deli_num;
    ?>
        <section class="container mb-5">
            <h3 class="mb-3 fc-kc"><?= $deli['delivary_name'] ?></h3>
            <div class="row row-cols-4 row-cols-md-4 row-cols-lg-6 g-3 mb-5">
                <?php
                $sql = "select*from area_data";
                if ($_GET['area_code']) {
                    $sql = "select*from area_data where code='$_GET[area_code]'";
                }
                $stmt = connect()->query($sql);
                $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($areas as $area) :
                ?>
                    <div class="col">
                        <div class="row g-3">
                            <div class="col-12 bg-light wsnw">
                                <div class="p-2"><?= $area['area_name'] ?></div>
                            </div>
                            <div class="col-12 wsnw">
                                <div class="p-2"><?= d($area[$deli_code]) ?>円</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr class="mb-5">
        </section>
    <?php endforeach; ?>

    <?php
    require("foot.php");
    ?>