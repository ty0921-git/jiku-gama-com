<?php
$login_check="off";
require("head.php");
?>
<title>AXIS</title>
</head>

<body>


  <section class="container d-flex justify-content-center align-items-center" style="height:100vh;">

    <div class="row justify-content-center w-100">
      <div class="col-md-5">

        <h1>AXIS</h1>
        <form action="login.php" method="POST">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="id" id="id" placeholder="name@example.com" required>
            <label for="id">ID</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            <label for="password">パスワード</label>
          </div>
          <input type="submit" class="btn btn-dark" value="ログイン">
          <input type="hidden" name="csrf_token" value="<?= h(setToken()) ?>">
        </form>

      </div>
    </div>

  </section>




  <?php
  require("foot.php");
  ?>
