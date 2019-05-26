<?php

if (isset($_POST['deleteImgID'])) {
  $imgID = $_POST['deleteImgID'];
  $userSchoolID = $_SESSION['schoolId'];


  $pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


  $statement = $pdo->prepare("DELETE FROM school_$userSchoolID WHERE ImgID = ?");
  $statement->execute(array($imgID));

  $sql = "SELECT * FROM school_$userSchoolID WHERE ImgID = '$imgID'";
  foreach ($pdo->query($sql) as $row) {
     $imgFile = $row['ImgFile'];
     $imgMime = $row['ImgMime'];
     $path = $row['path'];
  }

      unlink("../".$path.$imgFile.".".$imgMime);

  $notice = "Der Eintrag wurde gelöscht";
}

?>
