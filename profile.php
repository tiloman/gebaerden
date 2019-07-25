<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: login.php"));
;
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
$userSchoolID = $_SESSION['schoolId'];
$serial = $_SESSION['serial'];

require('config.php');
$pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");

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
  <div class="flexbox_user_info margin">
      <?php

      $sql = "SELECT * FROM user WHERE id = $userid";
      foreach ($pdo->query($sql) as $row) {
         echo "<p><h3><i class='fas fa-user'></i> Ihre Daten</h3></p>";
         echo "Name: <b>" . $row['vorname']." ".$row['nachname']."</b><br />";
         echo "E-Mail: <b>".$row['email']."</b><br />";

         $userSerial = $row['serial'];
         $userSchoolID = $row['schoolid'];
       }
      ?>

      <script>
      //Change Profile Data einblenden


      function showChangeProfileForm(){

        var changeProfileBox = document.getElementById("changeProfile");
        changeProfileBox.classList.toggle("hidden");

        if (changeProfileBox.classList.contains("hidden")) {
          changeProfileBox.style.maxHeight = "200px;"
        } else {
          changeProfileBox.style.maxHeight= "500px;"

        }

      }
      </script>


       <button id="changeProfileBtn" class="custom_button" onclick="showChangeProfileForm()">Daten aktualisieren</button>


      <div class="hidden" id="changeProfile">
      <br>




      <?php
      $sql = "SELECT * FROM user WHERE id = $userid";
      foreach ($pdo->query($sql) as $row) {
         echo "<form action='php/changeUserData.php' method='post'>
         Vorname: <br>
         <input type='text' class='custom_input' name='vorname' id='vorname' value=". $row['vorname']."><br><br>
         Nachname: <br>
         <input type='text' class='custom_input' name='nachname' id='nachname' value=". $row['nachname']."><br><br>
         E-Mail: <br>
         <input type='mail' class='custom_input' name='email' id='email' value=". $row['email']."><br><br>
         <input  type='submit' class='custom_button' value='Update'>
         </form>";
      }
       ?>

      </div>



    </div>





<?php
//--------------------------Alles was mit Schule zutun hat... -----------------------------

echo"<div class='flexbox_user_info margin'>";

include('php/infoboxSchool.php');

echo"</div>";


//-------------------Zeigs mir mit Gebärden -------------
echo "<div class='flexbox_user_info margin'>";


include('php/infoboxZeigs.php');


?>
</div>







  <!-- <div id="login_header">Gebärden.</div> -->

  <footer>
  <p>2019 | Timo Lohmann | <a href="about.php">Impressum</a></p>
  </footer>
<script src="js/script.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>





</body>
</html>
