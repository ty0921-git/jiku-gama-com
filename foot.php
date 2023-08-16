<div class="p-0 p-md-5"></div>
<section class="container">
  <div class="row justify-content-center mb-5">
    <div class="col-md-8">
      <div class="contact-box px-5 py-md-5 px-md-4">

        <div class="text-center mb-4">
          <h2 class="fs14 fc-kc min wsnw">お問い合わせ</h2>
          <small>Contact</small>
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
      </div>
    </div>
  </div>
</section>



</main>

<footer class="px-3 min">
  <div class="container">
    <div class="row row-cols-1 row-cols-2 row-cols-md-4 g-5">

      <div class="col-12 col-md-3">
        <?php
        if ($logo = imageCheck("image", "logo-dark", false)) :
        ?>
          <a href="./"><img src="<?= $logo ?>" class="img-fluid logo-foot" alt="<?= $site_catch ?> <?= $site_name ?>"></a>
        <?php else : ?>
          <h2><?= h($site_name) ?></h2>
        <?php endif; ?>
        <hr>
        <div class="mb-2 min"><?= h($com_name) ?> | 陶芸家・峰とし子公式サイト</div>
        <!-- <div class="fs08">
          <div>〒<?= h($com_zip) ?></div>
          <div><?= h($com_add) ?></div>
          <div><a href=" tel:<?= h($com_tel) ?>">TEL <?= h($com_tel) ?></a></div>
          <?php if ($com_fax) : ?>
            <div>FAX <?= h($com_fax) ?></div>
          <?php endif; ?>
        </div> -->
      </div>

      <div class="col-12 col-md-9">
        <div class="d-flex flex-md-row flex-column align-items-start justify-content-md-between">
          <a class="border-f border-gray text-center flex-grow-1" href="./">ホーム</a>
          <a class="border-f border-gray text-center flex-grow-1" href="gallery.html">ギャラリー</a>
          <a class="border-f border-gray text-center flex-grow-1" href="profile.html">陶芸家</a>
          <a class="border-f border-gray text-center flex-grow-1" href="privacy.html">プライバシーポリシー</a>
          <a class="border-f border-gray text-center flex-grow-1" href="about.html">アクセス</a>
          <a class="border-f border-gray text-center flex-grow-1" href="contact_form.html">お問い合わせ</a>
        </div>
        <div class="copyright py-2 pt-5 text-center text-md-end">Copyright <?= date("Y") ?> <?= h($com_copyright_name) ?> Allright Reserved.</div>
      </div>

    </div>



  </div>
</footer>



<script src="js/wow.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="js/main.js"></script>
<?= get_cdn_footer() ?>


</body>

</html>
