<?php
require("head.php");

// テーブル指定
$table = "delivary";

// ゲット変数の無害化処理
$get_code = h(filter_input(INPUT_GET, 'code'));


// コード指定データ取得
if ($get_code) {
    $sql = "select*from $table where code=$get_code";
    $stmt = connect()->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $code = zerop($row['code'], 3);
    $col = "delivary_" . $code;
}
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <div class="w-100">
        <section class="container-fluid p-5">

            <form action="delivary_regi.php" method="POST">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="delivary_name" id="delivary_name" placeholder="#" value="<?= h($row['delivary_name']) ?>">
                    <label for="delivary_name">配送名</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="flag_include" name="flag_include">
                        <option value="0" <?php if ($row['flag_include'] == "0") {
                                                print "selected";
                                            } ?>>OFF</option>
                        <option value="1" <?php if ($row['flag_include'] == "1") {
                                                print "selected";
                                            } ?>>ON</option>
                    </select>
                    <label for="flag_include">同梱不可</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="delivary_group" id="delivary_group" placeholder="#" value="<?= h($row['delivary_group']) ?>">
                    <label for="delivary_group">配送グループ</label>
                </div>

                <a id="disp" class="d-inline-block mb-3" style="cursor:pointer;">全国一括指定</a>
                <div class="mb-5 d-none">
                    <div class="input-group mb-3">
                        <div class="form-floating col-md-2">
                            <input type="text" class="form-control" id="bulk_fee" placeholder="#" value="">
                            <label for="delivary_fee">一律送料</label>
                        </div>
                        <button class="btn btn-btn" type="button" id="bulk_btn">一括指定</button>
                    </div>
                </div>



                <?php
                $sql = "select*from area_data";
                $stmt = connect()->query($sql);
                $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $region_name = "";
                $i = 0;
                foreach ($areas as $area) :
                ?>
                    <?php if ($region_name != $area['region_name']) : if ($region_name) print "</div>";
                        $region_name = $area['region_name'];
                        $region_code = "region" . $i;
                        $i++; ?>
                        <div class="bg-main mb-3 py-2 px-3 mt-4"><?= h($area['region_name']) ?>エリア</div>
                        <a id="disp" class="d-inline-block mb-3" style="cursor:pointer;">エリア一括指定</a>
                        <div class="input-group mb-3 d-none">
                            <div class="form-floating col-md-2">
                                <input type="text" class="form-control" id="<?= h($region_code) ?>_fee" placeholder="#" value="">
                                <label for="delivary_fee">エリア一律送料</label>
                            </div>
                            <button class="btn btn-btn" type="button" id="<?= h($region_code) ?>_btn">エリア一括指定</button>
                        </div>


                        <div class="row row-cols-4 g-3">
                        <?php endif; ?>
                        <div class="form-floating col-md-2">
                            <input type="text" class="form-control <?= h($region_code) ?>" name="delivary_fee[]" id="delivary_fee" placeholder="#" value="<?= h($area[$col]) ?>">
                            <label for="delivary_fee"><?= h($area['area_name']) ?></label>
                        </div>

                    <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="table" value="<?= $table ?>">
                        <input type="hidden" name="code" value="<?= $code ?>">
                        <input type="submit" class="btn btn-btn px-5 mt-5" value="登録">
                        <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
            </form>

        </section>

        <?php if ($code) : ?>
            <section class="container-fluid p-5">
                <hr>

                <div class="d-flex justify-content-between">
                    <a href="<?= $table ?>_list.php" class="btn btn-btn">送料設定一覧</a>
                </div>
            </section>
        <?php endif; ?>



    </div>

    <?php
    require("foot.php");
    ?>


    <script>
        let bulk_fee = document.querySelector("#bulk_fee");
        let bulk_btn = document.querySelector("#bulk_btn");
        let input = document.querySelectorAll("#delivary_fee");

        bulk_btn.addEventListener("click", () => {
            for (let i = 0; i < input.length; i++) {
                input[i].value = bulk_fee.value;
            }
        });
    </script>


    <script>
        for (let u = 0; u <= 10; u++) {
            let region_fee = document.querySelector("#region" + u + "_fee");
            let region_btn = document.querySelector("#region" + u + "_btn");
            let region_input = document.querySelectorAll(".region" + u);

            region_btn.addEventListener("click", () => {
                for (let i = 0; i < region_input.length; i++) {
                    region_input[i].value = region_fee.value;
                }
            });
        }
    </script>

    <script>
        let disp = document.querySelectorAll("#disp");
        for (let i = 0; i < disp.length; i++) {
            disp[i].addEventListener("click", () => {
                disp[i].nextElementSibling.classList.toggle("d-none");
            });
        }
    </script>
