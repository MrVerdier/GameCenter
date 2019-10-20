<?php

$sName = $_POST['signup-name'];
if( empty($sName) ){ sendResponse(0, __LINE__,"Name cannot be empty");}
if( strlen($sName) < 4 ){ sendResponse(0, __LINE__,"Name must be at lest 4 characters");}
if( strlen($sName) > 10 ){ sendResponse(0, __LINE__,"Name can only be max 10 characters");}

$sMail = $_POST['signup-mail'];
if( empty($sMail) ){ sendResponse(-1, __LINE__,"Email cannot be empty");}
if( !filter_var( $sMail, FILTER_VALIDATE_EMAIL ) ){ sendResponse(0, __LINE__,"Must be an email");}

$sUserPassword = $_POST['signup-password'];
if( empty($sUserPassword) ){ sendResponse(-2, __LINE__,"Password cannot be empty");  }
if( strlen($sUserPassword) < 4 ){ sendResponse(-2, __LINE__,"Password must be at lest 4 characters");}
if( strlen($sUserPassword) > 50 ){ sendResponse(-2, __LINE__,"Password can only be max 50 characters");}

$sHashedPassword = password_hash( $sUserPassword, PASSWORD_DEFAULT );

require_once __DIR__.'/connect.php';
        
try{
  $db->beginTransaction();

  $stmt = $db->prepare('SELECT * FROM users WHERE mail = :mail');
  $stmt->bindValue(':mail', $sMail);
  $stmt->execute();
  $aRows = $stmt->fetchAll(); 
    if(count($aRows) == 1 ){
      sendResponse(-1, __LINE__,"Email already in use");
      $db->rollBack();
      exit;
  }
    
  $stmt = $db->prepare('SELECT * FROM users WHERE name = :name');
  $stmt->bindValue(':name', $sName);
  $stmt->execute();
  $aRows = $stmt->fetchAll(); 
    if(count($aRows) == 1 ){
      sendResponse(0, __LINE__,"Name already in use");
      $db->rollBack();
      exit;
  }
  
  $stmt = $db->prepare('INSERT INTO users (name, mail, password) VALUES(:name, :mail, :password)');
  $stmt->bindValue(':name', $sName);
  $stmt->bindValue(':mail', $sMail);
  $stmt->bindValue(':password', $sHashedPassword);
  if( !$stmt->execute() ){
    sendResponse(-1, __LINE__,"User not created due to unexpected input");
      $db->rollBack();
      exit;
  }

  $db->commit(); // ******************************************* 
}

catch( PDOException $ex){
  sendResponse(-1, __LINE__, $ex);
  $db->rollBack();
}

sendResponse(1, __LINE__, "Signup succesfull");

// *********************************************************************

function sendResponse($iStatus, $iLineNumber, $sMessage){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
    exit;
  }