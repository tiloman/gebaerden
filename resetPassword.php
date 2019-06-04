<html>
<head>

    <title>Gebärden - Passwort zurücksetzen</title>

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



  <div class="welcome_flex_container">
    <div class="flexbox_user_info">

      <?php
      $pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');

      if(!isset($_GET['userid']) || !isset($_GET['code'])) {
       die("Leider wurde beim Aufruf dieser Website kein Code zum Zurücksetzen deines Passworts übermittelt");
      }

      $userid = $_GET['userid'];
      $code = $_GET['code'];

      //Abfrage des Nutzers
      $statement = $pdo->prepare("SELECT * FROM user WHERE id = :userid");
      $result = $statement->execute(array('userid' => $userid));
      $user = $statement->fetch();

      //Überprüfe dass ein Nutzer gefunden wurde und dieser auch ein Passwortcode hat
      if($user === null || $user['passwortcode'] === null) {
       die("Es wurde kein passender Benutzer gefunden");
      }

      if($user['passwortcode_time'] === null || strtotime($user['passwortcode_time']) < (time()-24*3600) ) {
       die("Dein Code ist leider abgelaufen");
      }


      //Überprüfe den Passwortcode
      if(sha1($code) != $user['passwortcode']) {
       die("Der übergebene Code ist ungültig. Stell sicher, dass du den genauen Link in der URL aufgerufen hast.");
      }

      //Der Code war korrekt, der Nutzer darf ein neues Passwort eingeben

      if(isset($_GET['send'])) {
       $passwort = $_POST['passwort'];
       $passwort2 = $_POST['passwort2'];

       if($passwort != $passwort2) {
       echo "Bitte identische Passwörter eingeben";
       } else { //Speichere neues Passwort und lösche den Code
       $passworthash = password_hash($passwort, PASSWORD_DEFAULT);
       $statement = $pdo->prepare("UPDATE user SET passwort = :passworthash, passwortcode = NULL, passwortcode_time = NULL WHERE id = :userid");
       $result = $statement->execute(array('passworthash' => $passworthash, 'userid'=> $userid ));

       if($result) {
       die("Dein Passwort wurde erfolgreich geändert");
       }
       }
      }
      ?>

      <h1>Neues Passwort vergeben</h1>
      <form action="?send=1&amp;userid=<?php echo htmlentities($userid); ?>&amp;code=<?php echo htmlentities($code); ?>" method="post">
      Bitte gib ein neues Passwort ein:<br>
      <input type="password" name="passwort"><br><br>

      Passwort erneut eingeben:<br>
      <input type="password" name="passwort2"><br><br>

      <input type="submit" value="Passwort speichern">
      </form>

    </div>
</div>


<footer>
<p>2019 | Timo Lohmann | <a href="about.php">Impressum</a></p>
</footer>
<script src="script.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>
