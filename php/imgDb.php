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

$pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
$sql = "SELECT * FROM custom_img_12345 WHERE ImgName = '$word'";
foreach ($pdo->query($sql) as $row) {

   $imgMime = $row['ImgMime'];

}



    readfile("../".$path.$word.".".$imgMime);
} else {
    readfile("../img/forbidden.jpg");
}
?>
