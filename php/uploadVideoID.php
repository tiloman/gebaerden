<?php
// session_start();
// if(!isset($_SESSION['userid'])) {
//   die(header("location: ../login.php"));
// ;
// }



if (isset($_POST['imgIDforVideo'])) {
  $imgID = $_POST['imgIDforVideo'];

  $sql = "SELECT * FROM custom_img_12345 WHERE ImgID = '$imgID'";
  foreach ($pdo->query($sql) as $row) {
     $word = $row['ImgName'];
  }


};
$error = false;

$video_upload_folder = 'custom/videos/'; //Das Upload-Verzeichnis für Videos
$uploadNoticeVideo = null;
$video_error = false;

if (isset($_FILES['video']['name'])) {

  $Videofilename = pathinfo($_FILES['video']['name'], PATHINFO_FILENAME);
  $video_extension = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));


  //Überprüfung der Dateiendung
  $video_allowed_extensions = array('mp4', 'm4v', 'mov');
  if(!in_array($video_extension, $video_allowed_extensions)) {
   $uploadNoticeVideo = "Es dürfen nur Dateien vom Typ MP4 hochgeladen werden.";
   $video_error = true;
   // die("Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt");

  }

//Überprüfung der Dateigröße
if(!$video_error) {
  $max_size = 7* 1000*1000; //7MB
  if($_FILES['video']['size'] > $max_size) {
   $uploadNoticeVideo = "Bitte keine Dateien größer 7MB hochladen";
   $video_error = true;
  }
}


if(!$video_error) {
  //Pfad zum Upload
  $new_path_video = $video_upload_folder.$word.'_video.'.$video_extension;

  //Neuer Dateiname falls die Datei bereits existiert
  if(file_exists($new_path_video)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
   $id = 1;
   do {
   $new_path_video = $video_upload_folder.$word.'_'.$id.'_video.'.$video_extension;

   $id++;
   } while(file_exists($new_path_video));
  }

  //Alles okay, verschiebe Datei an neuen Pfad
  move_uploaded_file($_FILES['video']['tmp_name'], $new_path_video);

  // Eintragen in die Datenbank
  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $userid = $_SESSION['userid'];


  $statement = $pdo->prepare("UPDATE custom_img_12345 SET VideoID = ? WHERE ImgID = '$imgID'");
  $result = $statement->execute(array($word));

  $statement = $pdo->prepare("UPDATE custom_img_12345 SET VideoMime = ? WHERE ImgID = '$imgID'");
  $result = $statement->execute(array($video_extension));




  // die(header("location: ../profile.php"));
  echo($_FILES['video']['name']);
  $erfolgreich = "Video wurde erfolgreich hochgeladen!";
  $uploadNoticeVideo = null;
}
};






?>
