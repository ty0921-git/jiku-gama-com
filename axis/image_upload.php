<?php
$f_name = gmdate("YmdHis", time() + 9 * 3600);
/***************************************************
 * Only these origins are allowed to upload images *
 ***************************************************/
$domain = (empty($_SERVER['HTTPS']) ? "http://" : "https://") . $_SERVER['SERVER_NAME'];
$accepted_origins = array($domain);

/*********************************************
 * Change this line to set the upload folder *
 *********************************************/
$imageFolder = "../post-image/";

if (isset($_SERVER['HTTP_ORIGIN'])) {
  // same-origin requests won't set an origin. If the origin is set, it must be valid.
  if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
  } else {
    header("HTTP/1.1 403 Origin Denied");
    return;
  }
}

// Don't attempt to process the upload on an OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  header("Access-Control-Allow-Methods: POST, OPTIONS");
  return;
}

reset($_FILES);
$temp = current($_FILES);
if (is_uploaded_file($temp['tmp_name'])) {
  /*
      If your script needs to receive cookies, set images_upload_credentials : true in
      the configuration and enable the following two headers.
    */
  // header('Access-Control-Allow-Credentials: true');
  // header('P3P: CP="There is no P3P policy."');

  // Sanitize input
  // if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
  //     header("HTTP/1.1 400 Invalid file name.");
  //     return;
  // }

  // Verify extension
  if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png", "jpeg", "JPEG", "JPG", "webp"))) {
    header("HTTP/1.1 400 Invalid extension.");
    return;
  }
  // Accept upload if there was no origin, or if it is an accepted origin
  // $filetowrite = $imageFolder . $f_name.$temp['name'];
  list(, $ext) = explode(".", $temp['name']);
  $filetowrite = $imageFolder . $f_name . "." . $ext;



  $max_width = "1000";
  $max_height = "1000";

  $size = @getimagesize($temp['tmp_name']);
  $resize = $size;

  $magni_width = $size[0] / $max_width;
  $magni_height = $size[1] / $max_height;
  if ($magni_width > 1 || $magni_height > 1) {
    if ($magni_width > $magni_height) {
      $resize[0] = $max_width;
      $resize[1] = $size[1] * $max_width / $size[0];
    } else {
      $resize[0] = $size[0] * $max_height / $size[1];
      $resize[1] = $max_height;
    }
  }
  $new_image = imagecreatetruecolor($resize[0], $resize[1]);

  if ($size[2] == 1) {
    $default_image = imagecreatefromgif($temp['tmp_name']);
  } elseif ($size[2] == 2) {
    $default_image = imagecreatefromjpeg($temp['tmp_name']);
  } elseif ($size[2] == 3) {
    $default_image = imagecreatefrompng($temp['tmp_name']);
  } elseif ($size[2] == 18) {
    $default_image = imagecreatefromwebp($temp['tmp_name']);
  }

    //透過処理
  imagealphablending($new_image, false);
  imagesavealpha($new_image, true);
  
  imagecopyresampled($new_image, $default_image, 0, 0, 0, 0, $resize[0], $resize[1], $size[0], $size[1]);

  if ($size[2] == 1) {
    imagegif($new_image, $filetowrite);
  } elseif ($size[2] == 2) {
    imagejpeg($new_image, $filetowrite, 90);
  } elseif ($size[2] == 3) {
    imagepng($new_image, $filetowrite);
  } elseif ($size[2] == 18) {
    imagewebp($new_image, $filetowrite);
  }



  // move_uploaded_file($new_image, $filetowrite);

  // Determine the base URL
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
  $folder = "post-image/";

  // Respond to the successful upload with JSON.
  // Use a location key to specify the path to the saved image resource.
  // { location : '/your/uploaded/image/file'}
  echo json_encode(array('location' => $folder . $f_name . "." . $ext));
} else {
  // Notify editor that the upload failed
  header("HTTP/1.1 500 Server Error");
}
