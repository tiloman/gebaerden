<?php


$userSchoolID = $_SESSION['schoolId'];

if (isset($_POST['imgIDforVideo'])) {
  $imgID = $_POST['imgIDforVideo'];

  $sql = "SELECT * FROM school_$userSchoolID WHERE ImgID = '$imgID'";
  foreach ($pdo->query($sql) as $row) {
     $word = $row['ImgName'];
  }


};
$error = false;

$video_upload_folder = 'custom/school_'.$userSchoolID.'/'; //Das Upload-Verzeichnis für Videos

$video_error = false;

if (isset($_FILES['video']['name'])) {

  $Videofilename = pathinfo($_FILES['video']['name'], PATHINFO_FILENAME);
  $video_extension = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));


  //Überprüfung der Dateiendung
  $video_allowed_extensions = array('mp4', 'm4v', 'mov');
  if(!in_array($video_extension, $video_allowed_extensions)) {
   $uploadNotice = "Es dürfen nur Dateien vom Typ MP4, MOV oder M4V hochgeladen werden.";
   $video_error = true;
   // die("Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt");

  }

//Überprüfung der Dateigröße
if(!$video_error) {
  $max_size = 15* 1000*1000; //7MB
  if($_FILES['video']['size'] > $max_size) {
   $uploadNotice = "Bitte keine Dateien größer 15MB hochladen";
   $video_error = true;
  }
}


if(!$video_error) {
  //Pfad zum Upload
  $new_path_video = $video_upload_folder.$word.'.'.$video_extension;

  //Neuer Dateiname falls die Datei bereits existiert
  if(file_exists($new_path_video)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
   $id = 1;
   do {
   $new_path_video = $video_upload_folder.$word.'_'.$id.'.'.$video_extension;

   $id++;
   } while(file_exists($new_path_video));
  }



  //Alles okay, verschiebe Datei an neuen Pfad
  if (move_uploaded_file($_FILES['video']['tmp_name'], $new_path_video)) {
    // Eintragen in die Datenbank
    require('config.php');
    $pdo = new PDO("mysql:host=$databasePath;dbname=$databaseName", "$databaseUser", "$databasePassword");
    
    $userid = $_SESSION['userid'];


    $statement = $pdo->prepare("UPDATE school_$userSchoolID SET VideoFile = ? WHERE ImgID = '$imgID'");
    $result = $statement->execute(array($word));

    $statement = $pdo->prepare("UPDATE school_$userSchoolID SET VideoMime = ? WHERE ImgID = '$imgID'");
    $result = $statement->execute(array($video_extension));

    if($result) {
      $erfolgreich = "Video für $word wurde erfolgreich hinzugefügt!";
    } else {
      echo "Upload ok, Eintrag in die Datenbank fehlerhaft.";
    }

    //Video Thumbnail erstellen mit ffmpeg
    echo exec("/volume1/@appstore/ffmpeg/bin/ffmpeg -i $new_path_video -qscale:v 2 -ss 00:00:00.010 -vframes 1 -vf scale=800:-1 $video_upload_folder$word-thumb.jpg >/dev/null 2>/dev/null &");
    //konvertiere die Datei mit ffmpeg ---- ausgeschaltet wegen langsamer performance...
    //echo exec("/volume1/@appstore/ffmpeg/bin/ffmpeg -i $new_path_video $video_upload_folder$word-converted.mp4 >/dev/null 2>/dev/null &");


  } else {
    echo "Leider gab es einen Fehler beim hochladen ... ";
  }





  // die(header("location: ../profile.php"));
}
};






?>
