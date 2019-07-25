<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}

  require('config.php');
  $pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");

  $userid = $_SESSION['userid'];

  $userLicense = $_POST['userLicense'];

  $statement = $pdo->prepare("SELECT * FROM license WHERE serial = $userLicense");
  $result = $statement->execute(array('serial' => $serial));
  $user = $statement->fetch();

  if($user == false) {
      $errorMessage = 'Die eingegebene Seriennummer ist falsch <br> Bitte wenden Sie sich an: lohmanntimo@gmail.com.';
      $error = true;
      echo "<script>window.location.assign('../index.php?error=1')</script>";
  } else {
    $statement = $pdo->prepare("UPDATE user SET serial = ? WHERE id = $userid");
    $statement->execute(array($userLicense));
    $_SESSION['serial'] = $userLicense;
    echo "<script>window.location.assign('../index.php')</script>";
  }





?>
