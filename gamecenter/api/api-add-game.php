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

    $stmt = $db->prepare('INSERT INTO users_games (user_fk, game_fk) VALUES(:userId, :gameId) ON DUPLICATE KEY UPDATE user_fk = user_fk');
    $stmt->bindValue(':gameId', $gameId);
    $stmt->bindValue(':userId', $iUserId);
    if( !$stmt->execute() ){
        sendResponse(-1, __LINE__,"could not complete");
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

sendResponse(1, __LINE__,"game saved");

function sendResponse($iStatus, $iLineNumber, $sMessage){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
    exit;
  }

// };