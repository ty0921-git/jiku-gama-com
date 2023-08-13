<?php
require("head.php");

// テーブル指定
$table = "game";

// ゲット変数の無害化処理
$get_code = h(filter_input(INPUT_GET, 'code'));

// カテゴリーデータ取得
$categories = get_category($table);

// コード指定データ取得
if ($get_code) {
    $row = get_row($table, $get_code);
    $code = zerop($row['code'], 7);
    $chains = get_chains($table, $get_code);
}
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <div class="w-100 p-5">
        <section class="container-fluid">

            <form action="db_op.php" method="POST" enctype="multipart/form-data">



                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="base-tab" data-bs-toggle="tab" href="#base" role="tab" aria-controls="base" aria-selected="true">基本情報</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="image-tab" data-bs-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false">ゲーム画像</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">詳細情報</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="comment-tab" data-bs-toggle="tab" href="#comment" role="tab" aria-controls="comment" aria-selected="false">コメント</a>
                    </li>
                </ul>



                <div class="tab-content mb-5" id="myTabContent">
                    <div class="tab-pane fade show active" id="base" role="tabpanel" aria-labelledby="base-tab">

                        <div class="mb-4">
                            <?php if ($categories) : ?>
                                <?php foreach ($categories as $category) : $category_code = $category['code']; ?>
                                    <div class="form-check form-check-inline form-switch">
                                        <input class="form-check-input" type="checkbox" id="cate_code" name="cate_code[]" value="<?= h($category_code) ?>" <?php if ($code && in_array($category_code, $chains)) print "checked"; ?>>
                                        <label class="form-check-label" for="cate_code"> <?= h($category['cate_name']) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>


                        <div class="row mb-4">
                            <div class="col-md-6">

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="game_catch" id="game_catch" placeholder="#" style="height:100px;"><?= h($row['game_catch']) ?></textarea>
                                    <label for="game_catch">キャッチコピー</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="game_title" id="game_title" placeholder="#" value="<?= h($row['game_title']) ?>">
                                    <label for="game_title">ゲームタイトル</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control datepicker" name="game_date" id="game_date" placeholder="#" value="<?= h($row['game_date']) ?>">
                                    <label for="game_date">開催日</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="game_time" id="game_time" placeholder="#" value="<?= h($row['game_time']) ?>">
                                    <label for="game_time">開催時間</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="game_memo" id="game_memo" placeholder="#" style="height:100px;"><?= h($row['game_memo']) ?></textarea>
                                    <label for="game_memo">メモ</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" id="display" name="display">
                                        <option selected value="1" <?php if ($row['display'] == "1") {
                                                                        print "selected";
                                                                    } ?>>表示</option>
                                        <option value="0" <?php if ($row['display'] == "0") {
                                                                print "selected";
                                                            } ?>>非表示</option>
                                    </select>
                                    <label for="display">表示設定</label>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="game_opponent" id="game_opponent" placeholder="#" value="<?= h($row['game_opponent']) ?>">
                                    <label for="game_opponent">対戦相手</label>
                                </div>

                                <div class="mb-3 imgInput">
                                    <label for="logo_opponent" class="form-label">Logo of opponent</label>
                                    <input class="form-control mb-2" type="file" name="logo_opponent" id="logo_opponent">
                                    <div class="position-relative" style="max-width:200px;">
                                        <?php
                                        $exts = array(".jpg", ".jpeg", ".png", ".gif", ".svg");
                                        foreach ($exts as $ext) {
                                            $img = "../$table/{$code}_logo_opponent{$ext}";
                                            if (file_exists($img)) {
                                                $img_url = $img . "?c=" . date("Ymdhis");
                                                $del_url = $img;
                                                break;
                                            } else {
                                                $img_url = "";
                                            }
                                        }
                                        ?>
                                        <img class="imgView img-fluid" src="<?= $img_url ?>">
                                        <?php if ($img_url) : ?>
                                            <div class="text-end position-absolute" style="top:5px;right:-5px;">
                                                <a class="btn btn-cred" onclick="del('_opponent')">削除</a>
                                            </div>
                                            <div id="del_opponent" class="d-none mt-1">
                                                <a class="btn btn-cred" href="delete_img.php?img=<?= $del_url ?>&table=<?= $table ?>&code=<?= $code ?>">削除実行</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>


                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="game_place" id="game_place" placeholder="#" value="<?= h($row['game_place']) ?>">
                                    <label for="game_place">ゲーム会場</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="game_place_add" id="game_place_add" placeholder="#" value="<?= h($row['game_place_add']) ?>">
                                    <label for="game_place_add">会場住所</label>
                                </div>

                            </div>

                        </div>


                        <div class="row">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="game_score_team" id="game_score_team" placeholder="#" value="<?= h($row['game_score_team']) ?>">
                                    <label for="game_score_team">チームスコア</label>
                                </div>
                            </div>
                            <div class="col-6">

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="game_score_opponent" id="game_score_opponent" placeholder="#" value="<?= h($row['game_score_opponent']) ?>">
                                    <label for="game_score_opponent">対戦相手スコア</label>
                                </div>
                            </div>
                        </div>

                        <?php
                        $game_score_details = explode("\n", $row['game_score_details']);
                        for ($i = 0; $i < sizeof($game_score_details); $i++) :
                            if ($game_score_details[$i] == "" && $i != 0) continue;
                            list($detail_team_label, $detail_team_score, $detail_set, $detail_opponent_score, $detail_opponent_label) = explode("<>", $game_score_details[$i]);
                        ?>
                            <div id="game_details" class="row row-cols-6">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="detail_team_label[]" id="detail_team_label[]" placeholder="#" value="<?= h($detail_team_label) ?>">
                                        <label for="detail_team_label[]">チームラベル</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="detail_team_score[]" id="detail_team_score[]" placeholder="#" value="<?= h($detail_team_score) ?>">
                                        <label for="detail_team_score[]">チームスコア</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="detail_set[]" id="detail_set[]" placeholder="#" value="<?= h($detail_set) ?>">
                                        <label for="detail_set[]">セット名</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="detail_opponent_score[]" id="detail_opponent_score" placeholder="#" value="<?= h($detail_opponent_score) ?>">
                                        <label for="detail_opponent_score">対戦相手スコア</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="detail_opponent_label[]" id="detail_opponent_label[]" placeholder="#" value="<?= h($detail_opponent_label) ?>">
                                        <label for="detail_opponent_label[]">対戦相手ラベル</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <a class="btn btn-btn" id="block_add" onclick="block_add(this)"><i class="bi bi-plus"></i></a>
                                    <a class="btn btn-btn" id="block_del" onclick="block_del(this)"><i class="bi bi-dash"></i></a>
                                </div>
                            </div>
                        <?php endfor; ?>

                    </div>
                    <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="profile-tab">

                        <div class="row">
                            <?php
                            for ($i = 1; $i <= 20; $i++) :
                                $num = zerop($i, 2);
                            ?>
                                <div class="col-md-3 mb-3">
                                    <div class="mb-3 imgInput">
                                        <label for="file<?= $num ?>" class="form-label"><?= $num ?></label>
                                        <input class="form-control mb-2" type="file" name="file<?= $num ?>" id="file<?= $num ?>">
                                        <div class="position-relative">
                                            <?php
                                            $exts = array(".jpg", ".jpeg", ".png", ".gif", ".webp");
                                            foreach ($exts as $ext) {
                                                $img = "../$table/{$code}_md_{$num}{$ext}";
                                                if (file_exists($img)) {
                                                    $img_url = $img . "?c=" . date("Ymdhis");
                                                    break;
                                                } else {
                                                    $img_url = "";
                                                }
                                            }
                                            ?>
                                            <img class="imgView img-fluid" src="<?= $img_url ?>">
                                            <?php if ($img_url) : ?>
                                                <div class="text-end position-absolute" style="top:5px;right:-5px;">
                                                    <a class="btn btn-cred" onclick="del('<?= $num ?>')">削除</a>
                                                </div>
                                                <div id='del<?= $num ?>' class="d-none mt-1">
                                                    <a class="btn btn-cred" href="delete_img.php?code=<?= $code ?>&table=<?= $table ?>&num=<?= $num ?>">削除実行</a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="contact-tab">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="ex_link" id="ex_link" placeholder="#" value="<?= h($row['ex_link']) ?>">
                                    <label for="ex_link">外部リンク</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="line01" id="line01" placeholder="#" value="<?= h($row['line01']) ?>">
                                    <label for="line01">line01</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="line02" id="line02" placeholder="#" value="<?= h($row['line02']) ?>">
                                    <label for="line02">line02</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="line03" id="line03" placeholder="#" value="<?= h($row['line03']) ?>">
                                    <label for="line03">line03</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="box01" id="box01" placeholder="#" style="height:100px;"><?= h($row['box01']) ?></textarea>
                                    <label for="box01">box01</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="box02" id="box02" placeholder="#" style="height:100px;"><?= h($row['box02']) ?></textarea>
                                    <label for="box02">box02</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="box03" id="box03" placeholder="#" style="height:100px;"><?= h($row['box03']) ?></textarea>
                                    <label for="box03">box03</label>
                                </div>

                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>



                    </div>

                    <div class="tab-pane fade" id="comment" role="tabpanel" aria-labelledby="contact-tab">
                        <?php if ($code) : ?>
                            <a class="btn btn-btn mb-3" href="game_comment_form.php?game_code=<?= $get_code ?>">ゲームコメント追加</a>
                        <?php endif; ?>


                        <div class="row g-3">
                            <?php
                            if ($code) :
                                $rows = get_rows("game_comment", null, "and game_code=$code");
                                foreach ($rows as $row) : $comment_code = zerop($row['code'], 7);
                            ?>
                                    <div class="col-md-1">
                                        <a href="game_comment_form.php?code=<?= $comment_code ?>"><img src="../staff/<?= $comment_code ?>_md_01.jpg" class="img-fluid"></a>
                                    </div>
                                    <div class="col-md-11">
                                        <h4><a href="game_comment_form.php?code=<?= $comment_code ?>"><?= h($row['comment_title']) ?></a></h4>
                                        <?= h($row['comments']) ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>


                    </div>

                </div>







                <input type="hidden" name="table" value="<?= $table ?>">
                <input type="hidden" name="folder" value="<?= $table ?>">
                <?php if ($code) : ?>
                    <input type="hidden" name="code" value="<?= $code ?>">
                <?php else : ?>
                    <input type="hidden" name="next_location" value="<?= $table ?>_list.php">
                <?php endif; ?>
                <input type="submit" class="btn btn-btn px-5" value="登録">
                <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
            </form>

        </section>

        <?php if ($code) : ?>
            <section class="container-fluid mt-5">
                <hr>
                <!-- Button trigger modal -->
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="<?= $table ?>_list.php" class="btn btn-btn">ゲーム一覧</a>
                        <a href="copy.php?table=<?= $table ?>&code=<?= $code ?>" class="btn btn-btn">コピー</a>
                    </div>
                    <button type="button" class="btn btn-cred" data-bs-toggle="modal" data-bs-target="#modal">
                        データ削除
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">削除しますか？</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>データを削除すると元に戻すことはできません。</p>
                                <div class="alert alert-danger">削除対象 : <?= h($row['game_title']) ?></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a class="btn btn-cred" href="delete.php?table=<?= $table ?>&code=<?= $row['code'] ?>">削除</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>



        <script>
            function block_add(e) {
                let game_details = e.closest("#game_details");
                let elm = game_details.cloneNode(true);
                game_details.after(elm);
            }

            function block_del(e) {
                let game_details = e.closest("#game_details");
                game_details.remove();
            }
        </script>


    </div>

    <?php
    require("foot.php");
    require("js_datepicker.php");
    require("js_thumb.php");
    ?>
