<?php

if (isset($_POST['deleteImgID'])) {
  $imgID = $_POST['deleteImgID'];
  $userSchoolID = $_SESSION['schoolId'];


  $pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


  $statement = $pdo->prepare("DELETE FROM school_$userSchoolID WHERE ImgID = ?");
  $statement->execute(array($imgID));

  $notice = "Der Eintrag wurde gelöscht";
}

?>
