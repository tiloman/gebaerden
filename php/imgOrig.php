<?php
session_start();
header("Content-Type: image/png");

if(!isset($_SESSION['userid'])) {
  readfile("../img/forbidden.jpg");
  die();
;
}

$userSchoolID = $_SESSION['schoolId'];


if(isset($_GET['imgID'])) {
    $imgID = $_GET['imgID'];

$pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
$sql = "SELECT * FROM school_$userSchoolID WHERE ImgID = '$imgID'";
foreach ($pdo->query($sql) as $row) {
   $imgFile = $row['ImgFile'];
   $imgMime = $row['ImgMime'];
   $path = $row['path'];
}


      readfile("../".$path.$imgFile.".".$imgMime);
      
} else {
    readfile("../img/forbidden.jpg");
}
?>
