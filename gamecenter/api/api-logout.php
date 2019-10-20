<?php
require_once(__DIR__.'/connect.php');
session_start();
$iUserId = $_SESSION['sUserId'];

$stmt = $db->prepare('UPDATE users SET online_status = 0 WHERE id = :id');
$stmt->bindValue(':id', $iUserId);
$stmt->execute();
if( !$stmt->execute() ){
  sendResponse(-1, __LINE__,"could not set user to offline");
    exit;
}

session_destroy();
header('location: ../login.php');