<?php
require("head.php");

// テーブル指定
$table = "mailtemp";

// ゲット変数の無害化処理
$get_code = h(filter_input(INPUT_GET, 'code'));


// コード指定データ取得
if ($get_code) {
    $sql = "select*from $table where code=$get_code";
    $stmt = connect()->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $code = zerop($row['code'], 7);
} else {
    $row['date_regi'] = date("Y-m-d");
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


                <div class="row">
                    <div class="col-md-9">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="mailtemp_name" id="mailtemp_name" placeholder="#" value="<?= h($row['mailtemp_name']) ?>">
                            <label for="mailtemp_name">テンプレート名</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="mail_title" id="mail_title" placeholder="#" value="<?= h($row['mail_title']) ?>">
                            <label for="mail_title">メールタイトル</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="call_code" id="call_code" placeholder="#" value="<?= h($row['call_code']) ?>">
                            <label for="call_code">コールコード</label>
                        </div>


                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="mail_body" id="mail_body" placeholder="#" style="height:500px;"><?= h($row['mail_body']) ?></textarea>
                            <label for="mail_body">メール本文</label>
                        </div>

                    </div>


                    <div class="col-md-3">


                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="memo" id="memo" placeholder="#" style="height:100px;"><?= h($row['memo']) ?></textarea>
                            <label for="memo">メモ</label>
                        </div>


                        <div class="form-floating mb-3">
                            <select class="form-select" id="support" name="support">
                                <option selected value="">選択してください</option>
                                <option value="on" <?php if ($row['support'] == "on") print "selected"; ?>>一斉送信対応</option>
                            </select>
                            <label for="support">対応</label>
                        </div>


                    </div>


                </div>







                <input type="hidden" name="table" value="<?= $table ?>">
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
                    <a href="<?= $table ?>_list.php" class="btn btn-btn">テンプレート一覧</a>
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
                                <div class="alert alert-danger">削除対象 : <?= h($row['mailtemp_name']) ?></div>
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



    </div>

    <?php
    require("foot.php");
    require("js_datepicker.php");
    ?>
