<?php
ini_set('display_errors', 0);
require_once __DIR__.'/connect.php';
session_start();
$iUserId = $_SESSION['sUserId'];
    
    try {
        $stmt = $db->prepare(
           'SELECT users.id, users_games.user_fk, users_games.game_fk, games.title, games.image_url FROM users
            INNER JOIN users_games ON users.id = users_games.user_fk
            INNER JOIN games ON users_games.game_fk = games.id
            WHERE users.id = :sUserId '
        );
        $stmt->bindValue(':sUserId', $iUserId);
        $stmt->execute();

        $aRows = $stmt->fetchAll();
    
        if( count($aRows) == 0 ){
            echo '<h3>No games where found</h3>';
        }
        
        foreach($aRows as $aRow){
            echo "<div class='my-games'>
                    <h3>$aRow->title</h3>
                    <img src='$aRow->image_url' class='image-contain'>
                    <div class='delete-button' onclick='deleteFromLibraryConfirm(this)'><i class='fas fa-trash'></i></div>
                  </div>";
        }
    }

    catch( PDOEXception $ex){
        echo $ex;
    }



