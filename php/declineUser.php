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


  $statement = $pdo->prepare("UPDATE user SET grantedAccess = ? WHERE id = $grantedUser");
  $statement->execute(array('0'));

  header('Location: ../manageTeam.php?decline='.$grantedUser);

?>
