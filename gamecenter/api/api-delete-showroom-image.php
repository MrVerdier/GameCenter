<?php

require_once __DIR__."/connect.php";
session_start();

$sImageName = $_GET['image'];
$iUserId = $_SESSION['sUserId'];

try{

$stmt = $db->prepare('DELETE FROM images WHERE url = :imageName');
$stmt->bindValue(':imageName', $sImageName);
$stmt->execute();

if( !$stmt->execute() ){
    echo 'could not delete game';
    exit;
}
echo 'image is deleted';

}

catch( PDOEXception $ex){
    echo $ex;
}

