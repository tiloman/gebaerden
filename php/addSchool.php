<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}
  $pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $userid = $_SESSION['userid'];

  $userSchoolID = $_POST['schoolId'];

  $statement = $pdo->prepare("UPDATE user SET schoolid = ? WHERE id = $userid");
  $statement->execute(array($userSchoolID));


  $sql = "SELECT * FROM school WHERE school_id = $userSchoolID";
  foreach ($pdo->query($sql) as $row) {
    $schoolName = $row['school_name'];
  }

if(isset($schoolName)){
  $_SESSION['schoolId'] = $userSchoolID;
  $_SESSION['schoolError'] = null;


} else {
  $_SESSION['schoolError'] = "<div class='notification'>Die eingegene Nummer ist keiner Schule zugeordnet.<br></div><br>";
}
  header('Location: ../manageContent.php');

?>
