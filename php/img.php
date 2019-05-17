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
    $word = $_GET['img'];



    if(file_exists("../".$path.$word.'.jpg')){
      $mime = 'jpg';
    } elseif(file_exists("../".$path.$word.'.png')) {
      $mime = 'png';
    } elseif(file_exists("../".$path.$word.'.jpeg')) {
      $mime = 'jpeg';
    };

    readfile("../".$path.$word.".".$mime);
} else {
    readfile("../img/forbidden.jpg");
}
?>
