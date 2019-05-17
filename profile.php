<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: login.php"));
;
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
$userSchoolID = $_SESSION['schoolId'];

$pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


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


  <nav class="navbar navbar-expand-lg fixed-top navbar-light navbar-custom">
    <a class="navbar-brand" href="index.php">
        <img src="img/gebaerden_icon_g.png" width="35" height="35" style="border-radius: 3px;"alt="">
      </a>

      <form class="input-group-custom" action="index.php" method="get">
            <div class="input-group sm-3" ><input id="searchBar" type="text" class="form-control" placeholder="Suche ..." name="searchInput" value="<?php if(isset($_GET['searchInput'])) {$searchInput = $_GET['searchInput']; echo $searchInput;} ?>">
              <div class="input-group-append">
                <button class="btn btn-success" type="submit"><i class="fas fa-search" title='Suche'></i></button>
              </div>
            </div>
      </form>



      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars navbar_sandwich"></i>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav ml-auto" >

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-filter"></i> Mediathek
          </a>

          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class='dropdown-item' href='index.php'>Zeigs mir mit Gebärden</a>
            <?php
            $sql = "SELECT * FROM school WHERE school_id = $userSchoolID";
            foreach ($pdo->query($sql) as $row) {
              $schoolID = $row['school_id'];
              $schoolName = $row['school_name'];
            }
            if (isset($schoolName)) {
              if ($userSchoolID == $schoolID) {
                echo "

                <a class='dropdown-item' href='/gebaerden/custom_libraryID.php'>".$schoolName."</a>";
              }
            }
            else {
              echo "

              <a class='dropdown-item' href='/gebaerden/profile.php'>Schule anmelden</a>";
            }; ?>


          </div>
        </li>



        <li class="nav-item">
          <a class="nav-link" href="/gebaerden/profile.php"><i class="fas fa-user-cog"></i> Einstellungen</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/gebaerden/about.php"><i class="fas fa-info"></i> About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/gebaerden/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a
        </li>


      </ul>

      <div>

    </div>
  </nav>

<div class="welcome_flex_container">

<div class="flexbox_user_info margin">
<?php

