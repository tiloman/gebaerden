<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}
  $pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $grantedSchool = $_POST['access'];
  $grantedUser = $_POST['grantedUser'];
  $userSchoolID = $_SESSION['schoolId'];


  $statement = $pdo->prepare("UPDATE user SET schoolid = ? WHERE id = $grantedUser");
  $statement->execute(array($userSchoolID));

  $statement = $pdo->prepare("UPDATE user SET grantedAccess = ? WHERE id = $grantedUser");
  $statement->execute(array('0'));

  $sql = "SELECT * FROM user WHERE id = $grantedUser";
  foreach ($pdo->query($sql) as $row) {
    $requestedUserMail = $row['mail'];
  }


  //Bestätigungsmail an Requester verschicken
  // $empfaenger = (string)$requestedUserMail;
  // $betreff = "Aufnahme in Schule";
  // $from = "From: Timo Lohmann <lohmanntimo@gmail.com>";
  // $text = "Sie wurden zur Schule hinzugefügt. \n";
  // $headers = "MIME-Version: 1.0\r\n";
  // mail($empfaenger, $betreff, $text, $from, $headers);




  header('Location: ../manageTeam.php?confirmed='.$grantedUser);

?>
