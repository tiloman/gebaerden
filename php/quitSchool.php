<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}
  require('../config.php');
  $pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");

  $userid = $_SESSION['userid'];


  $statement = $pdo->prepare("UPDATE user SET schoolid = ? WHERE id = $userid");
  $statement->execute(array('0'));

  $statement = $pdo->prepare("UPDATE user SET teamAdmin = ? WHERE id = $userid");
  $statement->execute(array('Nein'));

  $statement = $pdo->prepare("UPDATE user SET serial = ? WHERE id = $userid");
  $statement->execute(array('0'));




  $_SESSION['schoolId'] = 0;
  $_SESSION['teamAdmin'] = 'Nein';
  $_SESSION['serial'] = 0;
  header('Location: ../profile.php');

?>
