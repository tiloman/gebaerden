<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');

if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        $_SESSION['schoolId'] = $user['schoolid'];
        die(header("location: index.php"));
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }

}
?>




<html>
<head>

    <title>Gebärden - Login</title>

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




<a href="index.php"><div id="login_header">Gebärden.</div></a>
<!-- <i id="login_icon" class="fas fa-sign-language"></i> -->


  <div class="flexbox_head">
    <!-- <p class="head_text">Willommen! <br><br>Hier finden Sie eine Sammlung von Gebärden.</p> -->

    <div class="flexbox_login">
      <form id="login_form" action="?login=1" method="post">
        <p class="login_text_head">Login.</p>
        <input required type="email" id="login_user" name="email" placeholder="E-Mail"><br>
        <input required type="password" id="login_pw" name="passwort" placeholder="Passwort"><br>
        <input type="submit" name="submit" value="Einloggen" id="login_btn"/>
      </form>
      <div class="notification">
        <?php
        if(isset($errorMessage)) {
            echo $errorMessage;
        }
        ?>
      </div>
      <a href="/gebaerden/register.php">Noch keinen Account? Hier registrieren!</a>
    </div>


  </div>
<div class="login_flex_container">
  <div class="flexbox_trans">
    <img src="/gebaerden/img/responsive_gebaerden.png">
  </div>

  <div class="flexbox_trans">
    <p class="head_text_white"> Responsives Design</p>
    <p class="sub_text_left"> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et</p>
  </div>


</div>



<div class="login_flex_container_white">
  <div class="flexbox_small">
    <video autoplay muted loop playsinline preload="auto">
      <source src="/gebaerden/img/gebaerden_iphone_video.mp4" type="video/mp4">
      <source src="/gebaerden/img/gebaerden_iphone_video.mov" type="video/mp4">
    </video>
  </div>

  <div class="flexbox_big">
    <!-- <img class="img_left" src="https://upload.wikimedia.org/wikipedia/commons/1/13/Sign_language_T.svg" height=200px> -->
    <p class="head_text_black">Einfache Suche</p>
    <p class="sub_text_right">
      Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
  </div>
</div>

<div class="login_flex_container_white">

  <div class="flexbox_big">
    <!-- <img class="img_left" src="https://upload.wikimedia.org/wikipedia/commons/1/13/Sign_language_T.svg" height=200px> -->
    <p class="head_text_black_left">Über 1300 Gebärden</p>
    <p class="sub_text_left_black">
      Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
  </div>

  <div class="flexbox_small">
    <img src="/gebaerden/img/chart.png">
  </div>
</div>


<div class="login_flex_container">


  <div class="flexbox_trans">
    <!-- <img class="img_left" src="https://upload.wikimedia.org/wikipedia/commons/1/13/Sign_language_T.svg" height=200px> -->
    <p class="head_text_white"><i class='far fa-file-pdf'></i> PDF Export</p>
    <p class="sub_text_left">
      Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
  </div>
  <div class="flexbox_trans">
    <img src="/gebaerden/img/pdf_preview.jpg" class="img_shadow">
  </div>

</div>

<footer>
<p>2019 | Timo Lohmann | <a href="about.php">Impressum</a></p>
</footer>



<script src="script.js"></script>


</body>
</html>
                                                                                                                       
