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

    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
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

<body>

  <nav class="navbar navbar-expand-lg fixed-top navbar-light navbar-custom">
    <a class="navbar-brand" href="#">
        <img src="img/gebaerden_icon_g.png" width="35" height="35" style="border-radius: 3px;"alt="">
      </a>
      <form class="input-group-custom" action="custom_library.php" method="get">
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
            <i class="fas fa-filter"></i> Filtern
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" onclick="hideMetacom()" href="javascript:void(0)" id="viewMetacom"><img src="img/metacom.png" height="20px" title="Metacom eingeblendet">Metacom</a>
            <a class="dropdown-item" onclick="hideVideos()" href="javascript:void(0)" id="viewVideos"><i class="fas fa-video-slash" title='Videos eingeblendet'></i>Video</a>
            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="#">Mediathek:</a>
            <a class="dropdown-item" href="index.php">Zeigs mir mit Gebärden</a>


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

<?php

$metacomexists = null;
$metacomCase = null;
$videoexists = null;

$imgPath = 'custom/';

$videoPath = 'custom/videos/';





  echo '<ul id="wordsList">';


$sql = "SELECT * FROM custom_img_12345 ORDER BY ImgName";
foreach ($pdo->query($sql) as $row) {
  $cleanFileName = $row['ImgName'];
  $videoMime = $row['VideoMime'];

  if($videoMime !== "") {
      $videoexists = "<i class='fas fa-video' title='Video'></i>";
  }else {
    $videoexists = null;
  }


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
              <a class='a_white' target='_blank' href='html2pdf.php?word=".urlencode($cleanFileName)."&path=".$imgPath."&imgEnding=.".$videoMime."' method='get'><i class='far fa-file-pdf'></i>PDF generieren</a></div>
              ";


              $sql = "SELECT * FROM custom_img_12345 WHERE ImgName = '$cleanFileName'";
              foreach ($pdo->query($sql) as $row) {
                $uploaderID = $row['UploadedBy'];
              };
              if (isset($uploaderID)){
                $sql = "SELECT * FROM user WHERE id = $uploaderID";
                foreach ($pdo->query($sql) as $row) {
                  echo "<div class='collapsible_body_uploader'>
                  Hochgeladen von ".$row['vorname']." ".$row['nachname']."
                  </div>";
              }};


            echo "</div></li>";



}










?>


<script src="js/custom_library.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>
