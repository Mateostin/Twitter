<?php
require_once ('Settings.php');
require_once ('User.php');
require_once ('connection.php');
if (!isset($_FILES['fileToUpload'])) {

} else {

    $target_dir = "../user_avatars/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $error = "Plik jest obrazkiem - " . $check["mime"] . ".";
            include('information.php');
            $uploadOk = 1;
        } else {
            $error = "Plik nie jest obrazkiem.";
            include('information.php');
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        $error = "Taki plik juz istnieje.";
        include('information.php');
        $uploadOk = 0;
    } elseif ($_FILES["fileToUpload"]["size"] > 500000) {
        $error = "Rozmiar pliku jest zbyt duży.";
        include('information.php');
        $uploadOk = 0;
    } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $error = "Error, dostępne rozszerzenia plików to JPG, JPEG, PNG & GIF.";
        include('information.php');
        $uploadOk = 0;
    } elseif ($uploadOk == 0) {
        $error = "Error, Plik nie został przesłany.";
        include('information.php');
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $path = $_FILES["fileToUpload"]["name"];
            $target_file = substr($target_file, 3);
            Settings::avatarUpdate($conn, $target_file);

            $error = "Avatar został ustawiony.";;
            include('information.php');
        } else {
            echo "Sorry, there was an error uploading your file.";
            $error = "Błąd, podczas wysyłania pliku.";
            include('information.php');
        }

    }
}
?>
