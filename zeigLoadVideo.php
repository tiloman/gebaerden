<?php
session_start();
header("Content-Type: video/mp4");

if(!isset($_SESSION['userid'])) {
  readfile("files/abholen.png");
  die();
;
}
if(isset($_GET['video'])) {
    $video = $_GET['video'];
    readfile("files/video/$video");
} else {
    readfile("custom/videos/Aufzug_video.mp4");
}
?>
