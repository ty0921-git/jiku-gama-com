// WOW
new WOW().init();

// スクロール位置取得
let nav = document.querySelector("nav");

window.addEventListener("scroll", function () {
  let sc = window.pageYOffset;
  let panel = document.querySelector(".collapse");
  if (panel) {
    panel.classList.remove("show");
  }
  if (sc > 0) {
    nav.classList.add("nav-alfa");
  } else {
    nav.classList.remove("nav-alfa");
  }
});

// OGPタイトル差し込み
let title = document.title;
let ogp_title = document.head.querySelector("[property $=title]");
ogp_title.content = title;

// ドロップダウンメニュー
document.addEventListener("DOMContentLoaded", function () {
  let dropdowns = document.querySelectorAll(".dropdown");

  dropdowns.forEach(function (dropdown) {
    dropdown.addEventListener("click", function (event) {
      event.stopPropagation(); // このイベントが親要素に伝播するのを阻止
      let dropdownMenus = document.querySelectorAll(".dropdown-menu.show");
      let thisMenu = this.querySelector(".dropdown-menu");
      dropdownMenus.forEach(function (menu) {
        // クリックされたメニュー以外を非表示
        if (menu !== thisMenu) {
          menu.classList.remove("show");
        }
      });
      // クリックされたメニューの表示状態を切り替える
      thisMenu.classList.toggle("show");
    });
  });

  // メニュー以外の部分がクリックされたら全てのメニューを非表示にする
  document.addEventListener("click", function () {
    let dropdownMenus = document.querySelectorAll(".dropdown-menu.show");
    dropdownMenus.forEach(function (menu) {
      menu.classList.remove("show");
    });
  });
});
