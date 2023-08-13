<section class="container">
  <div class="row justify-content-center mb-5">
    <div class="col-md-8">
      <div class="contact-box px-5 py-md-5 px-md-4">

        <div class="text-center mb-4">
          <h2 class="fc-kc">Contact</h2>
          <small>お問い合わせ</small>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-md-4 mb-4">

          <div class="col partition">
            <div class="d-flex align-items-center justify-content-center p-3">
              <i class='bx bx-fw bx-mobile-alt bx-lg'></i>
              <div>
                <div>お電話でのお問い合わせ</div>
                <?php if ($com_free_dial) : ?>
                  <h2><a href="tel:<?= $com_free_dial ?>"><?= $com_free_dial ?></a></h2>
                <?php else : ?>
                  <h2><a href="tel:<?= $com_tel ?>"><?= $com_tel ?></a></h2>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="d-flex align-items-center justify-content-center p-3">
              <i class='bx bx-fw bx-message-square-dots bx-lg'></i>
              <div>
                <div class="mb-1">ご質問・お問い合わせ</div>
                <a href="contact_form.html" class="btn btn-btn">お問い合わせフォーム</a>
              </div>
            </div>
          </div>

        </div>

        <div class="text-md-center">商品・サービスへのご質問・ご不明な点などがありましたら、お気軽にお問い合わせください。</div>

      </div>
    </div>
  </div>
</section>



</main>

<footer class="px-3">
  <div class="container">
    <div class="row row-cols-1 row-cols-2 row-cols-md-4 g-5 mb-4">

      <div class="col-12 col-md-3">
        <?php
        if ($logo = imageCheck("image", "logo-dark", false)) :
        ?>
          <a href="./"><img src="<?= $logo ?>" class="img-fluid logo-foot" alt="<?= $site_catch ?> <?= $site_name ?>"></a>
        <?php else : ?>
          <h2><?= h($site_name) ?></h2>
        <?php endif; ?>
        <hr>
        <div class="mb-2"><?= h($com_name) ?></div>
        <div class="fs08">
          <div>〒<?= h($com_zip) ?></div>
          <div><?= h($com_add) ?></div>
          <div><a href=" tel:<?= h($com_tel) ?>">TEL <?= h($com_tel) ?></a></div>
          <?php if ($com_fax) : ?>
            <div>FAX <?= h($com_fax) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="col d-none d-md-block">
        <h2>Heading Line</h2>
        <ul>
          <li><a href="">Contents</a></li>
          <li><a href="">Contents</a></li>
          <li><a href="">Contents</a></li>
          <li><a href="">Contents</a></li>
        </ul>
      </div>

      <div class="col d-none d-md-block">
        <h2>オンラインストア</h2>
        <ul>
          <li><a href="item_list.html">商品一覧</a></li>
          <li><a href="cart01.html">カートを見る</a></li>
          <li><a href="delivery_list.html">送料について</a></li>
        </ul>
      </div>

      <div class="col-12 col-md-3">
        <h2>About Us</h2>
        <ul>
          <li><a href="faq_list.html">よくあるご質問</a></li>
          <li><a href="privacy.html">プライバシーポリシー</a></li>
          <li><a href="law.html">特商法に基づく表記</a></li>
          <li><a href="contact_form.html">お問い合わせ</a></li>
          <li><a href="about.html">会社概要</a></li>
        </ul>
      </div>

    </div>


    <?php
    require("sns_link.php");
    ?>



  </div>
</footer>

<div class="copyright py-2">Copyright <?= date("Y") ?> <?= h($com_copyright_name) ?> Allright Reserved.</div>



<script src="js/wow.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="js/main.js"></script>
<?= get_cdn_footer() ?>


</body>

</html>
