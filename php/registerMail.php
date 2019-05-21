<?php
$empfaenger = "timo.lohmann@uni-koeln.de";
$betreff = "Neue Registrierung";
$from = "From: Timo Lohmann <lohmanntimo@gmail.com>";
$text = "Jemand neues hat sich soeben auf Gebärden registriert.";
$headers = "MIME-Version: 1.0\r\n";


mail($empfaenger, $betreff, $text, $from, $headers);
?>
