<?php
// session_start();
// if(!isset($_SESSION['userid'])) {
//   die(header("location: ../login.php"));
// ;
// }






$upload_folder = 'custom/'; //Das Upload-Verzeichnis

if (isset($_POST['word'])) {
  $word = $_POST['word'];
};

$uploadNotice = null;
$error = false;

if (isset($_FILES['image']['name'])) {
$filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
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
  $max_size = 3*1000*1000; //3 MB
  if($_FILES['image']['size'] > $max_size) {
   // die("Bitte keine Dateien größer 3MB hochladen");
   $uploadNotice = "Bitte keine Dateien größer 3MB hochladen";
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
   $sql = "SELECT * FROM custom_img_12345 WHERE ImgName = '$word'";
   foreach ($pdo->query($sql) as $row) {
      $word = $row['ImgName'].'_'.$id;
   }


   $id++;
   } while(file_exists($new_path));
  }

  //Alles okay, verschiebe Datei an neuen Pfad
  move_uploaded_file($_FILES['image']['tmp_name'], $new_path);

  // Eintragen in die Datenbank
  $pdo = new PDO('mysql:host=tiloman.mooo.com;dbname=gebaerden', 'gebaerden', 'zeigsmirmitgebaerden');
  $userid = $_SESSION['userid'];


  $statement = $pdo->prepare("INSERT INTO custom_img_12345 (ImgName, UploadedBy, ImgMime) VALUES (:ImgName, :UploadedBy, :ImgMime)");
  $result = $statement->execute(array('ImgName' => $word, 'UploadedBy' => $userid, 'ImgMime' => $extension));



  // echo "Bild hochgeladen nach: ";
  $erfolgreich = true;

  $uploadNotice = null;
  $previewImg = "<img class='uploadPreview' src='php/img.php?img=".$word."&path=".$upload_folder."&mime=".$extension."'>";
  $addVideoBtn = "<button id='addVideoBtn' class='custom_input'>Video hinzufügen</button>";
  // die(header("location: ../custom_library.php"));;
}
};



?>
