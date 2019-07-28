<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}
  require('../config.php');
  $pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");

  $userid = $_SESSION['userid'];

  $pdf_font = $_POST['pdf_font'];
  $pdf_size = $_POST['pdf_size'];
  $pdf_format = $_POST['pdf_format'];

  $statement = $pdo->prepare("UPDATE user SET pdf_font = ? WHERE id = $userid");
  $statement->execute(array($pdf_font));

  $statement = $pdo->prepare("UPDATE user SET pdf_size = ? WHERE id = $userid");
  $statement->execute(array($pdf_size));

  $statement = $pdo->prepare("UPDATE user SET pdf_format = ? WHERE id = $userid");
  $statement->execute(array($pdf_format));

  header('Location: ../profile.php');

?>
