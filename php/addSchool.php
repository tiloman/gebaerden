<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}
  $pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $userid = $_SESSION['userid'];

  $userSchoolID = $_POST['schoolId'];

  $statement = $pdo->prepare("UPDATE user SET grantedAccess = ? WHERE id = $userid");
  $statement->execute(array($userSchoolID));


  $sql = "SELECT * FROM user WHERE schoolid = $userSchoolID AND teamAdmin = 'Ja'";
  foreach ($pdo->query($sql) as $row) {
    $adminMail = $row['email'];
    $empfaenger = (string)$adminMail;
    $betreff = "Mitgliedschaftsanfrage für Ihre Schule";
    $from = "From: Timo Lohmann <lohmanntimo@gmail.com>";
    $text = "Mitgliedschaftsanfrage \n\n
          Sie haben eine neue Mitgliedschaftsanfrage für Ihre Schule. Bitte bearbeiten Sie diese in Ihrer Teamverwaltung.\n
          Zur Teamverwaltung: tiloman.mooo.com/gebaerden/manageTeam.php

    ";


    mail($empfaenger, $betreff, $text, $from);
  }

echo "<script>window.location.assign('../manageContent.php')</script>";


?>
