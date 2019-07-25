<?php

session_start();
require('config.php');
$pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");
?>


<html>
<head>

    <title>My Sign Language - Registrierung</title>

    <link rel="stylesheet" type="text/css" href="css/stylesheet_welcome.css">
    <link rel="shortcut icon" href="https://img.icons8.com/ios-glyphs/100/000000/sign-language-interpretation.png">
    <link rel="icon" type="image/png" href="https://img.icons8.com/ios-glyphs/100/000000/sign-language-interpretation.png" sizes="32x32">
	  <link rel="icon" type="image/png" href="https://img.icons8.com/ios-glyphs/100/000000/sign-language-interpretation.png" sizes="96x96">
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

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

<body>
  <a href="index.php"><img style="max-width: 600px; width: 80%" src="img/Logo_var2.png"></a>


  <?php
  $showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

  if(isset($_GET['register'])) {
      $error = false;
      $email = $_POST['email'];
      $passwort = $_POST['passwort'];
      $passwort2 = $_POST['passwort2'];
      $vorname = $_POST['vorname'];
      $nachname = $_POST['nachname'];
      $errorMessage = null;


      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errorMessage = 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
          $error = true;
      }
      if(strlen($passwort) == 0) {
          $errorMessage =  'Bitte ein Passwort angeben<br>';
          $error = true;
      }
      if($passwort != $passwort2) {
          $errorMessage =  'Die Passwörter müssen übereinstimmen<br>';
          $error = true;
      }

      //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
      if(!$error) {
          $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
          $result = $statement->execute(array('email' => $email));
          $user = $statement->fetch();

          if($user !== false) {
              $errorMessage =  'Diese E-Mail-Adresse ist bereits vergeben<br>';
              $error = true;
          }
      }




      //Keine Fehler, wir können den Nutzer registrieren
      if(!$error) {
          $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
          $activationCode = rand(100000,999999);

          $statement = $pdo->prepare("INSERT INTO user (email, passwort, vorname, nachname, activationCode) VALUES (:email, :passwort, :vorname, :nachname, :activationCode)");
          $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'vorname' => $vorname, 'nachname' => $nachname, 'activationCode' => $activationCode));

          if($result) {
              echo "
              <div class='flexbox_head'>
                <div class='flexbox_login'>
                  <p class='login_text_head'>Willkommen.</p>
                  <p class='login_text'>Bitte überprüfen Sie Ihr Postfach. Eine Mail zur Bestätigung der Registrierung wurde gesendet.</p><br>

                </div>
              </div>";
              $showFormular = false;

              //Bestätigungsmail an mich verschicken
              $empfaenger = "timo.lohmann@uni-koeln.de";
              $betreff = "Neue Registrierung";
              $from = "From: Timo Lohmann <lohmanntimo@gmail.com>";
              $text = "$vorname $nachname hat sich soeben auf Gebärden registriert. \n
              Mail-Adresse: $email \n";
              $headers = "MIME-Version: 1.0\r\n";
              mail($empfaenger, $betreff, $text, $from, $headers);

              //Bestätigung an User verschicken
              $empfaenger = $email;
              $betreff = "Willkommen";
              $from = "From: Timo Lohmann <lohmanntimo@gmail.com>";
              $text = "Willkommen $vorname $nachname, \n Sie haben sich soeben bei My Sign Lanugage registriert. Um das Konto zu aktivieren müssen Sie Ihr Konto noch durch klick auf den folgenden Link bestätigen.\n https://tiloman.mooo.com/gebaerden/activate.php?code=$activationCode \n\n Wir wünschen Ihnen viel Spaß! \n";
              $headers = "MIME-Version: 1.0\r\n";
              mail($empfaenger, $betreff, $text, $from, $headers);


          } else {
              $errorMessage = 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
          }
      }
  }

  if($showFormular) {
  ?>


    <div class="flexbox_head">

      <div class="flexbox_login">
        <form id="register_form" action="?register=1" method="post">
          <p class="login_text_head">Registrierung.</p>
        <input required type="email" id="register_mail" name="email" placeholder="E-Mail"><br><br>
        <input required type="text" id="register_vorname" name="vorname" placeholder="Vorname"><br>
        <input required type="text" id="register_nachname" name="nachname" placeholder="Nachname"><br><br>
        <input required type="password" id="register_pw" name="passwort" placeholder="Passwort"><br>
        <input required type="password" id="register_pw" name="passwort2" placeholder="Passwort wiederholen"><br><br>

        <input type="submit" name="submit" value="Registrieren" class="custom_button"/>
        </form>
          <div class="notification">
            <?php
            if(isset($errorMessage)) {
                echo $errorMessage;
            }
            ?>
          </div>
      </div>


    </div>






<?php
} //Ende von if($showFormular)
?>


<footer>
<p>2019 | Timo Lohmann | <a href="about.php">Impressum</a></p>
</footer>


<script src="script.js"></script>


</body>
</html>
