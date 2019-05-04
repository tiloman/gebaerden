<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: login.php"));
;
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

$pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-21959683-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-21959683-2');
    </script>



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
<br><br>
 <button id="changeProfileBtn">Daten aktualisieren</button>
</div>
<br>

<!-- Update der User Daten; Wird in "user" Tabelle gespeichert -->

<script>
var changeProfileBtn = document.getElementById("changeProfileBtn");
    changeProfileBtn.addEventListener("click", showChangeProfileForm);
function showChangeProfileForm(){
  document.getElementById("changeProfile").style.display = "block";
}
</script>


<div class="flexbox_user_info" id="changeProfile">
<b>Daten ändern</b><br><br>
<?php
$sql = "SELECT * FROM user WHERE id = $userid";
foreach ($pdo->query($sql) as $row) {
   echo "<form action='changeUserData.php' method='post'>
   Vorname: <br>
   <input type='text' name='vorname' id='vorname' value=". $row['vorname']."><br><br>
   Nachname: <br>
   <input type='text' name='nachname' id='nachname' value=". $row['nachname']."><br><br>
   E-Mail: <br>
   <input type='mail' name='email' id='email' value=". $row['email']."><br><br>
   <input type='submit' value='Update'>
   </form>";
}
 ?>




</div>


</div>
<br>
<div class="flexbox_user_info">
<b>PDF Layout</b><br><br>




<!-- Update des Layouts; Wird in "user" Tabelle gespeichert -->
<?php
$sql = "SELECT * FROM user WHERE id = $userid";
foreach ($pdo->query($sql) as $row) {
   echo "<form id='changeLayout' action='changeLayout.php' method='post'>
   PDF Größe:<br>
     <select name='pdf_size'>
       <option style='font-weight: bold'>" . $row['pdf_size']."</option>
       <option value='A4'>A4 (Standard)</option>
       <option value='A3'>A3</option>
     <select>

   <br><br>

   Schriftart:<br>
     <select name='pdf_font'>
       <option style='font-weight: bold'>".$row['pdf_font']."</option>
       <option value='Helvetica'>Helvetica (Standard)</option>
       <option value='Norddruck'>Norddruck</option>
       <option value='ABC'>ABC</option>
     <select>

     <br /><br />";
   echo "<input type='submit' value='Layout aktualisieren'>";

}
 ?>

 <br><br>
 <img src="/gebaerden/img/pdf_preview.jpg" class="pdf_preview" style="width: 50%; border: 1px solid">

</div>


</div>
  <!-- <div id="login_header">Gebärden.</div> -->

  <footer>
  <p>2019 | Timo Lohmann | <a href="about.php">Impressum</a></p>
  </footer>
<script src="script.js"></script>

</body>
</html>
