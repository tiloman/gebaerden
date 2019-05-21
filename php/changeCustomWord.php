<?php

if (isset($_POST['renameWord']) && isset($_POST['newName'])) {
  $userSchoolID = $_SESSION['schoolId'];

  $word = $_POST['renameWord'];
  $newName = $_POST['newName'];

  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


  $statement = $pdo->prepare("UPDATE school_$userSchoolID SET ImgName = ? WHERE ImgName = '$word'");
  $statement->execute(array($newName));

  $sql = "SELECT * FROM school_$userSchoolID WHERE ImgName = '$newName'";
    foreach ($pdo->query($sql) as $row) {
      $VideoID = $row['VideoID'];
  }

  if($VideoID !== ''){
    $statement = $pdo->prepare("UPDATE school_$userSchoolID SET VideoID = ? WHERE ImgName = '$newName'");
    $statement->execute(array($newName));
  }

  $notice = $word." ist nun umbenannt in ".$newName;
}

?>
