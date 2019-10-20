<?php
require_once(__DIR__.'/connect.php');
$sProfileId = $_GET['profileId'];
session_start();
$iUserId = $_SESSION['sUserId'];


try{
    $db->beginTransaction();

    $stmt = $db->prepare(
       'CREATE OR REPLACE VIEW games_common AS 
        SELECT  t1.user_fk AS user1_fk, t1.game_fk AS user1game, t2.user_fk AS user2_fk, t2.game_fk AS game_fk
        FROM users_games t1, users_games t2
        WHERE t1.user_fk = :userId and t2.user_fk = :profileId
        AND t1.game_fk = t2.game_fk
        ');
    $stmt->bindValue(':profileId', $sProfileId);
    $stmt->bindValue(':userId', $iUserId);
    $stmt->execute();
    if(!$stmt->execute() ){
        echo 'No games in common';
        $db->rollBack();
        exit;
    }

    $stmt = $db->prepare(
        'SELECT games_common.game_fk, games.title, games.image_url FROM games_common
         INNER JOIN games ON games_common.game_fk = games.id
         WHERE games_common.user2_fk = :profileId
         ');
     $stmt->bindValue(':profileId', $sProfileId);
     $stmt->execute();
     $aRows = $stmt->fetchAll();

     if($aRows == 0){
        echo 'No games in common';
        $db->rollBack();
        exit;
    }

    foreach($aRows as $aRow){
        echo "<div class='my-games'>
        <img src='$aRow->image_url' class='image-contain'>
            <h3>$aRow->title</h3>
                  </div>";
    };

    $db->commit(); // ******************************************* 

}catch( PDOEXception $ex ){
    echo $ex;
}

// THIS SHOULD WORK BETTER BUT WILL NOT CREATE A VIEW ?!
// CREATE OR REPLACE VIEW games_common AS SELECT * FROM users_games WHERE user_fk = '501' OR user_fk = '502' GROUP BY game_fk HAVING COUNT(game_fk) > 1