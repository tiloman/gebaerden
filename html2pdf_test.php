<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;



$html2pdf = new Html2Pdf();
$selectedWord = $_SERVER['QUERY_STRING'];
$html2pdf->writeHTML("<html>

<body>
<h1>Aber</h1>
<p>Die Konvertierung in PDF funktioniert noch nicht einwandfrei</p>
<img src='https://tiloman.mooo.com/gebaerden/files/aber.png 'style='height:30%; align: center'>
<br><br>
</body>
</html>");
$html2pdf->output();

?>
