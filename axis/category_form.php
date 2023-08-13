<?php
require("head.php");

if (empty($_GET['key'])) {
    $_SESSION['message'] = "key指定がありません。";
    header("location:./message.php");
    exit;
} else {
    $key = h($_GET['key']);
}

switch ($key) {
    case "colle":
        $headline = "コレクション";
        break;
    case "temp":
        $headline = "温度帯";
        break;
    case "maker":
        $headline = "メーカー";
        break;
    case "brand":
        $headline = "ブランド";
        break;
    case "facility":
        $headline = "設備";
        break;
    default:
        $headline = "カテゴリー";
}


// ゲット変数の無害化処理
$get_code = h(filter_input(INPUT_GET, 'code'));


if ($get_code) {
    $code = $get_code;
    $sql = "select*from category where code='$code' and allocation='$key'";
    $stmt = connect()->query($sql);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
}


$sql = "select*from category where allocation='$key' order by sort ASC";
$stmt = connect()->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<title>AXIS</title>
</head>

<body class="d-flex">
    <?php
    require("nav.php");
    ?>

    <div class="w-100">
        <section class="container-fluid p-5">
            <h4><?= $headline ?>設定</h4>
            <hr class="mb-5">

            <form action="db_op.php" method="POST">
                <div class="row g-2">

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="cate_name" id="cate_name" placeholder="#" value="<?= h($category['cate_name']) ?>">
                            <label for="cate_name"><?= $headline ?>名</label>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="call_code" id="call_code" placeholder="#" value="<?= h($category['call_code']) ?>">
                            <label for="call_code">コールコード</label>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <input type="submit" class="btn btn-btn h-100 w-100" value="登録">
                        <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
                    </div>

                </div>
                <?php if ($code) : ?>
                    <input type="hidden" name="code" value="<?= $code ?>">
                    <input type="hidden" name="call_code_ex" value="<?= $category['call_code'] ?>">
                <?php endif; ?>
                <input type="hidden" name="allocation" value="<?= $key ?>">
                <input type="hidden" name="table" value="category">
            </form>

            <?php if ($code) : ?>
                <div class="d-flex justify-content-between mt-5">
                    <a href="category_form.php?key=<?= $key ?>" class="btn btn-btn"><?= $headline ?>一覧</a>
                    <button type="button" class="btn btn-cred h-100" data-bs-toggle="modal" data-bs-target="#modal_<?= $code ?>">削除</button>
                </div>
            <?php endif; ?>
        </section>





        <div class="modal fade" id="modal_<?= $code ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">削除しますか？</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>カテゴリーを削除すると元に戻すことはできません。該当するカテゴリーに分類されているデータは、未分類となります。</p>
                        <div class="alert alert-danger">削除対象 : <?= $category['cate_name'] ?></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="delete_category.php?code=<?= $code ?>&key=<?= $key ?>&call_code=<?= $category['call_code'] ?>" class="btn btn-cred">削除</a>
                    </div>
                </div>
            </div>
        </div>






        <?php if (!$get_code) : ?>
            <section class="container-fluid p-5">
                <h4><?= $headline ?>リスト</h4>
                <hr class="mb-5">
                <form action="sort.php" method="POST">
                    <div id="sortable" class="mb-5">
                        <?php if ($rows) : $i = 0; ?>
                            <?php foreach ($rows as $row) : $code = zerop($row['code'], 3); ?>

                                <div class="row g-2 mb-1" id="row">
                                    <div class="col-md-2">
                                        <div><span class="drag-area"><i class="bi bi-filter-left"></i></span><?= h($row['allocation']) ?></div>
                                    </div>
                                    <div class="col-md-2">
                                        <div><?= h($row['call_code']) ?></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div><?= h($row['cate_name']) ?></div>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control sort" type="text" name="sort[]" id="sort" value="<?= h($row['sort']) ?>">
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-btn" href="category_form.php?key=<?= $key ?>&code=<?= $code ?>">編集</a>
                                    </div>
                                    <input type="hidden" name="code[]" value="<?= $code ?>">
                                </div>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="table" value="category">
                    <input class="btn btn-btn px-5" type="submit" value="並び替え">
                </form>
            </section>
        <?php endif; ?>

    </div>




    <?php
    require("foot.php");
    ?>
    <script src="js/sortable/sortable.js"></script>
