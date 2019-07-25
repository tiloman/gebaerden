<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}
require('config.php');
$pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");

  $grantedSchool = $_POST['access'];
  $grantedUser = $_POST['grantedUser'];
  $userSchoolID = $_SESSION['schoolId'];


  $statement = $pdo->prepare("UPDATE user SET schoolid = ? WHERE id = $grantedUser");
  $statement->execute(array($userSchoolID));

  $statement = $pdo->prepare("UPDATE user SET grantedAccess = ? WHERE id = $grantedUser");
  $statement->execute(array('0'));

  $sql = "SELECT * FROM school WHERE school_id = $userSchoolID";
  foreach ($pdo->query($sql) as $row) {
    $license = $row['zeigsmirmitgebaerden'];
  }

    if (isset($license)) {
      $statement = $pdo->prepare("UPDATE user SET serial = ? WHERE id = $grantedUser");
      $statement->execute(array($license));
    }


  $sql = "SELECT * FROM user WHERE id = $grantedUser";
  foreach ($pdo->query($sql) as $row) {
    $requestedUserMail = $row['email'];
  }


  //Bestätigungsmail an Requester verschicken
  $empfaenger = (string)$requestedUserMail;
  $betreff = "Aufnahme in Schule";
  $from = "From: Timo Lohmann <lohmanntimo@gmail.com>";
  $text = "Sie wurden zur Schule hinzugefügt. \n\n
Schauen Sie sich nun die Gebärden an und fügen Sie eigene hinzu: tiloman.mooo.com/gebaerden/custom_libraryID.php \n
Viel Spaß!";
  $headers = "MIME-Version: 1.0\r\n";

  if(mail($empfaenger, $betreff, $text, $from, $headers)) {
    header('Location: ../manageTeam.php?confirmed='.$grantedUser);
  } else {
    header('Location: ../manageTeam.php');
  }



?>
