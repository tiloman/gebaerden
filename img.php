<?php
session_start();
header("Content-Type: image/png");

if(!isset($_SESSION['userid'])) {
  readfile("files/abholen.png");
  die();
;
}

$path = $_GET['path'];
$mime = $_GET['mime'];

if(isset($_GET['img'])) {
    $img = $_GET['img'];
    readfile($path.$img.".".$mime);
} else {
    readfile("files/aber.png");
}
?>
