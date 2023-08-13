<?php
// エラー
ini_set('display_errors', 1);
require("../function.php");
// セットアップ設定
$admin_id = "info@adisign.net";
$admin_pass = "adiadi1021";


// 存在するテーブルを配列に格納
$sql = "show tables";
$stmt = connect()->query($sql);
$table = $stmt->fetchAll(PDO::FETCH_COLUMN);




///////////////////////////////
// 管理者ログイン情報テーブル作成
///////////////////////////////

if (!in_array('administrator', $table)) {
  $sql = "create table if not exists administrator(
  code int(7) zerofill auto_increment primary key,
  id varchar(200) not null,
  password varchar(200) not null
  )";
  connect()->query($sql);

  // 初期ユーザー登録
  $admin_pass = password_hash($admin_pass, PASSWORD_DEFAULT);
  $sql = "insert into administrator set id='$admin_id',password='$admin_pass'";
  connect()->query($sql);
}





///////////////////////////////
// サイト設定情報テーブル作成
///////////////////////////////

if (!in_array('setting', $table)) {
  $sql = "create table if not exists setting(
  code int(7) zerofill auto_increment primary key,
  site_catch varchar(200) not null,
  site_name varchar(200) not null,
  site_url varchar(200) not null,
  com_name varchar(200) not null,
  com_boss varchar(200) not null,
  com_zip varchar(20) not null,
  com_add varchar(200) not null,
  com_tel varchar(20) not null,
  com_fax varchar(20) not null,
  com_free_dial varchar(20) not null,
  com_hour text not null,
  com_holiday text not null,
  com_email varchar(200) not null,
  com_est date not null,
  com_cap varchar(100) not null,
  com_emp text not null,
  com_copyright_name varchar(200) not null,
  main_bank text not null,
  com_license text not null,
  com_affiliation text not null,
  map_api_key varchar(200) not null,
  map_title varchar(20) not null,
  map_lat varchar(100) not null,
  map_lon varchar(100) not null,
  map_zoom int(2) not null,
  map_isw int(3) not null,
  map_ish int(3) not null,
  map_gam varchar(20) not null,
  map_sat varchar(20) not null,
  map_hue varchar(20) not null,
  facebook varchar(200) not null,
  instagram varchar(200) not null,
  twitter varchar(200) not null,
  youtube varchar(200) not null,
  line varchar(200) not null,
  tiktok varchar(200) not null
  )";
  connect()->query($sql);

  // 初期値登録
  $sql = "insert into setting set
map_zoom='13',
map_isw='80',
map_ish='80',
map_gam='0.74',
map_sat='-20',
map_hue='#00b2ff'
";
  connect()->query($sql);
}



///////////////////////////////
// CDN設定テーブル作成
///////////////////////////////

if (!in_array('setting_cdn', $table)) {
  $sql = "create table if not exists setting_cdn(
  code int(7) zerofill auto_increment primary key,
  cdn_header text not null,
  cdn_footer text not null
  )";
  connect()->query($sql);
}







///////////////////////////////
// カテゴリーテーブル作成
///////////////////////////////

if (!in_array('category', $table)) {
  $sql = "create table if not exists category(
  code int(3) zerofill auto_increment primary key,
  allocation varchar(50) not null,
  call_code varchar(50) not null,
  cate_name varchar(200) not null,
  `sort` int(3) not null
  )";
  connect()->query($sql);

  // 初期値登録
  $cates = [
    ["call_code" => "news", "cate_name" => "ニュース", "allocation" => "post"],
    ["call_code" => "blog", "cate_name" => "ブログ", "allocation" => "post"],
    ["call_code" => "stock", "cate_name" => "ストック", "allocation" => "post"],
    ["call_code" => "normal", "cate_name" => "常温", "allocation" => "temp"],
    ["call_code" => "cool", "cate_name" => "冷蔵", "allocation" => "temp"],
    ["call_code" => "cold", "cate_name" => "冷凍", "allocation" => "temp"],
  ];
  foreach ($cates as $cate) {
    $sql = "insert into category set call_code='$cate[call_code]',cate_name='$cate[cate_name]',allocation='$cate[allocation]'";
    connect()->query($sql);
  }
}


///////////////////////////////
// Chain Categoryテーブル作成
///////////////////////////////

if (!in_array('chain_cateogry', $table)) {
  $sql = "create table if not exists chain_category(
  cate_code int(3) zerofill not null,
  allocation varchar(50) not null,
  sj_code int(7) zerofill not null
  )";
  connect()->query($sql);
}


///////////////////////////////
// FAQテーブル作成
///////////////////////////////

