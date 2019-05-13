<?php

$upload_folder = 'custom/'; //Das Upload-Verzeichnis
$filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
$word = $_POST['word'];
$extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));


//Überprüfung der Dateiendung
$allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
if(!in_array($extension, $allowed_extensions)) {
 die("Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt");
 $errorMessage = "Nur der Upload von Bilddateien ist gestattet";

}

//Überprüfung der Dateigröße
$max_size = 2000*4000; //500 KB
if($_FILES['file']['size'] > $max_size) {
 die("Bitte keine Dateien größer 500kb hochladen");
 $errorMessage = "Bitte keine Dateien größer 500kb hochladen";

}

//Überprüfung dass das Bild keine Fehler enthält
if(function_exists('exif_imagetype')) { //Die exif_imagetype-Funktion erfordert die exif-Erweiterung auf dem Server
 $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
 $detected_type = exif_imagetype($_FILES['file']['tmp_name']);
 if(!in_array($detected_type, $allowed_types)) {
 $errorMessage = "Nur der Upload von Bilddateien ist gestattet";
 die("Nur der Upload von Bilddateien ist gestattet");


 }
}

//Pfad zum Upload
$new_path = $upload_folder.$word.'.'.$extension;

//Neuer Dateiname falls die Datei bereits existiert
if(file_exists($new_path)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
 $id = 1;
 do {
 $new_path = $upload_folder.$filename.'_'.$id.'.'.$extension;
 $id++;
 } while(file_exists($new_path));
}

//Alles okay, verschiebe Datei an neuen Pfad
move_uploaded_file($_FILES['file']['tmp_name'], $new_path);
echo "Bild hochgeladen nach: $new_name";
// $errorMessage = "Erfolgreich";

// die(header("location: custom_library.php"));;

?>
