<?php
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: login.php"));
;
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

?>

<html>
<head>

    <title>Gebärden</title>

    <link rel="stylesheet" type="text/css" href="stylesheet.css">
      <link rel="stylesheet" type="text/css" href="stylesheet_navbar.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


</head>

<body>

  <div id="myTopnav" class="topnav">
    <div><input id="searchBar" type="text" placeholder="Suche ..."></div>
    <a href="/gebaerden/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    <a href="/gebaerden/profile.php"><i class="fas fa-user"></i> Home</a>
    <a href="about.php"><i class="fas fa-info"></i> About</a>
    <a href="javascript:void(0)" onclick="hideMetacom()" id="viewMetacom" class="filter_icon"><i class="far fa-image" title='Metacom Bilder eingeblendet'></i></a>
    <a href="javascript:void(0)" onclick="hideVideos()" id="viewVideos" class="filter_icon"><i class="fas fa-video-slash" title='Videos eingeblendet'></i></a>
    <a href="javascript:void(0);" class="icon" onclick="responsiveNav()"><i class="fa fa-bars"></i></a>
  </div>


<?php

	$dircontents = scandir('files');
  natcasesort($dircontents);

	// Elemente auflisten und in ul auflisten
	echo '<ul id="wordsList">';
	foreach ($dircontents as $file) {
		$extension = pathinfo($file, PATHINFO_EXTENSION);
    $cleanFileName = pathinfo($file, PATHINFO_FILENAME);
		if ($extension == 'png') {
			echo "<li>
              <div class='collapsible-header'>$cleanFileName</div>
              <div class='collapsible_body'></div>
            </li>";
		}
	}
	echo '</ul>';
?>


<script src="script.js"></script>

</body>
</html>
