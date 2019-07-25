<?php

if (isset($_POST['deleteImgID'])) {
  $imgID = $_POST['deleteImgID'];
  $userSchoolID = $_SESSION['schoolId'];


  require('config.php');
  $pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");

  $sql = "SELECT * FROM school_$userSchoolID WHERE ImgID = '$imgID'";
  foreach ($pdo->query($sql) as $row) {
     $imgFile = $row['ImgFile'];
     $imgMime = $row['ImgMime'];
     $path = $row['path'];
     $videoFile = $row['VideoFile'];
     $videoMime = $row['VideoMime'];

     unlink($path.$imgFile.".".$imgMime);

     if (isset($videoFile)) {
       unlink($path.$videoFile.".".$videoMime);
     }

     if (file_exists($path.$videoFile."-thumb.jpg")) {
      unlink($path.$videoFile."-thumb.jpg");
    }

    if (file_exists($path.$videoFile."-small.jpg")) {
      unlink($path.$videoFile."-small.jpg");
    }

  }


  $statement = $pdo->prepare("DELETE FROM school_$userSchoolID WHERE ImgID = ?");
  $statement->execute(array($imgID));




  $notice = "Der Eintrag wurde gelöscht";
}

?>
