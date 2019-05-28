<?php

$description = $_POST['description'];
$ort = $_POST['ort'];
$PLZ = $_POST['PLZ'];
$schoolname = $_POST['schoolname'];
$user = $_POST['user'];
$license = $_POST['license'];
$adress = $_POST['adress'];


$empfaenger = "lohmanntimo@gmail.com";
$betreff = "Anfrage zur Aufnahme einer Schule";
$from = "From: Timo Lohmann <lohmanntimo@gmail.com>";
$text = "Es gibt eine neue Anfrage für die Aufnahme einer Schule.\n
User: $user
Name der Schule: $schoolname
Adresse: $adress \n $PLZ $ort
Beschreibung: $description
Lizenzanfrage: $license
";


$headers = "MIME-Version: 1.0\r\n";


mail($empfaenger, $betreff, $text, $from, $headers);

echo "<script>window.location.assign('../newSchool.php?mailsent=1')</script>";


?>
