<?php
session_start();
header("Content-Type: image/png");

if(!isset($_SESSION['userid'])) {
  readfile("files/abholen.png");
  die();
;
}

$path = $_GET['path'];


if(isset($_GET['img'])) {
    $img = $_GET['img'];

    if(file_exists($path.$img.'.jpg')){
      $mime = 'jpg';
    } elseif(file_exists($path.$img.'.png')) {
      $mime = 'png';
    };

    readfile($path.$img.".".$mime);
} else {
    readfile("files/aber.png");
}
?>
