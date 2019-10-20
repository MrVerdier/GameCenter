<?php 

require_once __DIR__.'/connect.php';
    
// if (isset($_GET['game'])) {
    session_start();
    $sTitle = $_GET['game'];
    $iUserId = $_SESSION['sUserId'];

try{
    $db->beginTransaction();
    
    $stmt = $db->prepare('CALL showGamesOnTitle(:gameTitle)');
    $stmt->bindValue(':gameTitle', $sTitle);
    $stmt->execute();
    $aRows = $stmt->fetchAll();

    foreach($aRows as $aRow ){
        $gameId = $aRow->id;
    };
    
    if(count($aRows) == 0 ){
        sendResponse(-1, __LINE__,"Game does not exist");
        $db->rollBack();
        exit;
    }

    $stmt = $db->prepare(
        'DELETE FROM users_games 
         WHERE user_fk = :userId 
         AND game_fk = :gameId '
         );

    $stmt->bindValue(':gameId', $gameId);
    $stmt->bindValue(':userId', $iUserId);
    if( !$stmt->execute() ){
        sendResponse(-1, __LINE__,"Could not delete game");
        $db->rollBack();
        exit;
    }
    
    $db->commit(); // ******************************************* 
    }
    catch( PDOException $ex){
        echo $ex;
        $db->rollBack();
        exit;
      }

sendResponse(1, __LINE__,"game deleted");

function sendResponse($iStatus, $iLineNumber, $sMessage){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
    exit;
  }

// };