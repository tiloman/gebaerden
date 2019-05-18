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
            <i class="fas fa-american-sign-language-interpreting"></i> Mediathek
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

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-cog"></i> Einstellungen
          </a>

          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class='dropdown-item' href='/gebaerden/profile.php'>Profil</a>
            <a class='dropdown-item' href='/gebaerden/pdfSettings.php'>PDF Einstellungen</a>


            <?php
            $sql = "SELECT * FROM school WHERE school_id = $userSchoolID";
            foreach ($pdo->query($sql) as $row) {
              $schoolID = $row['school_id'];
              $schoolName = $row['school_name'];
            }
            if (isset($schoolName)) {
              if ($userSchoolID == $schoolID) {
                echo "
                <a class='dropdown-item' href='/gebaerden/manageContent.php'>Gebärden verwalten</a>";

              }
            }
            else {
              echo "

              <a class='dropdown-item' href='/gebaerden/profile.php'>Schule anmelden</a>";
            }; ?>


          </div>
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




<!-- Update der School ID; Wird in "school" Tabelle gespeichert -->
<div class="flexbox_user_info margin">

  <?php if(isset($notice)){
    echo "<div class='notification'>".$notice."</div>";
  }
  if(isset($uploadNotice)) {
      echo "<div class='notification'>".$uploadNotice."</div>";
  }
  if(isset($uploadNoticeVideo)) {
      echo "<div class='notification'>".$uploadNoticeVideo."</div>";
  }

  if(isset($erfolgreich)){
    echo "Bild erfolgreich hochgeladen";

  }


  if($erfolgreichVideo == true){
    echo "Video erfolgreich hinzugefügt";
  }


  ?>


<?php

if (isset($schoolName)) {
$word = null;
$erfolgreich = false;

  // include ('php/uploadVideo.php');
  if ($userSchoolID == $schoolID) {
    include ('php/upload.php');

    echo ("<h3>".$schoolName."</h3>");


    $statement = $pdo->prepare("SELECT * FROM custom_img_12345");
    $statement->execute(array('Words'));
    $anzahl_words = $statement->rowCount();
    echo "<p class='left'>Bislang wurden $anzahl_words Gebärden hochgeladen. ";

    $statement = $pdo->prepare("SELECT * FROM custom_img_12345 WHERE UploadedBy = $userid");
    $statement->execute(array('UserWords'));
    $anzahl_user_words = $statement->rowCount();
    if ($anzahl_user_words > 1){
    echo "Davon haben Sie $anzahl_user_words  hochgeladen</p>";
    }
    echo "</div>



      <div class='flexbox_user_info margin'>
        <h3>Gebärde hochladen</h3>
        <p class='left'>Fügen Sie hier eine neue Gebärde hinzu.</p>
        <div>

          <form action='' method='post' enctype='multipart/form-data'>
            <input type='text' class='custom_input' placeholder='Name der Gebärde' name='word' required><br>

            <br>
            <input type='file' name='image' class='custom_input'/>
            <br>
            <input type='submit' class='custom_button' value='Upload' id='uploadImgBtn'>
          </form>

</div>
    ";

    include('php/uploadVideo.php');


    if($erfolgreich == true){
      echo $previewImg;

    }





  }
?>


</div><div class='flexbox_user_info margin'>

 <h3>Video hinzufügen</h3>
<p class='left'>Laden Sie ein Video hoch um das Verständnis zu erleichtern. In der Auswahl erscheinen alle Gebärden die noch kein Video haben.</p>
 <div>

 <?php include('php/uploadVideoID.php');?>


 <form action='' method='post' enctype='multipart/form-data'>
 Gebärde auswählen:<br>
 <select name='word' class='custom_input'>
   <option>Bitte auswählen ...</option>";
 <?php $sql = "SELECT * FROM custom_img_12345 WHERE VideoID = '' ORDER BY ImgName";
 foreach ($pdo->query($sql) as $row) {
    echo "<option value='".$row['ImgID']."'>";
    echo $row['ImgName'];
    echo "</option>";
 }
 ?>
 </select>
 <input type='file' class='custom_input' name='video'><br>
 <input type='submit' class='custom_button' value='Upload' id='uploadVideoBtn'>


 </form></div>


 </div>

<?php



}else {
  echo ("Wenn Ihre Schule bereits einen Zugang hat, können Sie hier den Zugangscode eingeben.<br><br>
    <form id='addSchool' action='php/addSchool.php' method='post'>
    <input name='schoolId' type='text' placeholder='Zugangsnummer'></input><br><br>
    <input type='submit' class='custom_button' value='Check In'></input>
    </form>


  ");
};

 ?>



<div class='flexbox_user_info margin'>

 <h3>Gebärde umbenennen</h3>
 <p class='left'>Tippfehler? Bessere Bezeichnung? Hier können Sie den Namen einer Gebärde verändern. Sie können nur Gebärden verändern, die Sie selbst hochgeladen haben.</p>
  <?php include ('php/changeCustomWord.php'); ?>
   <form action='' method='post' enctype='multipart/form-data'>
   Gebärde auswählen:<br>
     <select name='renameWord' class='custom_input'>
        <option>Bitte auswählen ...</option>";;

      <?php
        $sql = "SELECT * FROM custom_img_12345 WHERE UploadedBy = $userid ORDER BY ImgName";
        foreach ($pdo->query($sql) as $row) {
           echo "<option value='".$row['ImgName']."'>";
           echo $row['ImgName'];
           echo "</option>";
      }
      ?>

    </select>
  <input type='text' class='custom_input' name='newName'><br>
  <input type='submit' class='custom_button' value='Speichern'>

  </form>


</div>



<div class='flexbox_user_info margin'>

 <h3>Gebärde löschen</h3>
<p class='left'>Hier können Sie Einträge löschen. Jedoch nur die die von Ihnen selbst kommen.</p>
 <form action='' method='post' enctype='multipart/form-data'>
 Gebärde auswählen:<br>
 <select name='deleteWord' class='custom_input'>";

<?php $sql = "SELECT * FROM custom_img_12345 WHERE UploadedBy = $userid ORDER BY ImgName";
foreach ($pdo->query($sql) as $row) {
   echo "<option value='".$row['ImgID']."'>";
   echo $row['ImgName'];
   echo "</option>";
}
?>

</select>
<input type='submit' class='custom_button' value='Löschen'>


</form>

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
