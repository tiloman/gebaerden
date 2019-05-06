<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: login.php"));
;
}
  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $userid = $_SESSION['userid'];

  $schoolID = $_POST['schoolId'];

  $statement = $pdo->prepare("UPDATE user SET schoolid = ? WHERE id = $userid");
  $statement->execute(array($schoolID));

  $schoolID = $_SESSION['schoolId'];

  header('Location: profile.php');

?>
