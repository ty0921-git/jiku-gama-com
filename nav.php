<header>
  <nav>
    <div class="container d-flex justify-content-between">

      <div class="logo-head">
        <a href="./"><img src="image/logo-dark.svg"></a>
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
        <ul class="min">
          <li><a href="./">ホーム<small>Home</small></a></li>
          <li><a href="./gallery.html">ギャラリー<small>Gallery</small></a></li>
          <li><a href="./profile.html">陶芸家<small>Profile</small></a></li>
          <li><a href="./about.html">アクセス<small>Access</small></a></li>
          <li><a href="./contact_form.html">お問い合わせ<small>Contact</small></a></li>
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
