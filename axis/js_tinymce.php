<?php
$domain = (empty($_SERVER['HTTPS']) ? "http://" : "https://") . $_SERVER['SERVER_NAME'];
?>

<script>
  tinymce.init({
    selector: '#article',
    deprecation_warnings: false,
    placeholder: '',
    images_upload_handler: function(blobInfo, success, failure) {
      var xhr, formData;

      xhr = new XMLHttpRequest();
      xhr.withCredentials = false;
      xhr.open('POST', 'image_upload.php'); // uploader

      xhr.onload = function() {
        var json;

        if (xhr.status != 200) {
          failure('HTTP Error: ' + xhr.status);
          return;
        }

        json = JSON.parse(xhr.responseText);

        if (!json || typeof json.location != 'string') {
          failure('Invalid JSON: ' + xhr.responseText);
          return;
        }

        success(json.location);
      };

      formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());

      xhr.send(formData);
    },
    language: "ja",
    content_css: "../css/article.css?v=<?= date("YmdHis") ?>",
    menubar: false,

    // 画像アップロード時にURLを相対パスにするのを禁止し、絶対パスで表示させる
    document_base_url: '<?= $domain ?>',
    relative_urls: false,
    remove_script_host: false,

    // Pタグによる囲みを解除
    // forced_root_block:'',

    plugins: 'link code table image imagetools textcolor preview media hr lists anchor autolink autosave emoticons',
    toolbar: [
      'formatselect styleselect | fontsizeselect forecolor bold italic | undo redo | numlist bullist | anchor',
      'alignleft aligncenter alignright alignjustify | link openlink image media hr | emoticons | table tablecellprops tablemergecells tablesplitcells tablerowprops | code | preview'
    ],
    style_formats: [{
        title: 'ボックス Light Gray',
        block: 'div',
        classes: 'box01'
      },
      {
        title: 'ボックス Black',
        block: 'div',
        classes: 'box-black'
      },
      {
        title: 'ボックス Key Color',
        block: 'div',
        classes: 'box-kc'
      },
      {
        title: 'ボックス Sub Color',
        block: 'div',
        classes: 'box-sc'
      },
      {
        title: 'ボックス Red',
        block: 'div',
        classes: 'box-red'
      },
      {
        title: 'ボックス Blue',
        block: 'div',
        classes: 'box-blue'
      },
      {
        title: 'ボックス Green',
        block: 'div',
        classes: 'box-green'
      },
      {
        title: 'ボックス Orange',
        block: 'div',
        classes: 'box-orange'
      },
      {
        title: 'フォントカラー Key Color',
        inline: 'span',
        classes: 'font-color-kc'
      },
      {
        title: 'フォントカラー Sub Color',
        inline: 'span',
        classes: 'font-color-sc'
      },
      {
        title: 'フォントカラー Red',
        inline: 'span',
        classes: 'font-color-red'
      },
      {
        title: 'フォントカラー Blue',
        inline: 'span',
        classes: 'font-color-blue'
      },
      {
        title: 'フォントカラー Green',
        inline: 'span',
        classes: 'font-color-green'
      },
      {
        title: 'フォントカラー Orange',
        inline: 'span',
        classes: 'font-color-orange'
      },
      {
        title: 'マーカー Key Color',
        inline: 'span',
        classes: 'marker-kc'
      },
      {
        title: 'マーカー Sub Color',
        inline: 'span',
        classes: 'marker-sc'
      },
      {
        title: 'マーカー Red',
        inline: 'span',
        classes: 'marker-red'
      },
      {
        title: 'マーカー Blue',
        inline: 'span',
        classes: 'marker-blue'
      },
      {
        title: 'マーカー Green',
        inline: 'span',
        classes: 'marker-green'
      },
      {
        title: 'マーカー Orange',
        inline: 'span',
        classes: 'marker-orange'
      },
      {
        title: '下線 Key Color',
        inline: 'span',
        classes: 'underline-kc'
      },
      {
        title: '下線 Sub Color',
        inline: 'span',
        classes: 'underline-sc'
      },
      {
        title: '下線 Red',
        inline: 'span',
        classes: 'underline-red'
      },
      {
        title: '下線 Blue',
        inline: 'span',
        classes: 'underline-blue'
      },
      {
        title: '下線 Green',
        inline: 'span',
        classes: 'underline-green'
      },
      {
        title: '下線 Orange',
        inline: 'span',
        classes: 'underline-orange'
      },
      {
        title: '画像2列',
        selector: 'img',
        classes: 'img-2col'
      },
      {
        title: '画像3列',
        selector: 'img',
        classes: 'img-3col'
      },
      {
        title: '画像4列',
        selector: 'img',
        classes: 'img-4col'
      },
    ],
    autosave_ask_before_unload: false,
    autosave_interval: '10s'
  });
</script>
