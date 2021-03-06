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

if ($userSchoolID != 0 and $serial == 0) {
  header("location: custom_libraryID.php");
  exit(1);
}

if ($userSchoolID == 0  and $serial == 0) {
  header("location: welcome.php");
  exit(1);
}

require('config.php');
$pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");
?>

<html>
<head>

    <title>My Sign Language</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap_navbar_custom.css">
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="css/stylesheet_welcome.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script defer src="js/script.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-21959683-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-21959683-2');
    </script>

</head>

<body>

  <?php include('php/navbar.php'); ?>


<div class='container'>
  <div class='flexbox_user_info'>
  <h3><i class='fas fa-school'></i> Zeigs mir mit Gebärden</h3>

  <form class="input-group" action="index.php" method="get">
        <div class="input-group sm-3" ><input id="searchBar" type="text" class="form-control" placeholder="Suche ..." name="searchInput" value="<?php if(isset($_GET['searchInput'])) {$searchInput = $_GET['searchInput']; echo $searchInput;} ?>">
          <div class="input-group-append">
            <button class="btn btn-success" type="submit"><i class="fas fa-search" title='Suche'></i></button>
          </div>
        </div>
  </form>
</div>

<?php

	$dircontents = scandir('files');
  natcasesort($dircontents);
  $metacomexists = null;
  $metacomCase = null;
  $videoexists = null;

  $imgPath = 'files/';
  $imgMime = 'png';

  $videoPath = 'files/video/';
  $videoMime = '_video.m4v';

	// Elemente auflisten und in ul auflisten


  $sql = "SELECT * FROM user WHERE id = $userid";
  foreach ($pdo->query($sql) as $row) {
    $userSerial = $row['serial'];
  }

  $sql = "SELECT * FROM license WHERE serial = $userSerial";
  foreach ($pdo->query($sql) as $row) {
    $licensedSerial = $row['serial'];
    $licensedTo = $row['licensedto'];
  }

if ($licensedSerial !== $userSerial) {

  include('welcome.php');

} else {

	echo '<ul id="wordsList" class="wordsList">';
	foreach ($dircontents as $file) {
		$extension = pathinfo($file, PATHINFO_EXTENSION);
    $cleanFileName = pathinfo($file, PATHINFO_FILENAME);
    $cleanFileNameUC = ucfirst($cleanFileName);
    $cleanFileNameLC = lcfirst($cleanFileName);


    if(file_exists("files/metacom/".$cleanFileNameUC.".png")) {
      $metacomexists = "<i class='far fa-smile' title='Metacom'></i>";
      $metacomCase = "metacomUC";
    } else if(file_exists("files/metacom/".$cleanFileNameLC.".png")) {
      $metacomexists = "<i class='far fa-smile' title='Metacom'></i>";
      $metacomCase = "metacomLC";
    } else {
      $metacomexists = null;
    }

    if(file_exists($videoPath.$cleanFileNameUC.$videoMime)) {
      $videoexists = "<i class='fas fa-video' title='Video'></i>";
    } else if(file_exists($videoPath.$cleanFileNameLC.$videoMime)) {
      $videoexists = "<i class='fas fa-video' title='Video'></i>";
    } else {
      $videoexists = null;
    }

		if ($extension == $imgMime) {
			echo "<li>
              <div class='collapsible-header'>$cleanFileName
              <div class='collapsible-icons'>$metacomexists$videoexists</div></div>
              <div class='collapsible_body'>";

              echo "<div class='collapsible_body_content img'></div>";

              if ($videoexists !== null) {
                echo "<div class='collapsible_body_content video'></div>";
              }

              if ($metacomexists !== null) {
                echo "<div class='collapsible_body_content ".$metacomCase."'></div>";
              }

              echo "
              <div class='collapsible_body_pdf'>
              <a class='a_white' target='_blank' href='html2pdf.php?word=".urlencode($cleanFileName)."' method='get'> PDF generieren <i class='far fa-file-pdf'></i></a></div>
              </div></li>";


            ;
		}
	}
	echo '</ul>';
  }
?>



<div class="row">
        <div class="col-md-12">

          <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body" id='modal-content'>
                  <img src="img/forbidden.jpg" class="">
                </div>
              </div>
            </div>
          </div>


</div>

</body>
</html>
