<?php 
ini_set('display_errors', 0);
require_once __DIR__.'/connect.php';
    
// if (isset($_GET['game'])) {
    session_start();
    $iUserTwoId = $_GET['requestUser'];
    $iUserId = $_SESSION['sUserId'];

try{
    $db->beginTransaction();

    $stmt = $db->prepare('SELECT * FROM users_friends WHERE user_one_fk = :userId AND user_two_fk = :profileId');
    $stmt->bindValue(':userId', $iUserId);
    $stmt->bindValue(':profileId', $iUserTwoId);
    $stmt->execute();

    $aRowsOne = $stmt->fetchAll();
    
    if( count($aRowsOne) == 1 ){
        sendResponse(0, __LINE__,"You are already friends");
        $db->rollBack();
    }

    $stmt = $db->prepare(
        'INSERT INTO users_friends (user_one_fk, user_two_fk, status, action_user_id) 
         VALUES (:userOneId, :userTwoId, 0, :userOneId)');
     $stmt->bindValue(':userOneId', $iUserId);
     $stmt->bindValue(':userTwoId', $iUserTwoId);
     $stmt->execute();
     

     $db->commit();
    }
    catch( PDOException $ex){
        echo $ex;
        $db->rollBack();
      }

sendResponse(1, __LINE__,"Friend request done");

function sendResponse($iStatus, $iLineNumber, $sMessage){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
    exit;
  }

// };