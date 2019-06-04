<html>
<head>

    <title>Gebärden - Passwort vergessen</title>

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

  <nav class="navbar navbar-expand-lg fixed-top navbar-light navbar-custom">

    <a class="navbar-brand" href="#">
        <img src="img/gebaerden_icon_g.png" width="35" height="35" style="border-radius: 3px;"alt="">
      </a>

    


      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars navbar_sandwich"></i>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav ml-auto" >


        <li class="nav-item">
          <a class="nav-link" href="profile.php"><i class="fas fa-user"></i> Home</a>
        </li>


        <li class="nav-item">
          <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a
        </li>


      </ul>

      <div>

    </div>
  </nav>





  <div class="welcome_flex_container">
    <div class="flexbox_user_info">

      <?php
        $pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');

        function random_string() {
         if(function_exists('random_bytes')) {
         $bytes = random_bytes(16);
         $str = bin2hex($bytes);
         } else if(function_exists('openssl_random_pseudo_bytes')) {
         $bytes = openssl_random_pseudo_bytes(16);
         $str = bin2hex($bytes);
         } else if(function_exists('mcrypt_create_iv')) {
         $bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
         $str = bin2hex($bytes);
         } else {
         //Bitte euer_geheim_string durch einen zufälligen String mit >12 Zeichen austauschen
         $str = md5(uniqid(354198765124, true));
         }
         return $str;
        }


        $showForm = true;

        if(isset($_GET['send']) ) {
         if(!isset($_POST['email']) || empty($_POST['email'])) {
         $error = "<b>Bitte eine E-Mail-Adresse eintragen</b>";
         } else {
         $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
         $result = $statement->execute(array('email' => $_POST['email']));
         $user = $statement->fetch();

         if($user === false) {
         $error = "<b>Die E-Mail Adresse ist nicht bei uns registriert</b>";
         } else {
         //Überprüfe, ob der User schon einen Passwortcode hat oder ob dieser abgelaufen ist
         $passwortcode = random_string();
         $statement = $pdo->prepare("UPDATE user SET passwortcode = :passwortcode, passwortcode_time = NOW() WHERE id = :userid");
         $result = $statement->execute(array('passwortcode' => sha1($passwortcode), 'userid' => $user['id']));

         $empfaenger = $user['email'];
         $betreff = "Neues Passwort für deinen Account auf tiloman.mooo.com"; //Ersetzt hier den Domain-Namen
         $from = "From: Timo Lohmann <lohmanntimo@gmail.com>"; //Ersetzt hier euren Name und E-Mail-Adresse
         $url_passwortcode = 'http://tiloman.mooo.com/gebaerden/resetPassword.php?userid='.$user['id'].'&code='.$passwortcode; //Setzt hier eure richtige Domain ein
         $text = 'Hallo '.$user['vorname'].',
        für deinen Account wurde nach einem neuen Passwort gefragt. Um ein neues Passwort zu vergeben, rufe innerhalb der nächsten 24 Stunden die folgende Website auf:
        '.$url_passwortcode.'

        Sollte dir dein Passwort wieder eingefallen sein oder hast du dies nicht angefordert, so bitte ignoriere diese E-Mail.

        Viele Grüße';

         mail($empfaenger, $betreff, $text, $from);

         echo "Ein Link um dein Passwort zurückzusetzen wurde an deine E-Mail-Adresse gesendet.";
         $showForm = false;
         }
         }
        }

        if($showForm){
        ?>

        <h3>Passwort vergessen</h3>
        <p class="left">Gib hier deine E-Mail-Adresse ein, um ein neues Passwort anzufordern.</p>

        <?php
        if(isset($error) && !empty($error)) {
         echo $error;
        }
        ?>



          <form action="?send=1" method="post">
            <input type="email" name="email" class="custom_input" placeholder="E-Mail" value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>"><br>
            <input type="submit" class="custom_button" value="Neues Passwort">
          </form>


        <?php
      } //Endif von if($showForm)
        ?>

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
