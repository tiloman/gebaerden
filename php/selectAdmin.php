<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}
  require('config.php');
  $pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");

  $admin = $_POST['admin'];
  $changeUser = $_POST['changeUser'];
  $userSchoolID = $_SESSION['schoolId'];


  $statement = $pdo->prepare("UPDATE user SET teamAdmin = ? WHERE id = $changeUser");
  $statement->execute(array($admin));



  $sql = "SELECT * FROM user WHERE id = $changeUser";
  foreach ($pdo->query($sql) as $row) {
    $requestedUserMail = $row['mail'];
  }

  //Bestätigungsmail an Requester verschicken
  // $empfaenger = (string)$requestedUserMail;
  // $betreff = "Aufnahme in Schule";
  // $from = "From: Timo Lohmann <lohmanntimo@gmail.com>";
  // $text = "Sie wurden zur Schule hinzugefügt.";
  // $headers = "MIME-Version: 1.0\r\n";
  // mail($empfaenger, $betreff, $text, $from, $headers);


  header('Location: ../manageTeam.php?admin='.$changeUser);

?>
