<?php

require_once __DIR__.'/connect.php';

$sName = $_GET['login-name'];
if( empty($sName) ){ sendResponse(-2, __LINE__,"Name cannot be empty");  }
if( strlen($sName) < 4 ){ sendResponse(-2, __LINE__,"Name has to be at least 4 characters"); }
if( strlen($sName) > 50 ){ sendResponse(-2, __LINE__,"Name can not be longer than 50 characters"); }


$sUserPassword = $_GET['login-password'];
if( empty($sUserPassword) ){ sendResponse(-1, __LINE__,"Please enter your password");  }
if( strlen($sUserPassword) < 4 ){ sendResponse(-1, __LINE__,"Password has to be at least 4 characters"); }
if( strlen($sUserPassword) > 50 ){ sendResponse(-1, __LINE__,"Password can not be longer than 50 characters"); }


try{
$db->beginTransaction();

$stmt = $db->prepare('SELECT * FROM `users` WHERE name = :name OR password = :password LIMIT 1');
$stmt->bindValue(':name', $sName);
$stmt->bindValue(':password', $sUserPassword);
$stmt->execute();

$aRows = $stmt->fetchAll(); 

foreach( $aRows as $aRow ){
  $sDbPassword = $aRow->password;
  $sDbName = $aRow->name;
};

if( count($aRows) == 0 ){
  sendResponse(0, __LINE__, "Password or name is incorrect");
  $db->rollBack();
  exit;
}
if( $sName != $sDbName ){
  sendResponse(-2, __LINE__, "Name incorrect");
  $db->rollBack();
  exit;
}
if( !password_verify($sUserPassword, $sDbPassword) ){
  sendResponse(-1, __LINE__, "Password incorrect");
  $db->rollBack();
  exit;
}

$stmt = $db->prepare('UPDATE users SET online_status = 1 WHERE name = :name');
$stmt->bindValue(':name', $sName);
$stmt->execute();
if( !$stmt->execute() ){
  sendResponse(-1, __LINE__,"could not set user to online");
    $db->rollBack();
    exit;
}
$db->commit(); // ******************************************* 
}catch( PDOEXception $ex ){
  echo $ex;
  $db->rollBack();
}

session_start();
$_SESSION['sUserName'] = $sName;
$_SESSION['sUserId'] = $aRow->id;
$_SESSION['sUserImage'] = $aRow->user_image_url;

sendResponse(1, __LINE__, "login done");

// *********************************************************************

function sendResponse($iStatus, $iLineNumber, $sMessage){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
    exit;
  }