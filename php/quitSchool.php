<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}
  $pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $userid = $_SESSION['userid'];


  $statement = $pdo->prepare("UPDATE user SET schoolid = ? WHERE id = $userid");
  $statement->execute(array('0'));

  $statement = $pdo->prepare("UPDATE user SET teamAdmin = ? WHERE id = $userid");
  $statement->execute(array('Nein'));

  $_SESSION['schoolId'] = 0;
  $_SESSION['teamAdmin'] = 'Nein';

  header('Location: ../profile.php');

?>