if (!in_array('faq', $table)) {
  $sql = "create table if not exists faq(
  code int(7) zerofill auto_increment primary key,
  faq_que varchar(250) not null,
  faq_ans text collate utf8mb4_bin not null,
  date_regi date not null,
  date_update timestamp not null,
  display int(1) not null
  )";
  connect()->query($sql);
}





///////////////////////////////
// POSTテーブル作成
///////////////////////////////

if (!in_array('post', $table)) {
  $sql = "create table if not exists post(
  code int(7) zerofill auto_increment primary key,
  tag text not null,
  contributor_code int(5) not null,
  title varchar(250) not null,
  link varchar(250) not null,
  article text collate utf8mb4_bin not null,
  memo text not null,
  date_regi date not null,
  date_update timestamp ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  display int(1) not null
  )";
  connect()->query($sql);
}




///////////////////////////////
// POST設定テーブル作成
///////////////////////////////

if (!in_array('setting_post', $table)) {
  $sql = "create table if not exists setting_post(
  code int(7) zerofill auto_increment primary key,
  blog_title varchar(250) not null,
  blog_url varchar(250) not null,
  blog_desc text not null,
  tiny_api_key varchar(250) not null
  )";
  connect()->query($sql);
}




///////////////////////////////
// ITEMテーブル作成
///////////////////////////////

if (!in_array('item', $table)) {
  $sql = "create table if not exists item(
  code int(7) zerofill auto_increment primary key,
  tag text not null,
  item_name varchar(250) not null,
  price text not null,
  maker varchar(250) not null,
  brand varchar(250) not null,
  item_catch text not null,
  product_code varchar(100) not null,
  jan varchar(100) not null,
  capa varchar(100) not null,
  weight varchar(100) not null,
  short_description text not null,
  description text collate utf8mb4_bin not null,
  notes text not null,
  memo text not null,
  date_regi date not null,
  date_update timestamp not null,
  display int(1) not null,
  made_in varchar(100) not null,
  expiration_date varchar(50) not null,
  allergies text not null,
  ingredients text not null,
  component text not null,
  usage_method text not null,
  keep_method text not null,
  ex_link varchar(200) not null,
  delivary varchar(3) not null,
  line01 varchar(255) not null,
  line02 varchar(255) not null,
  line03 varchar(255) not null,
  box01 text not null,
  box02 text not null,
  box03 text not null
  )";
  connect()->query($sql);
}




///////////////////////////////
// ARCHIVEテーブル作成
///////////////////////////////

if (!in_array('archive', $table)) {
  $sql = "create table if not exists archive(
  code int(7) zerofill auto_increment primary key,
  tag text not null,
  archive_area varchar(250) not null,
  archive_title varchar(250) not null,
  archive_catch text not null,
  short_description text not null,
  description text collate utf8mb4_bin not null,
  memo text not null,
  date_regi date not null,
  date_update timestamp not null,
  display int(1) not null,
  ex_link varchar(200) not null,
  line01 varchar(255) not null,
  line02 varchar(255) not null,
  line03 varchar(255) not null,
  box01 text not null,
  box02 text not null,
  box03 text not null
  )";
  connect()->query($sql);
}




///////////////////////////////
// TAGテーブル作成
///////////////////////////////

if (!in_array('tag', $table)) {
  $sql = "create table if not exists tag(
  code int(7) zerofill auto_increment primary key,
  allocation varchar(200) not null,
  tag varchar(200) not null
  )";
  connect()->query($sql);
}



///////////////////////////////
// SPOTテーブル作成
///////////////////////////////

if (!in_array('spot', $table)) {
  $sql = "create table if not exists spot(
  code int(7) zerofill auto_increment primary key,
  tag text not null,
  spot_name varchar(250) not null,
  spot_catch text not null,
  spot_zip varchar(10) not null,
  spot_add01 varchar(200) not null,
  spot_add02 varchar(200) not null,
  spot_add03 varchar(200) not null,
  spot_tel varchar(200) not null,
  spot_fax varchar(200) not null,
  spot_lat varchar(200) not null,
  spot_lon varchar(200) not null,
  spot_time text not null,
  spot_holiday text not null,
  spot_budget text not null,
  spot_capa text not null,
  short_description text not null,
  description text collate utf8mb4_bin not null,
  memo text not null,
  date_regi date not null,
  date_update timestamp not null,
  display int(1) not null,
  spot_web varchar(200) not null,
  spot_facebook varchar(200) not null,
  spot_twitter varchar(200) not null,
  spot_instagram varchar(200) not null,
  spot_line varchar(200) not null,
  spot_youtube varchar(200) not null,
  ex_link varchar(200) not null,
  line01 varchar(255) not null,
  line02 varchar(255) not null,
  line03 varchar(255) not null,
  box01 text not null,
  box02 text not null,
  box03 text not null
  )";
  connect()->query($sql);
}


