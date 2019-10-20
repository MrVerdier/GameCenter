<?php

require_once(__DIR__.'/connect.php');
session_start();
$sNewDescription = $_POST['new-description'];
$iUserId = $_SESSION['sUserId'];

try {
    $stmt = $db->prepare('UPDATE users SET description = :sNewDescription WHERE id = :sUserId');
    $stmt->bindValue(':sUserId', $iUserId);
    $stmt->bindValue(':sNewDescription', $sNewDescription);
    $stmt->execute();

    echo "<p>".$sNewDescription."</p>";
}
catch( PDOEXception $ex){
    echo $ex;
}
