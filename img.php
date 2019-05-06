<?php
session_start();
header("Content-Type: image/jpg");

if(!isset($_SESSION['userid'])) {
  readfile("files/abholen.png");
  die();
;
}

if(isset($_GET['img'])) {
    $img = $_GET['img'];
    readfile("custom/$img.jpg");
} else {
    readfile("files/aber.png");
}


?>
