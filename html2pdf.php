<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;


$selectedWord = $_SERVER['QUERY_STRING'];

$metacom = undefined ;

if(file_exists("files/metacom/".$selectedWord.".png")) {
  $metacom = "<img src='files/metacom/".$selectedWord.".png 'style='height:30%; align: center'>";
} else {
  $metacom = "Kein Metacom Symbol vorhanden.";

}


$content = "<html>

<body>
<h1>".$selectedWord."</h1>
<p>Die Konvertierung in PDF funktioniert noch nicht einwandfrei</p>
<img src='https://tiloman.mooo.com/gebaerden/files/".$selectedWord.".png 'style='height:30%; align: center'>

<br><br>
".$metacom."

</body>
</html>";

// Clean any content of the output buffer

//HTML to PDF conversion
$html2pdf = new HTML2PDF('L','A4','de',true,'UTF-8',array(10, 10, 10, 10));
$html2pdf->WriteHTML($content);

ob_end_clean();

$html2pdf->Output($selectedWord.'.pdf');

?>