///////////////////////////////
// AREA_DATAテーブル作成
///////////////////////////////

if (!in_array('area_data', $table)) {
  $sql = "create table if not exists area_data(
  code int(3) zerofill auto_increment primary key,
  region_name varchar(200) not null,
  area_name varchar(200) not null,
  delivary_001 int(7) not null
  )";
  connect()->query($sql);

  // 初期値登録
  $areas = [
    ["北海道", "北海道"],
    ["東北", "青森県"],
    ["東北", "秋田県"],
    ["東北", "岩手県"],
    ["東北", "宮城県"],
    ["東北", "山形県"],
    ["東北", "福島県"],
    ["関東", "茨城県"],
    ["関東", "栃木県"],
    ["関東", "群馬県"],
    ["関東", "埼玉県"],
    ["関東", "千葉県"],
    ["関東", "東京都"],
    ["関東", "神奈川県"],
    ["関東", "山梨県"],
    ["信越", "新潟県"],
    ["信越", "長野県"],
    ["北陸", "富山県"],
    ["北陸", "石川県"],
    ["北陸", "福井県"],
    ["中部", "静岡県"],
    ["中部", "愛知県"],
    ["中部", "三重県"],
    ["中部", "岐阜県"],
    ["関西", "大阪府"],
    ["関西", "京都府"],
    ["関西", "滋賀県"],
    ["関西", "兵庫県"],
    ["関西", "奈良県"],
    ["関西", "和歌山県"],
    ["中国", "岡山県"],
    ["中国", "広島県"],
    ["中国", "山口県"],
    ["中国", "鳥取県"],
    ["中国", "島根県"],
    ["四国", "徳島県"],
    ["四国", "香川県"],
    ["四国", "愛媛県"],
    ["四国", "高知県"],
    ["九州", "福岡県"],
    ["九州", "佐賀県"],
    ["九州", "長崎県"],
    ["九州", "熊本県"],
    ["九州", "大分県"],
    ["九州", "宮崎県"],
    ["九州", "鹿児島県"],
    ["沖縄", "沖縄県"],
  ];
  foreach ($areas as $area) {
    $sql = "insert into area_data set region_name='$area[0]',area_name='$area[1]',delivary_001='1000'";
    connect()->query($sql);
  }
}




///////////////////////////////
// PAGEテーブル作成
///////////////////////////////

if (!in_array('page', $table)) {
  $sql = "create table if not exists page(
  code int(7) zerofill auto_increment primary key,
  page_name varchar(250) not null,
  title01 varchar(250) not null,
  text01 text not null,
  title02 varchar(250) not null,
  text02 text not null,
  title03 varchar(250) not null,
  text03 text not null,
  title04 varchar(250) not null,
  text04 text not null,
  title05 varchar(250) not null,
  text05 text not null,
  title06 varchar(250) not null,
  text06 text not null,
  title07 varchar(250) not null,
  text07 text not null,
  title08 varchar(250) not null,
  text08 text not null,
  title09 varchar(250) not null,
  text09 text not null,
  title10 varchar(250) not null,
  text10 text not null
  )";
  connect()->query($sql);
}




///////////////////////////////
// STAFFテーブル作成
///////////////////////////////

if (!in_array('staff', $table)) {
  $sql = "create table if not exists staff(
  code int(7) zerofill auto_increment primary key,
  tag text not null,
  staff_name varchar(250) not null,
  staff_name_eg varchar(250) not null,
  staff_birth_day date not null,
  staff_position varchar(250) not null,
  short_description text not null,
  staff_intro text collate utf8mb4_bin not null,
  staff_blood_type varchar(20) not null,
  staff_height varchar(10) not null,
  staff_weight varchar(10) not null,
  staff_bust varchar(10) not null,
  staff_waist varchar(10) not null,
  staff_hip varchar(10) not null,
  staff_wear_top varchar(10) not null,
  staff_wear_bottom varchar(10) not null,
  staff_shoes varchar(10) not null,
  staff_license text not null,
  staff_hobby text not null,
  staff_career text not null,
  staff_website varchar(250) not null,
  staff_facebook varchar(250) not null,
  staff_twitter varchar(250) not null,
  staff_instagram varchar(250) not null,
  staff_youtube varchar(250) not null,
  staff_tiktok varchar(250) not null,
  memo text not null,
  date_regi date not null,
  date_update timestamp not null,
  display int(1) not null,
  ex_link varchar(200) not null,
  line01 varchar(255) not null,
  line02 varchar(255) not null,
  line03 varchar(255) not null,
  box01 text not null,
  box02 text not null,
  box03 text not null
  )";
  connect()->query($sql);
}



