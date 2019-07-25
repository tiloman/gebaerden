<html>
<head>

    <title>My Sign Language - Registrierung</title>

    <link rel="stylesheet" type="text/css" href="css/stylesheet_welcome.css">
    <link rel="shortcut icon" href="https://img.icons8.com/ios-glyphs/100/000000/sign-language-interpretation.png">
    <link rel="icon" type="image/png" href="https://img.icons8.com/ios-glyphs/100/000000/sign-language-interpretation.png" sizes="32x32">
	  <link rel="icon" type="image/png" href="https://img.icons8.com/ios-glyphs/100/000000/sign-language-interpretation.png" sizes="96x96">
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap_navbar_custom.css">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

  <a href="index.php"><img style="max-width: 600px; width: 80%" src="img/Logo_var2.png"></a>



<?php
if (isset($_GET['code'])){

$submittedCode = $_GET['code'];

require('config.php');
$pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");

$sql = "SELECT * FROM user WHERE activationCode = $submittedCode";
foreach ($pdo->query($sql) as $row) {
  $name = $row['vorname'];
  $userid = $row['id'];
}

    if (isset($name)) {
      echo "<div class='flexbox_head'>
        <div class='flexbox_login'>
          <p class='login_text_head'>Willkommen, $name.</p>
          <p class='login_text'>Die Registrierung war erfolgreich.</p><br>
          <a href='login.php'>
            <input type='submit' class='custom_button' value='Zum Login'>
          </a>
        </div>";

        $statement = $pdo->prepare("UPDATE user SET activationCode = ? WHERE id = $userid");
        $statement->execute(array(0));

    } else {
      echo "<div class='flexbox_head'>
        <div class='flexbox_login'>
          <p class='login_text_head'>Fehler.</p>
          <p class='login_text'>Prüfen Sie bitte ob der KOMPLETTE Link aus der Mail im Browser angezeigt wird.</p><br>
        </div>";

    }
} else {
  echo "<div class='flexbox_head'>
    <div class='flexbox_login'>
      <p class='login_text_head'>Fehler.</p>
      <p class='login_text'>Prüfen Sie bitte ob der KOMPLETTE Link aus der Mail im Browser angezeigt wird.</p><br>
    </div>";
}

?>

<footer>
<p>2019 | Timo Lohmann | <a href="about.php">Impressum</a></p>
</footer>
<script src="script.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>
