<?php

if (isset($_POST['renameWord']) && isset($_POST['newName'])) {
  $word = $_POST['renameWord'];
  $newName = $_POST['newName'];

  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


// $sql = "SELECT * FROM custom_img_12345 ORDER BY ImgName";
    // $statement = $pdo->prepare("SELECT * FROM custom_img_12345");
    // $statement->execute(array('wordsArray'));
// $wordsArray = $pdo->query($sql);


  $statement = $pdo->prepare("UPDATE custom_img_12345 SET ImgName = ? WHERE ImgName = '$word'");
  $statement->execute(array($newName));

  $sql = "SELECT * FROM custom_img_12345 WHERE ImgName = '$newName'";
    foreach ($pdo->query($sql) as $row) {
      $VideoID = $row['VideoID'];
  }

  if($VideoID !== ''){
    $statement = $pdo->prepare("UPDATE custom_img_12345 SET VideoID = ? WHERE ImgName = '$newName'");
    $statement->execute(array($newName));
  }

  $notice = $word." ist nun umbenannt in ".$newName;
}

?>
