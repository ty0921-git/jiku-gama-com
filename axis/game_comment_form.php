<?php
require("head.php");

// ゲット変数の無害化処理
$game_code = h(filter_input(INPUT_GET, 'game_code'));
$code = h(filter_input(INPUT_GET, 'code'));

if ($code) {
    $row = get_row("game_comment", $code);
    if (!empty($row)) {
        foreach ($row as $key => $val) {
            $$key = h($val);
        }
    }
}

?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <section class="container-fluid p-5">
        <h4>ゲームコメント追加</h4>
        <hr class="mb-5">

        <form action="db_op_as.php" method="POST">

            <div class="row mb-4">
                <div class="col-md-6">

                    <div class="form-floating mb-3">
                        <select class="form-select" id="staff_code" name="staff_code">
                            <option value="">選択してください</option>
                            <?php
                            $rows = get_rows("staff", null, null);
                            foreach ($rows as $row) : $staff_id = zerop($row['code'], 7);
                            ?>
                                <option value="<?= h($staff_id) ?>" <?php if ($staff_id == $staff_code) print "selected" ?>><?= h($row['staff_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="staff_code">発信者</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="comment_title" id="comment_title" placeholder="#" value="<?= $comment_title ?>">
                        <label for="comment_title">コメントタイトル</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="comments" id="comments" placeholder="#" style="height:500px;"><?= $comments ?></textarea>
                        <label for="comments">コメント</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="display" name="display">
                            <option selected value="1" <?php if ($display == "1") {
                                                            print "selected";
                                                        } ?>>表示</option>
                            <option value="0" <?php if ($display == "0") {
                                                    print "selected";
                                                } ?>>非表示</option>
                        </select>
                        <label for="display">表示設定</label>
                    </div>


                </div>

            </div>


            <?php if ($code) : ?>
                <input type="hidden" name="code" value="<?= $code ?>">
                <div class="mb-4"><a href="game_form.php?code=<?= $game_code ?>">ゲーム詳細に戻る</a></div>
            <?php endif; ?>
            <?php if ($_GET['game_code']) : ?>
                <input type="hidden" name="game_code" value="<?= $game_code ?>">
                <input type="hidden" name="next_location" value="game_form.php?code=<?= $game_code ?>">
            <?php endif; ?>
            <input type="hidden" name="table" value="game_comment">
            <input type="hidden" name="folder" value="game_comment">
            <input type="submit" class="btn btn-btn px-5" value="登録">
            <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
        </form>


    </section>



    <?php
    require("foot.php");
    ?>