///////////////////////////////
// RECRUITテーブル作成
///////////////////////////////

if (!in_array('recruit', $table)) {
  $sql = "create table if not exists recruit(
  code int(7) zerofill auto_increment primary key,
  tag text not null,
  rec_title varchar(250) not null,
  short_description text not null,
  description text collate utf8mb4_bin not null,
  rec_status text not null,
  rec_occupation text not null,
  rec_job_description text not null,
  rec_qualification text not null,
  rec_salary text not null,
  rec_salary_revision text not null,
  rec_bonus text not null,
  rec_holiday text not null,
  rec_treatment text not null,
  rec_welfare text not null,
  rec_training text not null,
  rec_commendation text not null,
  rec_place text not null,
  rec_time text not null,
  memo text not null,
  date_end date not null,
  date_regi date not null,
  date_update timestamp not null,
  display int(1) not null,
  ex_link varchar(200) not null,
  line01 varchar(255) not null,
  line02 varchar(255) not null,
  line03 varchar(255) not null,
  box01 text not null,
  box02 text not null,
  box03 text not null
  )";
  connect()->query($sql);
}




///////////////////////////////
// CONTACTテーブル作成
///////////////////////////////

if (!in_array('contact', $table)) {
  $sql = "create table if not exists contact(
  code int(7) zerofill auto_increment primary key,
  tag text not null,
  con_name varchar(250) not null,
  con_pic varchar(250) not null,
  con_zip varchar(10) not null,
  con_add01 varchar(50) not null,
  con_add02 varchar(250) not null,
  con_add03 varchar(200) not null,
  con_tel varchar(15) not null,
  con_fax varchar(15) not null,
  con_email varchar(250) not null,
  con_web varchar(250) not null,
  short_description text not null,
  memo text not null,
  date_regi date not null,
  date_update timestamp not null,
  ex_link varchar(200) not null,
  line01 varchar(255) not null,
  line02 varchar(255) not null,
  line03 varchar(255) not null,
  box01 text not null,
  box02 text not null,
  box03 text not null
  )";
  connect()->query($sql);
}




///////////////////////////////
// MAILTEMPテーブル作成
///////////////////////////////

if (!in_array('mailtemp', $table)) {
  $sql = "create table if not exists mailtemp(
  code int(7) zerofill auto_increment primary key,
  mailtemp_name varchar(250) not null,
  call_code varchar(200) not null,
  mail_title varchar(200) not null,
  mail_body text not null,
  memo text,
  date_update timestamp not null,
  support varchar(10) not null
  )";
  connect()->query($sql);


  // 初期値登録
  $temps = [
    ["メールフッター", "footer", "フッター"],
    ["お問い合わせ内容確認メール", "contact", "<site_name>へのお問い合わせありがとうございました。"],
    ["ご購入内容確認メール", "confirm_purchase", "ご購入内容確認メール"],
    ["商品発送のご連絡メール", "product_shipping", "商品発送のご連絡"],
    ["会員登録の仮登録メール", "prov_regi", "仮登録が完了しました。"],
    ["パスワード再設定URL", "ps_rem", "パスワードの再設定URLのお知らせ"]
  ];
  foreach ($temps as $temp) {
    $temp_file = "mail_temp/" . $temp[1] . ".dat";
    if (is_file($temp_file)) {
      $temp_data = file_get_contents($temp_file);
    } else {
      $temp_data = "";
    }
    $sql = "insert into mailtemp set mailtemp_name='$temp[0]',call_code='$temp[1]',mail_title='$temp[2]',mail_body='$temp_data'";
    connect()->query($sql);
  }
}




///////////////////////////////
// SHOP設定テーブル作成
///////////////////////////////

if (!in_array('setting_shop', $table)) {
  $sql = "create table if not exists setting_shop(
  code int(7) zerofill auto_increment primary key,
  public_key varchar(250) ,
  secret_key varchar(250) not null,
  des_day_min varchar(2) not null,
  des_day_max varchar(2) not null,
  des_time text not null,
  bank_name varchar(200) not null,
  bank_branch varchar(200) not null,
  bank_kind varchar(200) not null,
  bank_number varchar(200) not null,
  bank_holder varchar(200) not null,
  pay_credit varchar(250) not null,
  pay_cash varchar(250) not null,
  pay_bank varchar(250) not null,
  cash_fee_1 varchar(5) not null,
  cash_fee_2 varchar(5) not null,
  cash_fee_3 varchar(5) not null,
  cash_fee_4 varchar(5) not null,
  deli_fee_free int(7) not null
  )";
  connect()->query($sql);

  // 初期値登録
  $sql = "insert into setting_shop set
