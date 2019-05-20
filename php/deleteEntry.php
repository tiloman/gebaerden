<?php

if (isset($_POST['deleteImgID'])) {
  $imgID = $_POST['deleteImgID'];


  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


// $sql = "SELECT * FROM custom_img_12345 ORDER BY ImgName";
    // $statement = $pdo->prepare("SELECT * FROM custom_img_12345");
    // $statement->execute(array('wordsArray'));
// $wordsArray = $pdo->query($sql);


  $statement = $pdo->prepare("DELETE FROM custom_img_12345 WHERE ImgID = ?");
  $statement->execute(array($imgID));

  $notice = $word." ist nun gelöscht";
}

?>
