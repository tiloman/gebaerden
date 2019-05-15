<?php
session_start();
header("Content-Type: image/png");

if(!isset($_SESSION['userid'])) {
  readfile("../img/forbidden.jpg");
  die();
;
}
if(isset($_GET['img'])) {
    $img = $_GET['img'];
    readfile("../files/metacom/$img.png");
} else {
    readfile("../img/forbidden.jpg");
}
?>
