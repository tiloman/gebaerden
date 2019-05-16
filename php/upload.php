<?php
// session_start();
// if(!isset($_SESSION['userid'])) {
//   die(header("location: ../login.php"));
// ;
// }


$upload_folder = 'custom/'; //Das Upload-Verzeichnis
$word = $_POST['word'];
$filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
$uploadNotice = null;
$error = false;

if (isset($_FILES['image']['name'])) {

  $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));


  //Überprüfung der Dateiendung
  $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif', 'heic');
  if(!in_array($extension, $allowed_extensions)) {
   $uploadNotice = "Es dürfen nur Dateien vom Typ JPG, PNG oder GIF hochgeladen werden.";
   $error = true;
   // die("Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt");

  }

//Überprüfung der Dateigröße
if(!$error) {
  $max_size = 4000*8000; //500 KB
  if($_FILES['image']['size'] > $max_size) {
   // die("Bitte keine Dateien größer 500kb hochladen");
   $uploadNotice = "Bitte keine Dateien größer 500kb hochladen";
   $error = true;
  }
}

  //Überprüfung dass das Bild keine Fehler enthält
// if(!$error) {
//   if(function_exists('exif_imagetype')) { //Die exif_imagetype-Funktion erfordert die exif-Erweiterung auf dem Server
//    $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF, IMG_PNG);
//    $detected_type = exif_imagetype($_FILES['image']['tmp_name']);
//    if(!in_array($detected_type, $allowed_types)) {
//      $uploadNotice = "Nur der Upload von Bilddateien ist gestattet";
//      $error = true;
//       }
//     }
//   }

if(!$error) {
  //Pfad zum Upload
  $new_path = $upload_folder.$word.'.'.$extension;

  //Neuer Dateiname falls die Datei bereits existiert
  if(file_exists($new_path)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
   $id = 1;
   do {
   $new_path = $upload_folder.$word.'_'.$id.'.'.$extension;
   $id++;
   } while(file_exists($new_path));
  }

  //Alles okay, verschiebe Datei an neuen Pfad
  move_uploaded_file($_FILES['image']['tmp_name'], $new_path);

  // Eintragen in die Datenbank
  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $userid = $_SESSION['userid'];


  $statement = $pdo->prepare("INSERT INTO custom_img_12345 (ImgName, UploadedBy) VALUES (:ImgName, :UploadedBy)");
  $result = $statement->execute(array('ImgName' => $word, 'UploadedBy' => $userid));



  // echo "Bild hochgeladen nach: ";
  $uploadNotice = "Bild für $word erfolgreich hochgeladen";
  // die(header("location: ../custom_library.php"));;
}
};


//VIDEO Upload ----------------------------------------------------------------------------------


$video_upload_folder = 'custom/videos/'; //Das Upload-Verzeichnis für Videos
$uploadNoticeVideo = null;
$video_error = false;

if (isset($_FILES['video']['name'])) {

  $Videofilename = pathinfo($_FILES['video']['name'], PATHINFO_FILENAME);
  $video_extension = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));


  //Überprüfung der Dateiendung
  $video_allowed_extensions = array('mp4', 'm4v');
  if(!in_array($video_extension, $video_allowed_extensions)) {
   $uploadNoticeVideo = "Es dürfen nur Dateien vom Typ MP4 hochgeladen werden.";
   $video_error = true;
   // die("Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt");

  }

//Überprüfung der Dateigröße
if(!$video_error) {
  $max_size = 4000*8000; //500 KB
  if($_FILES['video']['size'] > $max_size) {
   // die("Bitte keine Dateien größer 500kb hochladen");
   $uploadNoticeVideo = "Bitte keine Dateien größer 500kb hochladen";
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


  $statement = $pdo->prepare("UPDATE custom_img_12345 SET VideoID WHERE ImgName = $word");
  $result = $statement->execute(array('VideoID' => $word));


  // echo "Bild hochgeladen nach: ";
  $uploadNoticeVideo = "Video für $word erfolgreich hochgeladen";
  // die(header("location: ../custom_library.php"));;
}
};






?>
