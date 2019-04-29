<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
$selectedWord = "aber";


$html2pdf = new Html2Pdf();
$html2pdf->writeHTML("<html>

<body>
<h1>".$selectedWord."</h1>
<p>Die Konvertierung in PDF funktioniert noch nicht einwandfrei</p>
<img src='https://tiloman.mooo.com/gebaerden/files/".$selectedWord.".png 'style='height:30%; align: center'>

<br><br>
".$metacom."

</body>
</html>");
$html2pdf->output();

?>
