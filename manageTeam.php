<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: login.php"));
;
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
$userSchoolID = $_SESSION['schoolId'];
$teamAdmin = $_SESSION['teamAdmin'];
$serial = $_SESSION['serial'];

$pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


?>

<html>
<head>

    <title>Gebärden</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap_navbar_custom.css">
    <link rel="stylesheet" type="text/css" href="css/stylesheet_welcome.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-21959683-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-21959683-2');
    </script>

<!-- JQUERY für Accordion -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">





</head>

<body style="background-image: linear-gradient(#6d918e, #10464c); text-align: center;">


  <?php include('php/navbar.php'); ?>





<div class="welcome_flex_container">
<div class='flexbox_user_info margin'>

<?php


if(isset($_GET['admin'])){
  $newAdmin = $_GET['admin'];
  $sql = "SELECT * FROM user WHERE id = $newAdmin";
  foreach ($pdo->query($sql) as $row) {
    $vorname = $row['vorname'];
    $nachname = $row['nachname'];
  }

  echo "<div class='success'>Die Adminrechte für $vorname $nachname wurden aktualisiert</div>";
}


if(isset($_GET['decline'])){
  $declinedUser = $_GET['decline'];
  $sql = "SELECT * FROM user WHERE id = $declinedUser";
  foreach ($pdo->query($sql) as $row) {
    $vorname = $row['vorname'];
    $nachname = $row['nachname'];
  }

  echo "<div class='notification'>$vorname $nachname wurde nicht hinzugefügt.</div>";
}

if(isset($_GET['confirmed'])){
  $confirmedUser = $_GET['confirmed'];
  $sql = "SELECT * FROM user WHERE id = $confirmedUser";
  foreach ($pdo->query($sql) as $row) {
    $vorname = $row['vorname'];
    $nachname = $row['nachname'];
  }
  echo "<div class='success'>$vorname $nachname wurde deinem Team hinzugefügt.</div>";
}



if ($teamAdmin === 'Ja') {
  $word = null;
  $erfolgreich = false;

  if ($userSchoolID == $schoolID) {

    echo ("<h3><i class='fas fa-school'></i> ".$schoolName."</h3>");

    echo "<p class='left'style='margin-bottom: 0em'><b><i class='fas fa-users'></i> Mitglieder Ihres Teams: </b></p>
          <p class='left'>Wählen Sie hier aus wer Ihr Team verwalten darf. Team Administratoren können Mitgliedschaftsanfragen bearbeiten.</p><br>
          <table style='width:100%' class='left'>
            <th>Vorname</th>
            <th>Nachname</th>
            <th class='right'>Admin</th>";

    $sql = "SELECT * FROM user WHERE schoolid = $schoolID ORDER BY nachname";
    foreach ($pdo->query($sql) as $row) {
      $vorname = $row['vorname'];
      $nachname = $row['nachname'];

      $admin = $row['teamAdmin'];
      $changeUser = $row['id'];
      echo "<tr>
      <td>$vorname  </td>
      <td>$nachname</td>

      <td class='right'>
        <form name='selectAdmin' action='php/selectAdmin.php' method='post'>
        <select name='admin' class='browser-default custom-select' style='width: 80px;'>
          <option value='$admin'>$admin</option>";

          if ($admin === 'Nein') {
            $adminAlt = 'Ja';
          } else {
            $adminAlt = 'Nein';}

      echo "
          <option value='$adminAlt'>$adminAlt</option>
          </select>
          <input type='text' value='$changeUser' class='hidden' name='changeUser'>
          <button type='submit' class='custom_button' style='width: 40px; margin: 0;'><i class='fas fa-sync'></i></button>
        </form>
      </td>
      </tr>";
      }
      echo "</table>";

    };

  ?>
  <script type="text/javascript">
    function submitForm(action) {
      var form = document.getElementById('confirmUser');
      form.action = action;
      form.submit();
    }
  </script>
  <?php


  echo "<hr>

  <p class='left'><b>Anfragen für die Aufnahme in Ihr Team:</b><br>";
$existingRequest = 0;

  $sql = "SELECT * FROM user WHERE grantedAccess = $schoolID ORDER BY nachname";
  foreach ($pdo->query($sql) as $row) {
    $existingRequest = $row['grantedAccess'];
  }
  if ($existingRequest != 0) {
    echo "
      <table style='width:100%' class='left'>
        <th>Vorname</th>
        <th>Nachname</th>
        <th style='text-align:right'>Beitritt</th>";

    foreach ($pdo->query($sql) as $row) {
      $vorname = $row['vorname'];
      $nachname = $row['nachname'];
      $grantedSchool = $row['grantedAccess'];
      $grantedUserId = $row['id'];
      echo "
        <form method=post id='confirmUser'>
        <tr>
        <td>$vorname</td>
        <td>$nachname</td>
        <td style='text-align:right'>
        <input type='text' class='hidden' value='$grantedUserId' name='grantedUser'>
        <input type='text' class='hidden' value='$grantedSchool' name='access' id=requestedSchool>";
          ?>

          <button type='submit' onclick="submitForm('php/confirmUser.php')" class='custom_button' style='width: 40px; margin: 0;'><i class='fas fa-check'></i></button>
          <button type='submit' onclick="submitForm('php/declineUser.php')" class='custom_button red' style='width: 40px; margin: 0;'><i class='fas fa-times'></i></button>

          <?php
        echo"
        </form>
        </td>
        </tr>";
    }
  echo "</table>";
  } else {
    echo "Derzeit gibt es keine Beitrittsanfragen.</p>";
    }

  echo "</div>";

}



//Fehler, wenn man kein Teamadmin ist.
if ($teamAdmin === 'Nein') {

  echo ("<h3><i class='fas fa-school'></i> Sie haben keine Berechtigung.</h3>
      <p class='left'>
        Sie sind nicht berechtigt diese Seite zu sehen.
      </p>
  ");
};

 ?>


<footer>
<p>2019 | Timo Lohmann | <a href="about.php">Impressum</a></p>
</footer>

<script src="js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



</body>
</html>
