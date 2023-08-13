<section class="g-nav">
    <div class="pt-3 ps-3">
        AXIS - <small>CMS</small>
    </div>
    <hr>
    <ul>
        <li><i class='bx bx-home'></i><a href="main.php">HOME</a></li>
        <li class="dropdown">
            <i class='bx bx-pencil'></i><a href="#">ポスト</a>
            <ul>
                <li><a href="post_list.php">ポスト一覧</a></li>
                <li><a href="post_form.php">ポスト登録</a></li>
                <li><a href="category_form.php?key=post">カテゴリー</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <i class='bx bx-package'></i><a href="#">アイテム</a>
            <ul>
                <li><a href="item_list.php">アイテム一覧</a></li>
                <li><a href="item_form.php">アイテム登録</a></li>
                <li><a href="category_form.php?key=item">カテゴリー</a></li>
                <li><a href="category_form.php?key=colle">コレクション</a></li>
                <li><a href="category_form.php?key=temp">温度帯</a></li>
                <li><a href="category_form.php?key=maker">メーカー</a></li>
                <li><a href="category_form.php?key=brand">ブランド</a></li>
            </ul>
        </li>
        <li><i class='bx bx-bell'></i><a href="order_list.php">オーダー</a></li>
        <li class="dropdown">
            <i class='bx bx-book'></i><a href="#">アーカイブ</a>
            <ul>
                <li><a href="archive_list.php">アーカイブ一覧</a></li>
                <li><a href="archive_form.php">アーカイブ登録</a></li>
                <li><a href="category_form.php?key=archive">カテゴリー</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <i class='bx bx-map-pin'></i><a href="#">スポット</a>
            <ul>
                <li><a href="spot_list.php">スポット一覧</a></li>
                <li><a href="spot_form.php">スポット登録</a></li>
                <li><a href="category_form.php?key=spot">カテゴリー</a></li>
                <li><a href="category_form.php?key=facility">設備</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <i class='bx bx-user'></i><a href="#">スタッフ</a>
            <ul>
                <li><a href="staff_list.php">スタッフ一覧</a></li>
                <li><a href="staff_form.php">スタッフ登録</a></li>
                <li><a href="category_form.php?key=staff">カテゴリー</a></li>
            </ul>
        </li>
        <li class="dropdown">
        <i class='bx bxs-analyse'></i><a href="#">ゲーム</a>
            <ul>
                <li><a href="game_list.php">ゲーム一覧</a></li>
                <li><a href="game_form.php">ゲーム登録</a></li>
                <li><a href="category_form.php?key=game">カテゴリー</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <i class='bx bx-briefcase-alt-2'></i><a href="#">リクルート</a>
            <ul>
                <li><a href="recruit_list.php">リクルート一覧</a></li>
                <li><a href="recruit_form.php">リクルート登録</a></li>
                <li><a href="category_form.php?key=recruit">カテゴリー</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <i class='bx bx-file'></i><a href="#">ページ</a>
            <ul>
                <li><a href="page_list.php">ページ一覧</a></li>
                <li><a href="page_form.php">ページ登録</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <i class='bx bx-chat'></i><a href="#">FAQ</a>
            <ul>
                <li><a href="faq_list.php">FAQ一覧</a></li>
                <li><a href="faq_form.php">FAQ登録</a></li>
                <li><a href="category_form.php?key=faq">カテゴリー</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <i class='bx bx-face'></i><a href="#">コンタクト</a>
            <ul>
                <li><a href="mailsend_form.php">メール一斉送信</a></li>
                <li><a href="contact_list.php">コンタクト一覧</a></li>
                <li><a href="contact_form.php">コンタクト登録</a></li>
                <li><a href="category_form.php?key=contact">カテゴリー</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <i class='bx bx-mail-send'></i><a href="#">メール</a>
            <ul>
                <li><a href="mailtemp_list.php">テンプレート一覧</a></li>
                <li><a href="mailtemp_form.php">テンプレート登録</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <i class='bx bx-cog'></i><a href="#">設定</a>
            <ul>
                <li><a href="setting_base_form.php">基本設定</a></li>
                <li><a href="setting_image_form.php">イメージ設定</a></li>
                <li><a href="setting_post_form.php">ブログ設定</a></li>
                <li><a href="setting_cdn_form.php">CDN設定</a></li>
                <li><a href="setting_shop_form.php">ショップ設定</a></li>
                <li><a href="delivary_list.php">送料設定</a></li>
                <li><a href="setting_game_form.php">ゲーム設定</a></li>
            </ul>
        </li>
        <hr>
        <li><i class='bx bx-log-out'></i><a href="logout.php">ログアウト</a></li>
    </ul>

</section>

<script>
    let dd = document.querySelectorAll('.dropdown');

    function activeLink() {
        // dd.forEach((item) => item.classList.remove("show"));
        this.classList.toggle("show");
    }
    dd.forEach((item) => item.addEventListener("click", activeLink));
</script>