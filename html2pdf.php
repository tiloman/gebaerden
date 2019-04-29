<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new HTML2PDF('L', 'A4', 'de');

$selectedWord = $_SERVER['QUERY_STRING'];

if(file_exists("files/metacom/".$selectedWord.".png")) {
  $metacom = "<img src='files/metacom/".$selectedWord.".png 'style='max-height:80%; width:40%; align: right; float: right'>";
} else {
  $metacom = "Kein Metacom Symbol vorhanden.";
}

$html2pdf->WriteHTML("<page>
<h1>".$selectedWord."</h1>
<img src='https://tiloman.mooo.com/gebaerden/files/".$selectedWord.".png 'style='max-height:80%; width:40%; align: left; float: left '>


".$metacom."


</page>");


$html2pdf->Output($selectedWord.'.pdf');

?>
