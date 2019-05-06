<?php
session_start();
header("Content-Type: image/png");

if(!isset($_SESSION['userid'])) {
  readfile("files/abholen.png");
  die();
;
}
if(isset($_GET['img'])) {
    $img = $_GET['img'];
    readfile("files/$img.png");
} else {
    readfile("files/aber.png");
}
?>
