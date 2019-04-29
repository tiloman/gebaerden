<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new HTML2PDF();

// $selectedWord = $_SERVER['QUERY_STRING'];
// $metacom = undefined ;

// if(file_exists("files/metacom/".$selectedWord.".png")) {
//   $metacom = "<img src='files/metacom/".$selectedWord.".png 'style='height:30%; align: center'>";
// } else {
//   $metacom = "Kein Metacom Symbol vorhanden.";
// }


$html2pdf->WriteHTML("<html>

<body>
<h1>Test</h1>
<img src='https://tiloman.mooo.com/gebaerden/files/aber.png 'style='height:30%; align: center'>

<br><br>


</body>
</html>");




$html2pdf->Output('test.pdf');

?>
