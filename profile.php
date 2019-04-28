<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: login.php"));
;
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

$pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'root', 'pmc2000');


?>

<html>
<head>

    <title>Gebärden</title>

    <link rel="stylesheet" type="text/css" href="stylesheet_welcome.css">
    <link rel="stylesheet" type="text/css" href="stylesheet_navbar.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>




</head>

<body style="background-image: linear-gradient(#6d918e, #10464c); text-align: center;">


  <div id="myTopnav" class="topnav">
    <a href="/gebaerden/index.php" class="search_icon"><i class="fas fa-search"></i> Suche</a>
    <a href="/gebaerden/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    <a href="/gebaerden/profile.php" class="nav_active"><i class="fas fa-user"></i> Home</a>
    <a href="about.php"><i class="fas fa-info"></i> About</a>
    <a href="javascript:void(0);" class="icon" onclick="responsiveNav()"><i class="fa fa-bars"></i></a>
  </div>

<div class="welcome_flex_container">

<div class="flexbox_user_info">
<?php
$sql = "SELECT * FROM user WHERE id = $userid";
foreach ($pdo->query($sql) as $row) {
   echo "<p><b>Ihre Daten:</b></p>";
   echo "Name: " . $row['vorname']." ".$row['nachname']."<br />";
   echo "E-Mail: ".$row['email']."<br /><br />";
   echo "Seriennummer: ".$row['serial']."<br /><br />";

   $userSerial = $row['serial'];
   $serial = null;

   $sql = "SELECT * FROM license WHERE serial = $userSerial";
   foreach ($pdo->query($sql) as $row) {
     $licensedSerial = $row['serial'];
     $licensedTo = $row['licensedto'];
}

if (isset($licensedSerial)) {
  if ($userSerial == $licensedSerial) {
    echo ("Die Seriennummer ist lizensiert für: <br>");
    echo ($licensedTo);
  }
}else {
  echo ("Die Lizenz ist ungültig! Bitte wenden Sie sich an lohmanntimo@gmail.com");
}

}

 ?>
</div>
</div>
  <!-- <div id="login_header">Gebärden.</div> -->

  <footer>
  <p>2019 | Timo Lohmann | <a href="about.php">Impressum</a></p>
  </footer>
<script src="script.js"></script>

</body>
</html>