des_day_min=3,
des_day_max=30,
des_time='12時-14時\n14時-16時\n16時-18時\n18時-20時\n19時-21時',
pay_credit=0,
pay_cash=1,
pay_bank=0,
cash_fee_1=330,
cash_fee_2=440,
cash_fee_3=660,
cash_fee_4=1100
";
  connect()->query($sql);
}




///////////////////////////////
// DELIVARYテーブル作成
///////////////////////////////

if (!in_array('delivary', $table)) {
  $sql = "create table if not exists delivary(
  code int(3) zerofill auto_increment primary key,
  delivary_name varchar(200) not null,
  flag_include int(1),
  delivary_group varchar(200) not null
  )";
  connect()->query($sql);

  // 初期値登録
  $sql = "insert into delivary set
delivary_name='通常配送'
";
  connect()->query($sql);
}




///////////////////////////////
// ORDER_DATAテーブル作成
///////////////////////////////

if (!in_array('order_data', $table)) {
  $sql = "create table if not exists order_data(
  code int(7) zerofill auto_increment primary key,
  date_order date not null,
  order_number varchar(200) not null,
  name varchar(200) not null,
  zip varchar(10) not null,
  add01 varchar(20) not null,
  add02 varchar(200) not null,
  add03 varchar(200) not null,
  tel varchar(50) not null,
  email varchar(20) not null,
  deli_name varchar(200) not null,
  deli_zip varchar(10) not null,
  deli_add01 varchar(20) not null,
  deli_add02 varchar(200) not null,
  deli_add03 varchar(200) not null,
  deli_tel varchar(50) not null,
  order_list text not null,
  payment varchar(50) not null,
  des_day date not null,
  des_time varchar(50) not null,
  cash_fee int(5) not null,
  total_deli_fee int(7) not null,
  total_item int(10) not null,
  total_payment int(10) not null,
  comments text not null,
  tracking varchar(200) not null,
  st_payment varchar(1) not null,
  st_delivary varchar(1) not null,
  st_cancel varchar(1) not null,
  spare text not null,
  user_id varchar(200) not null
  )";
  connect()->query($sql);
}




///////////////////////////////
// GAMEテーブル作成
///////////////////////////////

if (!in_array('game', $table)) {
  $sql = "create table if not exists game(
  code int(7) zerofill auto_increment primary key,
  game_catch varchar(250) not null,
  game_title varchar(200) not null,
  game_opponent varchar(200) not null,
  game_place varchar(250) not null,
  game_place_add varchar(250) not null,
  game_score_team varchar(50) not null,
  game_score_opponent varchar(50) not null,
  game_score_details text not null,
  game_movie varchar(250) not null,
  game_memo text not null,
  game_date date not null,
  game_time varchar(100),
  date_regi date not null,
  date_update timestamp not null,
  display int(1) not null,
  ex_link varchar(200) not null,
  line01 varchar(255) not null,
  line02 varchar(255) not null,
  line03 varchar(255) not null,
  box01 text not null,
  box02 text not null,
  box03 text not null
  )";
  connect()->query($sql);
}



///////////////////////////////
// GAME_COMMENTテーブル作成
///////////////////////////////

if (!in_array('game_comment', $table)) {
  $sql = "create table if not exists game_comment(
  code int(7) zerofill auto_increment primary key,
  game_code int(7) not null,
  staff_code int(7) not null,
  comment_title varchar(255),
  comments text not null,
  display int(1) not null
  )";
  connect()->query($sql);
}



///////////////////////////////
// GAME設定テーブル作成
///////////////////////////////

if (!in_array('setting_game', $table)) {
  $sql = "create table if not exists setting_game(
  code int(7) zerofill auto_increment primary key,
  team_name varchar(100) not null,
  team_intro text not null,
  basic_principle text not null,
  action_philosophy text not null,
  team_goal text not null,
  origin_name text not null,
  origin_color text not null,
  color_main varchar(10) not null,
  color_sub varchar(10) not null,
  color_accent varchar(10) not null,
  coaching_policy text not null,
  team_activities text not null,
  team_composition text not null
  )";
  connect()->query($sql);
}






print "セットアップが完了しました。";
exit;
