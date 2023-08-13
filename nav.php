<header>
  <nav>
    <div class="container d-flex justify-content-between">

      <div class="logo-head">
        <?php
        if ($logo = imageCheck("image", "logo-dark", false)) :
        ?>
          <h1 class="fs06 mb-1" style="white-space:nowrap;"><?= $site_catch ?><?= $site_name ?></h1>
          <a href="./"><img src="<?= $logo ?>" class="img-fluid" alt="<?= $site_catch ?> <?= $site_name ?>"></a>
        <?php else : ?>
          <h1 class="fs06 mb-1"><?= $site_catch ?></h1>
          <a class="navbar-brand" href="./"><?= $site_name ?></a>
        <?php endif; ?>
      </div>

      <div class="d-flex align-items-center">
        <label for="switch" class="open text-white px-3">
          <span></span>
          <span></span>
          <span></span>
        </label>
        <label for="switch" class="back"></label>
      </div>

      <input id="switch" type="checkbox">
      <div id="menu">
        <div class="text-end p-2 d-md-none d-block">
          <label for="switch" class="close d-inline-block text-white p-2"><i class='bx bx-md bx-x'></i></label>
        </div>
        <ul>
          <li><a href="./">HOME<small>ホーム</small></a></li>
          <li class="dropdown"><a href="#">DROPDOWN<small>ドロップダウン</small></a>
            <ul class="dropdown-menu">
              <li><a href="#">subMenu</a></li>
              <li><a href="#">subMenu</a></li>
              <li><a href="#">subMenu</a></li>
            </ul>
          </li>
          <li><a href="./news_list.html">News<small>ニュース</small></a></li>
          <li><a href="./blog_list.html">Blog<small>ブログ</small></a></li>
          <li><a href="./item_list.html">Item<small>アイテム</small></a></li>
          <li><a href="./archive_list.html">Archive<small>アーカイブ</small></a></li>
          <li><a href="./spot_list.html">Spot<small>スポット</small></a></li>
          <li><a href="./staff_list.html">Staff<small>スタッフ</small></a></li>
          <li><a href="./team.html">TEAM<small>チーム</small></a></li>
          <li><a href="./cart01.html">Cart<small>カート</small></a></li>
        </ul>

        <div class="d-md-none d-block mb-5">
          <?php
          require("sns_link.php");
          ?>
        </div>

      </div>

    </div>
  </nav>
</header>


<main class="contents">
