<?php
require __DIR__.'/vendor/autoload.php';
session_start();
if(!isset($_SESSION['userid'])) {
  die(header("location: ../login.php"));
;
}
use Spipu\Html2Pdf\Html2Pdf;

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
$userSchoolID = $_SESSION['schoolId'];


$pdo = new PDO('mysql:host=localhost;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');

$sql = "SELECT * FROM user WHERE id = $userid";
foreach ($pdo->query($sql) as $row) {

   $pdfSize = $row['pdf_size'];
   $pdfFont = $row['pdf_font'];
   $pdfFormat = $row['pdf_format'];

 }

if (isset($_GET['word'])) {

  $imgFile = urldecode($_GET['word']);
  $imgName = $imgFile;
  $path = 'files/';
  $imgMime = 'png';

}


 if(isset($_GET['imgFile'])) {

   $imgFile = $_GET['imgFile'];

   $sql = "SELECT * FROM school_$userSchoolID WHERE ImgFile = '$imgFile'";
   foreach ($pdo->query($sql) as $row) {
     $imgName = $row['ImgName'];
     $imgMime = $row['ImgMime'];
     $path = $row['path'];
    }

}

$selectedWordUC = ucfirst($imgFile);
$selectedWordLC = lcfirst($imgFile);

if(file_exists("files/metacom/".$selectedWordUC.".png")) {
  $metacom = "<img class='metacom' src='files/metacom/".$selectedWordUC.".png'>";
} else if (file_exists("files/metacom/".$selectedWordLC.".png")){
  $metacom = "<img class='metacom' src='files/metacom/".$selectedWordLC.".png'>";
}
  else {
  $metacom = "";
}

$html2pdf = new HTML2PDF($pdfFormat, $pdfSize, 'de');
// $html2pdf->addFont('candara','','fonts/candara.php');
$html2pdf->setDefaultFont($pdfFont,'', 'true');


$html2pdf->WriteHTML("<page>
<style>

h1 {
  font-size: 60px;
  text-align: center;
  margin-bottom: 40px;
  color: black;
  fonty-family: candara;
}

.gebaerde {
  max-height:80%;
  width:40%;
  align: left;
  float: left;
  margin-left: 5%;
  margin-right: 5%;

}

.metacom {
  max-height:80%;
  width:40%;
  align: right;
  float: right;
  margin-left: 5%;
  margin-right: 5%;
}

.footer {
  color: grey;
  position: absolute;
  bottom: 10px;
  right: 10px;
  font-size: 10px;
}
</style>

<h1>".$imgName."</h1>
<img class='gebaerde' src='".$path.$imgFile.".".$imgMime."'>


".$metacom."
<div class='footer'>PDF created online at tiloman.mooo.com</div>

</page>");


$html2pdf->Output($imgName.'.pdf');

?>
