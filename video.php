<?php
session_start();
header("Content-Type: video/mp4");

if(!isset($_SESSION['userid'])) {
  readfile("files/abholen.png");
  die();
;
}
if(isset($_GET['video'])) {
    $img = $_GET['video'];
    readfile("custom/videos/$img");
} else {
    readfile("custom/videos/Aufzug_video.mp4");
}
?>