$sql = "SELECT * FROM user WHERE id = $userid";
foreach ($pdo->query($sql) as $row) {
   echo "<p><b>Ihre Daten:</b></p>";
   echo "Name: " . $row['vorname']." ".$row['nachname']."<br />";
   echo "E-Mail: ".$row['email']."<br /><br />";

   $userSerial = $row['serial'];
   $userSchoolID = $row['schoolid'];
   $serial = null;

   $sql = "SELECT * FROM license WHERE serial = $userSerial";
   foreach ($pdo->query($sql) as $row) {
     $licensedSerial = $row['serial'];
     $licensedTo = $row['licensedto'];
}
   $sql = "SELECT * FROM school WHERE school_id = $userSchoolID";
   foreach ($pdo->query($sql) as $row) {
     $schoolID = $row['school_id'];
     $schoolName = $row['school_name'];
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
 <button id="changeProfileBtn" class="custom_button">Daten aktualisieren</button>


<!-- Update der User Daten; Wird in "user" Tabelle gespeichert -->

<script>
var changeProfileBtn = document.getElementById("changeProfileBtn");
    changeProfileBtn.addEventListener("click", showChangeProfileForm);
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


<div class="hidden" id="changeProfile">
<b>Daten ändern</b><br><br>


<?php
$sql = "SELECT * FROM user WHERE id = $userid";
foreach ($pdo->query($sql) as $row) {
   echo "<form action='php/changeUserData.php' method='post'>
   Vorname: <br>
   <input type='text' name='vorname' id='vorname' value=". $row['vorname']."><br><br>
   Nachname: <br>
   <input type='text' name='nachname' id='nachname' value=". $row['nachname']."><br><br>
   E-Mail: <br>
   <input type='mail' name='email' id='email' value=". $row['email']."><br><br>
   <input  type='submit' class='custom_button' value='Update'>
   </form>";
}
 ?>




</div>
</div>
</div>


<!-- Update der School ID; Wird in "school" Tabelle gespeichert -->
<div class="flexbox_user_info margin">
<b>Ihre Schule</b><br>

<?php

if (isset($schoolName)) {
$word = null;
$erfolgreich = false;

  // include ('php/uploadVideo.php');
  if ($userSchoolID == $schoolID) {
    include ('php/upload.php');

    echo ($schoolName);
    echo "<br><br>
    <div id='accordion'>
        <h3>Gebärden für Ihre Schule hochladen (BETA)</h3>
        <div>

          <form action='' method='post' enctype='multipart/form-data'>
            <input type='text' class='custom_input' placeholder='Name der Gebärde' name='word' required><br>

            <br>
              <div class='upload-btn-wrapper'>
                <button class='file_btn'><i class='fas fa-upload'></i> Bild</button>
                <input type='file' name='image'/>
              </div><br>
            <input type='submit' class='custom_button' value='Upload' id='uploadImgBtn'>
          </form>


    ";

    include('php/uploadVideo.php');


    if($erfolgreich == true){
      echo "Bild erfolgreich hochgeladen";
      echo $previewImg;


      echo "
      <form action='' method='post' enctype='multipart/form-data'>

        <input type='text' class='custom_input hidden' placeholder='Name der Gebärde' name='word' required value=".$word."><br>
        <input type='file' class='custom_input' name='video'><br>



        <input type='submit' class='custom_button' value='Video hinzufügen' id='uploadVideoBtn'>

      </form></div>";
    } else {
      echo "</div>";
    }
    if(isset($uploadNotice)) {
        echo "<div class='notification'>".$uploadNotice."</div>";
    }
    if(isset($uploadNoticeVideo)) {
        echo "<div class='notification'>".$uploadNoticeVideo."</div>";
    }



  }

echo "
 <h3>Fehlende Videos hinzfügen</h3>
 <div>";

 include('php/uploadVideoID.php');

 echo "
 <form action='' method='post' enctype='multipart/form-data'>
 Gebärde auswählen:<br>
 <select name='word' class='custom_input'>";
 $sql = "SELECT * FROM custom_img_12345 WHERE VideoID = '' ORDER BY ImgName";
 foreach ($pdo->query($sql) as $row) {
    echo "<option value='".$row['ImgID']."'>";
    echo $row['ImgName'];
    echo "</option>";
 }
 echo "</select>
 <input type='file' class='custom_input' name='video'><br>
 <input type='submit' class='custom_button' value='Video ergänzen' id='uploadVideoBtn'>


 </form></div>";


 echo "</div>";



if(isset($uploadNoticeVideo)) {
    echo "<div class='notification'>".$uploadNoticeVideo."</div>";
}
if($erfolgreich == true){
  echo "Video erfolgreich hinzugefügt";
}

}else {
  echo ("Wenn Ihre Schule bereits einen Zugang hat, können Sie hier den Zugangscode eingeben.<br><br>
    <form id='addSchool' action='php/addSchool.php' method='post'>
    <input name='schoolId' type='text' placeholder='Zugangsnummer'></input><br><br>
    <input type='submit' class='custom_button' value='Check In'></input>
    </form>


  ");
};

 ?>









 <br>

</div>




<div class="flexbox_user_info margin">
<b>Speichern Sie Ihr individuelles PDF Layout</b><br><br>




<!-- Update des Layouts; Wird in "user" Tabelle gespeichert -->
<?php
$sql = "SELECT * FROM user WHERE id = $userid";
foreach ($pdo->query($sql) as $row) {
   echo "<form id='changeLayout' action='php/changeLayout.php' method='post'>
   PDF Größe:<br>
     <select name='pdf_size' class='custom_input'>
       <option style='font-weight: bold'>" . $row['pdf_size']."</option>
       <option value='A4'>A4 (Standard)</option>
       <option value='A5'>A5</option>
     <select>

   <br><br>

   Schriftart:<br>
     <select name='pdf_font' class='custom_input'>
       <option style='font-weight: bold'>".$row['pdf_font']."</option>
       <option value='Helvetica'>Helvetica (Standard)</option>
       <option value='freemono'>Freemono</option>
       <option value='dejavusans'>Deja Vu Sans</option>
     <select>

     <br><br>

     Format:<br>
       <select name='pdf_format' class='custom_input'>
         <option style='font-weight: bold'>".$row['pdf_format']."</option>
         <option value='L'>Landscape (Standard)</option>
         <option value='H'>Hochformat</option>
       <select>

     <br /><br />";
   echo "<input type='submit' class='custom_button' value='Layout aktualisieren'><hr>";

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
<script src="js/script.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script>
 $( function() {
   $( "#accordion" ).accordion();
 } );
 </script>


</body>
</html>
