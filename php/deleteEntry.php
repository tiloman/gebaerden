<?php

if (isset($_POST['deleteImgID'])) {
  $imgID = $_POST['deleteImgID'];
  $userSchoolID = $_SESSION['schoolId'];


  $pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


  $sql = "SELECT * FROM school_$userSchoolID WHERE ImgID = '$imgID'";
  foreach ($pdo->query($sql) as $row) {
     $imgFile = $row['ImgFile'];
     $imgMime = $row['ImgMime'];
     $path = $row['path'];
     $videoFile = $row['VideoFile'];
     $videoMime = $row['VideoPath'];

     unlink($path.$imgFile.".".$imgMime);

     if (isset($videoFile)) {
       unlink($path.$videoFile.".".$videoMime);
     }
  }


  $statement = $pdo->prepare("DELETE FROM school_$userSchoolID WHERE ImgID = ?");
  $statement->execute(array($imgID));




  $notice = "Der Eintrag wurde gelöscht";
}

?>
