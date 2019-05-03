<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: login.php"));
;
}
  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $userid = $_SESSION['userid'];

  $pdf_font = $_POST['pdf_font'];
  $pdf_size = $_POST['pdf_size'];

  $statement = $pdo->prepare("UPDATE user SET pdf_font = ? WHERE id = $userid");
  $statement->execute(array($pdf_font));

  $statement = $pdo->prepare("UPDATE user SET pdf_size = ? WHERE id = $userid");
  $statement->execute(array($pdf_size));

  header('Location: profile.php');

?>
