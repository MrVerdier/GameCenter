<?php 

session_start();
require_once(__DIR__.'/connect.php');
    
    $iUserId = $_SESSION['sUserId'];
    $iFriendUserId = $_POST['friendUserId'];
    $iSetStatus = $_POST['setStatus'];

try{

    $stmt = $db->prepare(
     'UPDATE users_friends 
      SET status = :newStatus, action_user_id = :userId 
      WHERE user_one_fk = :friendUserId 
      AND user_two_fk = :userId'
      );

     $stmt->bindValue(':userId', $iUserId);
     $stmt->bindValue(':friendUserId', $iFriendUserId);
     $stmt->bindValue(':newStatus', $iSetStatus);
     $stmt->execute();

    $stmt = $db->prepare(
      'INSERT INTO users_friends VALUES (null, :userId, :friendUserId, :newStatus, :userId)');
    $stmt->bindValue(':userId', $iUserId);
    $stmt->bindValue(':friendUserId', $iFriendUserId);
    $stmt->bindValue(':newStatus', $iSetStatus);
    $stmt->execute();

    }
    catch( PDOException $ex){
      echo $ex;
      }


sendResponse(1, __LINE__, "status set to $iSetStatus");

      // *********************************************************************
      
function sendResponse($iStatus, $iLineNumber, $sMessage){
          echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
          exit;
        }
      

// };
