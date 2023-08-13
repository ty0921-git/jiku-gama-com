<?php
require("head.php");

if ($_GET['code']) {
  $code = $_GET['code'];
} else {
  header("location:./");
  exit;
}

$sql = "select*from item where code='$code'";
$stmt = connect()->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row['display'] == "0") {
  header("location:./");
  exit;
}

$row['code'] = zerop($row['code'], 7);
?>
<link rel="stylesheet" href="css/article.css">
<title><?= h($row['item_name']) ?> | <?= h($site_catch) ?> <?= h($site_name) ?></title>
</head>

<body>
  <?php
  require("nav.php");
  ?>
  <section class="p-2 p-md-4"></section>

  <section class="container mb-4">
    <a href="./">Home</a> <i class='bx bx-chevron-right'></i> <a href="item_list.html">商品一覧</a>
  </section>

  <div class="container mb-5">
    <div class="row g-3 g-md-5">
      <div class="col-md-6">


        <?php if ($img = imageCheck("item", "{$code}_lg_01", false)) : ?>
          <section>
            <img name="item_image" src="<?= $img ?>" class="img-fluid mb-3">
          </section>
        <?php endif; ?>

        <div class="row row-cols-6 g-1">
          <?php
          for ($i = 1; $i <= 20; $i++) : $num = zerop($i, 2);
            $img = imageCheck("item", "{$code}_sm_{$num}", false);
            if (empty($img)) {
              continue;
            } else {
              $ext = pathinfo($img, PATHINFO_EXTENSION);
            }
          ?>
            <div class="col">
              <div class="thumb01" style="cursor:pointer;background-image:url(<?= $img ?>)" onclick="document.item_image.src='item/<?= $code ?>_lg_<?= $num ?>.<?= $ext ?>'"></div>
            </div>
          <?php endfor; ?>
        </div>


      </div>
      <div class="col-md-6">
        <div class="mb-1">
          <?php if ($row['maker']) : ?><?= h($row['maker']) ?><?php endif; ?>
          <?php if ($row['brand']) : ?><?= h($row['brand']) ?><?php endif; ?>
        </div>
        <h2 class="mb-4"><?= h($row['item_name']) ?></h2>

        <?php if ($row['short_description']) : ?>
          <div class="mb-3"><?= h($row['short_description']) ?></div>
        <?php endif; ?>

        <?php if (!$row['delivary']) {
          $delivary = "001";
        } else {
          $delivary = $row['delivary'];
        } ?>
        <?php
        $sql = "select*from delivary where code='$delivary'";
        $stmt = connect()->query($sql);
        $deli_row = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <span class="badge bg-kc">配送区分</span> <?= h($deli_row['delivary_name']) ?> [ <a href="delivary_list.html">送料一覧</a> ]

        <?php if ($deli_row['flag_include'] == 1) : ?>
          <div class="alert-red p-3 mt-3">この商品は、同梱不可商品です。他の商品と一緒にご購入される場合は、送料が別途加算されます。送料については送料一覧をご確認ください。</div>
        <?php endif; ?>

        <form class="my-4" action="cart_in.php" method="POST">

          <div class="mb-4">
            <?php
            $price_data = explode("\n", $row['price']);
            $price_data = array_filter($price_data);
            if (count($price_data) == 1) : list(, $price) = explode("<>", $price_data[0]);
              $flag = "on";
            ?>
              <div>販売価格 <span class="fs20"><?= d(taxin($price)) ?></span> 円（税込）</div>
            <?php else : ?>
              <table>
                <?php
                $i = 1;
                foreach ($price_data as $price_set) : list($price_label, $price) = explode("<>", $price_set);
                ?>
                  <tr>
                    <td><input class="form-check-input me-3" type="radio" name="price" id="price<?= $i ?>" value="<?= $price_label ?><><?= taxin($price) ?>" required></td>
                    <td class="fs16 pe-3"><label for="price<?= $i ?>"><?= h($price_label) ?></label></td>
                    <td class="text-end"><label for="price<?= $i ?>"><span class="fs20"><?= d(taxin($price)) ?></span> 円（税込）</label></td>
                  </tr>
                <?php $i++;
                endforeach; ?>
              </table>
            <?php endif; ?>
          </div>


          <div class="d-flex align-items-center mb-4">
            <label class="me-3" for="qty">個数</label>
            <div>
              <select name="qty" class="form-select">
                <?php for ($i = 1; $i <= 10; $i++) : ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>


          <input class="btn btn-btn" type="submit" value="カートに入れる">
          <input type="hidden" name="code" value="<?= $code ?>">
          <input type="hidden" name="item_name" value="<?= $row['item_name'] ?>">
          <?php if ($flag == "on") : ?>
            <input type="hidden" name="price" value="<><?= taxin($price) ?>">
          <?php endif; ?>
          <input type="hidden" name="delivary" value="<?= zerop($row['delivary'], 3) ?>">
          <input type="hidden" name="flag_include" value="<?= $deli_row['flag_include'] ?>">
          <input type="hidden" name="delivary_group" value="<?= $deli_row['delivary_group'] ?>">
        </form>



        <?php if ($row['notes']) : ?>
          <div class="mb-3"><?= nl2br(h($row['notes'])) ?></div>
        <?php endif; ?>

        <section class="mb-5">
          <?php require("sns_button.php"); ?>
        </section>

      </div>
    </div>
  </div>


  <section class="container mb-5">
    <div id="article"><?= $row['description'] ?></div>
  </section>



  <?php
  require("foot.php");
  ?>
