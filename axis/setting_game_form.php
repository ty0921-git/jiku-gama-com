<?php
require("head.php");

$sql = "select*from setting_game limit 1";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <section class="container-fluid p-5">
        <?php
        if (!empty($row)) {
            foreach ($row as $key => $val) {
                $$key = h($val);
            }
        }
        ?>
        <h4>ゲーム設定</h4>
        <hr class="mb-5">

        <form action="db_op_as.php" method="POST" enctype="multipart/form-data">


            <h6>チームイメージ</h6>
            <hr>
            <div class="row">
                <?php
                $filenames = ["team-fv"];
                foreach ($filenames as $filename) :
                ?>
                    <div class="col-md-9 mb-3">
                        <div class="mb-3 imgInput">
                            <label for="<?= $filename ?>" class="form-label"><?= $filename ?></label>
                            <input class="form-control mb-2" type="file" name="<?= $filename ?>" id="<?= $filename ?>">
                            <div>
                                <?php
                                $exts = array(".jpg", ".jpeg", ".png", ".gif", ".svg");
                                foreach ($exts as $ext) {
                                    $img = "../image/{$filename}{$ext}";
                                    if (file_exists($img)) {
                                        $img_url = $img . "?c=" . date("Ymdhis");
                                        break;
                                    } else {
                                        $img_url = "";
                                    }
                                }
                                ?>
                                <div class="bg-gray p-4 mb-3">
                                    <img class="imgView img-fluid" src="<?= $img_url ?>">
                                </div>
                                <?php if ($img_url) : ?>
                                    <div class="text-end">
                                        <a class="btn btn-cred" onclick="del('<?= $filename ?>')">削除</a>
                                    </div>
                                    <div id="del<?= $filename ?>" class="d-none mt-1">
                                        <a class="btn btn-cred" href="delete_img.php?img=<?= $img ?>">削除実行</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php
                $filenames = ["team-logo"];
                foreach ($filenames as $filename) :
                ?>
                    <div class="col-md-3 mb-3">
                        <div class="mb-3 imgInput">
                            <label for="<?= $filename ?>" class="form-label"><?= $filename ?></label>
                            <input class="form-control mb-2" type="file" name="<?= $filename ?>" id="<?= $filename ?>">
                            <div>
                                <?php
                                $exts = array(".jpg", ".jpeg", ".png", ".gif", ".svg");
                                foreach ($exts as $ext) {
                                    $img = "../image/{$filename}{$ext}";
                                    if (file_exists($img)) {
                                        $img_url = $img . "?c=" . date("Ymdhis");
                                        break;
                                    } else {
                                        $img_url = "";
                                    }
                                }
                                ?>
                                <div class="bg-gray p-4 mb-3">
                                    <img class="imgView img-fluid" src="<?= $img_url ?>">
                                </div>
                                <?php if ($img_url) : ?>
                                    <div class="text-end">
                                        <a class="btn btn-cred" onclick="del('<?= $filename ?>')">削除</a>
                                    </div>
                                    <div id="del<?= $filename ?>" class="d-none mt-1">
                                        <a class="btn btn-cred" href="delete_img.php?img=<?= $img ?>">削除実行</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>



            <div class="row">
                <?php
                $filenames = ["uniform-home", "uniform-away", "wear-training", "wear-moving"];
                foreach ($filenames as $filename) :
                ?>
                    <div class="col-md-3 mb-3">
                        <div class="mb-3 imgInput">
                            <label for="<?= $filename ?>" class="form-label"><?= $filename ?></label>
                            <input class="form-control mb-2" type="file" name="<?= $filename ?>" id="<?= $filename ?>">
                            <div>
                                <?php
                                $exts = array(".jpg", ".jpeg", ".png", ".gif", ".svg");
                                foreach ($exts as $ext) {
                                    $img = "../image/{$filename}{$ext}";
                                    if (file_exists($img)) {
                                        $img_url = $img . "?c=" . date("Ymdhis");
                                        break;
                                    } else {
                                        $img_url = "";
                                    }
                                }
                                ?>
                                <div class="bg-gray p-4 mb-3">
                                    <img class="imgView img-fluid" src="<?= $img_url ?>">
                                </div>
                                <?php if ($img_url) : ?>
                                    <div class="text-end">
                                        <a class="btn btn-cred" onclick="del('<?= $filename ?>')">削除</a>
                                    </div>
                                    <div id="del<?= $filename ?>" class="d-none mt-1">
                                        <a class="btn btn-cred" href="delete_img.php?img=<?= $img ?>">削除実行</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>




            <div class="row mb-5">

                <div class="col-md-6">
                    <h6>チーム情報</h6>
                    <hr>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="team_name" id="team_name" placeholder="#" value="<?= $team_name ?>">
                        <label for="team_name">チーム名</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="team_intro" id="team_intro" placeholder="#" style="height:150px;"><?= $team_intro ?></textarea>
                        <label for="team_intro">チーム紹介</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="basic_principle" id="basic_principle" placeholder="#" style="height:150px;"><?= $basic_principle ?></textarea>
                        <label for="basic_principle">基本理念</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="action_philosophy" id="action_philosophy" placeholder="#" style="height:150px;"><?= $action_philosophy ?></textarea>
                        <label for="action_philosophy">行動理念</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="team_goal" id="team_goal" placeholder="#" style="height:150px;"><?= $team_goal ?></textarea>
                        <label for="team_goal">チーム目標</label>
                    </div>


                </div>


                <div class="col-md-6">
                    <h6>チームデザイン</h6>
                    <hr>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="origin_name" id="origin_name" placeholder="#" style="height:120px;"><?= $origin_name ?></textarea>
                        <label for="origin_name">チーム名由来</label>
                    </div>

                    <div class="row mb-3 row-cols-md-3 row-cols-1 g-1">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <input type="color" class="form-control form-control-color me-3" id="color_main" name="color_main" value="<?php $color_main ? print $color_main : print "#FFFFFF"; ?>">
                                <label for="color_main" class="form-label">メインカラー</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <input type="color" class="form-control form-control-color me-3" id="color_sub" name="color_sub" value="<?php $color_sub ? print $color_sub : print "#FFFFFF"; ?>">
                                <label for="color_sub" class="form-label">サブカラー</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <input type="color" class="form-control form-control-color me-3" id="color_accent" name="color_accent" value="<?php $color_accent ? print $color_accent : print "#FFFFFF"; ?>">
                                <label for="color_accent" class="form-label">アクセントカラー</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="origin_color" id="origin_color" placeholder="#" style="height:120px;"><?= $origin_color ?></textarea>
                        <label for="origin_color">チームカラー由来</label>
                    </div>


                    <h6>チーム構成</h6>
                    <hr>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="coaching_policy" id="coaching_policy" placeholder="#" style="height:120px;"><?= $coaching_policy ?></textarea>
                        <label for="coaching_policy">指導方針</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="team_activities" id="team_activities" placeholder="#" style="height:120px;"><?= $team_activities ?></textarea>
                        <label for="team_activities">活動内容</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="team_composition" id="team_composition" placeholder="#" style="height:80px;"><?= $team_composition ?></textarea>
                        <label for="team_composition">チーム構成</label>
                    </div>

                </div>

            </div>





            <?php if ($code) : ?>
                <input type="hidden" name="code" value="<?= $code ?>">
            <?php endif; ?>
            <input type="hidden" name="table" value="setting_game">
            <input type="submit" class="btn btn-btn px-5" value="設定">
            <input type="hidden" name="folder" value="image">
            <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
        </form>


    </section>



    <?php
    require("foot.php");
    require("js_thumb.php");
    ?>
