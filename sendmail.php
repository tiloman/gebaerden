<?php
$empfaenger = "lohmanntimo@gmail.com";
$betreff = "Die Mail-Funktion";
$from = "From: Vorname Nachname <lohmanntimo@gmail.com>\r\n";
$from .= "Reply-To: lohmanntimo@gmail.com\r\n";
$from .= "Content-Type: text/html\r\n";
$text = "Hier lernt Ihr, wie man mit <b>PHP</b> Mails
verschickt";

mail($empfaenger, $betreff, $text, $from);
?>
