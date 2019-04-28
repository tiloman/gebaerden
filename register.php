<?php

session_start();
$pdo = new PDO('mysql:host=192.168.178.36;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');

?>


<html>
<head>

    <title>Gebärden - Registrierung</title>

    <link rel="stylesheet" type="text/css" href="stylesheet_welcome.css">
    <link rel="shortcut icon" href="https://img.icons8.com/ios-glyphs/100/000000/sign-language-interpretation.png">
    <link rel="icon" type="image/png" href="https://img.icons8.com/ios-glyphs/100/000000/sign-language-interpretation.png" sizes="32x32">
	  <link rel="icon" type="image/png" href="https://img.icons8.com/ios-glyphs/100/000000/sign-language-interpretation.png" sizes="96x96">
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>

<body>


  <?php
  $showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

  if(isset($_GET['register'])) {
      $error = false;
      $email = $_POST['email'];
      $passwort = $_POST['passwort'];
      $passwort2 = $_POST['passwort2'];
      $vorname = $_POST['vorname'];
      $nachname = $_POST['nachname'];
      $serial = $_POST['serial'];
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

      //Seriennummer überprüfen
      if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM license WHERE serial = :serial");
        $result = $statement->execute(array('serial' => $serial));
        $user = $statement->fetch();

        if($user == false) {
            $errorMessage = 'Die eingegebene Seriennummer ist falsch <br> Bitte wenden Sie sich an: lohmanntimo@gmail.com.';
            $error = true;
        }
      }


      //Keine Fehler, wir können den Nutzer registrieren
      if(!$error) {
          $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

          $statement = $pdo->prepare("INSERT INTO user (email, passwort, vorname, nachname, serial) VALUES (:email, :passwort, :vorname, :nachname, :serial)");
          $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'vorname' => $vorname, 'nachname' => $nachname, 'serial' => $serial));

          if($result) {
              echo "Du wurdest erfolgreich registriert.'.'<a href='/gebaerden/login.php'>Zum Login </a>";
              $showFormular = false;
          } else {
              echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
          }
      }
  }

  if($showFormular) {
  ?>
  <a href="index.php"><div id="login_header">Gebärden.</div></a>
  <!-- <i id="login_icon" class="fas fa-sign-language"></i> -->


    <div class="flexbox_head">
      <!-- <p class="head_text">Willommen! <br><br>Hier finden Sie eine Sammlung von Gebärden.</p> -->

      <div class="flexbox_login">
        <form id="register_form" action="?register=1" method="post">
          <p class="login_text_head">Registrierung.</p>
          <p class="login_text">Für die vollständige Registrierung ist eine gültige Seriennummer erforderlich. </p>
        <input required type="email" id="register_mail" name="email" placeholder="E-Mail"><br><br>
        <input required type="text" id="register_vorname" name="vorname" placeholder="Vorname"><br>
        <input required type="text" id="register_nachname" name="nachname" placeholder="Nachname"><br><br>
        <input required type="password" id="register_pw" name="passwort" placeholder="Passwort"><br>
        <input required type="password" id="register_pw" name="passwort2" placeholder="Passwort wiederholen"><br><br>
        <input required type="text" id="register_serial" name="serial" placeholder="Seriennummer"><br>

        <input type="submit" name="submit" value="Registrieren" id="register_btn"/>
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
