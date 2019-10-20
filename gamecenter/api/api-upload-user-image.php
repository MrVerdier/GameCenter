<?php
ini_set("display_errors", 0);
session_start();
$iUserId = $_SESSION['sUserId'];
$target_dir = __DIR__."/../imgs/profileimgs/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$imageID = uniqid();

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>
    <a href='../index.php' class='upload-more' style='color: #C80000;'>Click here to try again</a>";
// if everything is ok, try to upload file
} else {
 
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$imageID.'.'.$imageFileType)) {  

        $dbName = $imageID.'.'.$imageFileType;

        require_once __DIR__.'/connect.php';
        
        $stmt = $db->prepare("UPDATE users SET user_image_url = :imgName WHERE id = :userId");
        $stmt->bindValue(':imgName', $dbName);
        $stmt->bindValue(':userId', $iUserId);
        $stmt->execute();  
        
        header("Location: ../index.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}





