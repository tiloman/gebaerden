<?php
session_start();
header("Content-Type: image/png");

if(!isset($_SESSION['userid'])) {
  readfile("../img/forbidden.jpg");
  die();
;
}

$path = $_GET['path'];


if(isset($_GET['img'])) {
    $img = $_GET['img'];

    if(file_exists("../".$path.$img.'.jpg')){
      $mime = 'jpg';
    } elseif(file_exists("../".$path.$img.'.png')) {
      $mime = 'png';
    } elseif(file_exists("../".$path.$img.'.jpeg')) {
      $mime = 'jpeg';
    };

    readfile("../".$path.$img.".".$mime);
} else {
    readfile("../img/forbidden.jpg");
}
?>
