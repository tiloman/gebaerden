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
    $text = "<html>
          <head>
              <title>Mitgliedschaftsanfrage</title>
          </head>

          <body>

          <h1>Mitgliedschaftsanfrage</h1>
          <p>Sie haben eine neue Mitgliedschaftsanfrage für Ihre Schule. Bitte bearbeiten Sie diese in Ihrer Teamverwaltung.</p>
          <a href='tiloman.mooo.com/gebaerden/manageTeam.php>Zur Teamverwaltung</a>
          </body>
          </html>


    ";

    mail($empfaenger, $betreff, $text, $from);
  }

echo "<script>window.location.assign('../manageContent.php')</script>";


?>
