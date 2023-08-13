<?php
//OGP設定
$ogp_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$host = "https://" . $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];

// OGPページタイプ
$ogp_pages = [
    "news_detail" => ["ogp_type" => "article", "folder" => "post"],
    "blog_detail" => ["ogp_type" => "article", "folder" => "post"],
    "item_detail" => ["ogp_type" => "website", "folder" => "item"],
    "archive_detail" => ["ogp_type" => "website", "folder" => "archive"],
    "spot_detail" => ["ogp_type" => "website", "folder" => "spot"],
    "staff_detail" => ["ogp_type" => "website", "folder" => "staff"],
    "recruit_detail" => ["ogp_type" => "website", "folder" => "recruit"],
];

$ogp_type = "website";
$ogp_folder = "image";
$ogp_image = "ogp-image.jpg";
foreach ($ogp_pages as $key => $val) {
    if (strpos($uri, $key) !== false) {
        $ogp_type = $val['ogp_type'];
        $ogp_folder = $val['folder'];
    }
}

// OGPイメージ判定
if ($ogp_folder != "image") {
    $ogp_image_url = imageCheck($ogp_folder,"{$_GET['code']}_md_01", false);
    if ($ogp_image_url) {
        $ogp_image = str_replace("./$ogp_folder/", "", $ogp_image_url);
    } else {
        $ogp_folder = "image";
    }
}
?>

<?php if ($uri == "/" || $uri == "/index.html") : ?>

    <head prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb# website:http://ogp.me/ns/website#">
    <?php else : ?>

        <head prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb# article:http://ogp.me/ns/article#">
        <?php endif; ?>

        <!-- OGP -->
        <meta property="og:url" content="<?= $ogp_url ?>">
        <meta property="og:type" content="<?= $ogp_type ?>">
        <meta property="og:image" content="<?= $host ?>/<?= $ogp_folder ?>/<?= $ogp_image ?>">
        <meta property="og:title" content=""> <!-- main.js より差し込み -->
        <meta property="og:site_name" content="<?= $site_name ?>">
        <meta name="twitter:card" content="summary_large_image">
        <!-- OGP -->

        <?= PHP_EOL ?>