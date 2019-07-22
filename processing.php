<?php 
require_once("includes/uploadHeader.php");
require_once("includes/classes/MusicUploadData.php");
require_once("includes/classes/MusicProcessor.php");


if(!isset($_POST["uploadButton"])) {
    echo "No file sent to page.";
    exit();
}


// 1) create file upload data
$musicUpoadData = new MusicUploadData(
                            $_FILES["fileInput"], 
                            $_POST["titleInput"],
                            $_POST["descriptionInput"],
                            $_POST["privacyInput"],
                            $_POST["categoryInput"],
                            "Juice");

// 2) Process video data (upload)
$musicProcessor = new MusicProcessor($con);
$wasSuccessful = $musicProcessor->upload($musicUpoadData);

// 3) Check if upload was successful
//if($wasSuccessful) {
    echo "Upload successful";
//}
?>