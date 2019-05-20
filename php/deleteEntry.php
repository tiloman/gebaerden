<?php

if (isset($_POST['deleteImgID'])) {
  $imgID = $_POST['deleteImgID'];


  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


  $statement = $pdo->prepare("DELETE FROM custom_img_12345 WHERE ImgID = ?");
  $statement->execute(array($imgID));

  $notice = "Der Eintrag wurde gelöscht";
}

?>
