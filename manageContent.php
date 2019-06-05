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

$pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');


?>

<html>
<head>

    <title>My Sign Language - Verwalten</title>

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
  include ('php/deleteEntry.php');
  include ('php/changeCustomWord.php');
  include ('php/uploadVideoID.php');
  include ('php/upload.php');


  if(isset($notice)){
    echo "<div class='notification'>".$notice."</div>";
  }
  if(isset($uploadNotice)) {
      echo "<div class='notification'>".$uploadNotice."</div>";
  }

  if(isset($erfolgreich)){
    echo "<div class='success'>".$erfolgreich."</div>";
  }



if (isset($schoolName)) {
$word = null;
$erfolgreich = false;

  // include ('php/uploadVideo.php');
  if ($userSchoolID == $schoolID) {

    echo ("<h3><i class='fas fa-school'></i> ".$schoolName."</h3>");

    $statement = $pdo->prepare("SELECT * FROM school_$userSchoolID");
    $statement->execute(array('Words'));

    $anzahl_words = $statement->rowCount();
    echo "<p class='left'>Bislang wurden $anzahl_words Gebärden hochgeladen. ";

    $statement = $pdo->prepare("SELECT * FROM school_$userSchoolID WHERE UploadedBy = $userid");
    $statement->execute(array('UserWords'));

    $anzahl_user_words = $statement->rowCount();
    if ($anzahl_user_words > 1){
      echo "Davon haben Sie $anzahl_user_words  hochgeladen</p><br>";
    }

    echo "<p class='left'style='margin-bottom: 0em'><b><i class='fas fa-users'></i> Mitglieder Ihres Teams: </b></p>
          <ol class='left' >";

    $sql = "SELECT * FROM user WHERE schoolid = $schoolID ORDER BY nachname";
    foreach ($pdo->query($sql) as $row) {
      $vorname = $row['vorname'];
      $nachname = $row['nachname'];
      echo "<li>$vorname $nachname</li>";
    }
    echo "</ol>";







};


$path = "custom/school_$userSchoolID";

function getdirsize($path)
  {
  	$result=explode("\t",exec("du -hs ".$path),2);
  	return ($result[1]==$path ? $result[0] : "error");
  }

  $belegt = getdirsize($path);

  $sql = "SELECT * FROM school WHERE school_id = $userSchoolID";
  foreach ($pdo->query($sql) as $row) {
     $diskspace = $row['space'];
   }

  $usedDiskspacePercent = round(intval($belegt)/$diskspace*100);

echo "
  <div id='diskspaceBarComplete'>
    <div id='diskspaceBar'>".$usedDiskspacePercent."%</div>
  </div>

  <script>
    var elem = document.getElementById('diskspaceBar');
    var width = 0;
    var id = setInterval(frame, 15);
    function frame() {
      if (width >= ".$usedDiskspacePercent.") {
        clearInterval(id);
      } else {
        width++;
        elem.style.width = width + '%';
        elem.innerHTML = width * 1 + '%';
      }
    }
  </script>";

  if ($usedDiskspacePercent < 100) {

echo "<p class='left'>Belegter Speicherplatz: ".intval($belegt)." MB von ".$diskspace." MB<br>
      Um mehr Speicher zu erhalten, kontaktieren Sie uns einfach.
      <p>  </div>";





?>



      <div class='flexbox_user_info margin'>
        <h3><i class='far fa-file-image'></i> Gebärde hochladen</h3>
        <p class='left'>Fügen Sie hier eine neue Gebärde hinzu.</p>
        <form action='' method='post' enctype='multipart/form-data'>
          <input type='text' class='custom_input' placeholder='Name der Gebärde' name='word' required>
          <br>
          <br>
          <input type='file' name='image' class='custom_input'/>
          <br>
          <input type='submit' class='custom_button' value='Upload' id='uploadImgBtn'>
        </form>
      </div>


      <div class='flexbox_user_info margin'>
        <h3><i class="far fa-file-video"></i> Video hinzufügen</h3>
        <p class='left'>Laden Sie ein Video hoch um das Verständnis zu erleichtern. Voraussetzung für den Upload eines Videos ist eine existierende Gebärde mit Bild.</p>
         <form action='' method='post' enctype='multipart/form-data'>

           <select name='imgIDforVideo' class='custom_input browser-default custom-select' required>
             <option value=''>Gebärde auswählen ...</option>";
             <?php
               $sql = "SELECT * FROM school_$userSchoolID WHERE VideoFile = '' ORDER BY ImgName";
               foreach ($pdo->query($sql) as $row) {
                  echo "<option value='".$row['ImgID']."'>";
                  echo $row['ImgName'];
                  echo "</option>";
                }
             ?>
           </select>
           <input type='file' class='custom_input' name='video'><br>
           <input type='submit' class='custom_button' value='Upload' id='uploadVideoBtn'>
         </form>
       </div>


<?php } else {
  echo "Der Upload neuer Gebärden wurde deaktiviert. Um neue Gebärden hochzuladen, löschen Sie alte oder kontaktieren Sie uns um mehr Speicher zu erhalten.</div>";

} ?>


       <div class='flexbox_user_info margin'>
         <h3><i class="far fa-edit"></i> Gebärde umbenennen</h3>
         <p class='left'>Tippfehler? Bessere Bezeichnung? Hier können Sie den Namen einer Gebärde verändern. Sie können nur Gebärden verändern, die Sie selbst hochgeladen haben.</p>
         <form action='' method='post' enctype='multipart/form-data'>

           <select name='renameWord' class='custom_input browser-default custom-select' required>
              <option value=''>Gebärde auswählen ...</option>";;
              <?php
                $sql = "SELECT * FROM school_$userSchoolID WHERE UploadedBy = $userid ORDER BY ImgName";
                foreach ($pdo->query($sql) as $row) {
                   echo "<option value='".$row['ImgName']."'>";
                   echo $row['ImgName'];
                   echo "</option>";
                 }
              ?>
          </select>
          <input type='text' class='custom_input' name='newName' placeholder='Neuer Name'><br>
          <input type='submit' class='custom_button' value='Umbenennen'>
        </form>
      </div>



      <div class='flexbox_user_info margin'>
        <h3><i class="far fa-trash-alt"></i> Gebärde löschen</h3>
        <p class='left'>Hier können Sie Einträge löschen. Jedoch nur die die von Ihnen selbst kommen.</p>
         <form action='' method='post' enctype='multipart/form-data'>

             <select name='deleteImgID' class='custom_input browser-default custom-select' required>";
             <option value=''>Gebärde auswählen ...</option>
             <?php
               $sql = "SELECT * FROM school_$userSchoolID WHERE UploadedBy = $userid ORDER BY ImgName";
               foreach ($pdo->query($sql) as $row) {
                 echo "<option value='".$row['ImgID']."'>";
                 echo $row['ImgName'];
                 echo "</option>";
               }
              ?>
            </select>
            <input type='submit' class='custom_button red' value='Löschen' onclick="return confirm('Sind Sie sicher?')">
        </form>
      </div>




<?php


}; //if wird an dieser Stelle geschlossen


//Falls keine Schule angemeldet ist.
if (!isset($schoolName)) {
  $sql = "SELECT * FROM user WHERE id = $userid";
  foreach ($pdo->query($sql) as $row) {
    $requestedSchool = $row['grantedAccess'];
  }


if ($requestedSchool != 0){
  echo ("Kein Zugang");

    $empfaenger = "lohmanntimo@gmail.com";
    $betreff = "Speicherplatz für Schule $userSchoolID";
    $from = "From: Timo Lohmann <lohmanntimo@gmail.com>";
    $text = "Die Schule $userSchoolID hat keinen Speicher mehr.\n";
    $headers = "MIME-Version: 1.0\r\n";

    mail($empfaenger, $betreff, $text, $from, $headers);


}
};

 ?>



  <!-- <div id="login_header">Gebärden.</div> -->

  <footer>
  <p>2019 | Timo Lohmann | <a href="about.php">Impressum</a></p>
  </footer>
<script src="js/script.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>





</body>
</html>
