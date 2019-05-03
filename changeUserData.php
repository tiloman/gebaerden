<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: login.php"));
;
}
  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $userid = $_SESSION['userid'];

  $vorname = $_POST['vorname'];
  $nachname = $_POST['nachname'];
  $email = $_POST['email'];

  $statement = $pdo->prepare("UPDATE user SET vorname = ? WHERE id = $userid");
  $statement->execute(array($vorname));

  $statement = $pdo->prepare("UPDATE user SET nachname = ? WHERE id = $userid");
  $statement->execute(array($nachname));

  $statement = $pdo->prepare("UPDATE user SET email = ? WHERE id = $userid");
  $statement->execute(array($email));

  header('Location: profile.php');

?>
