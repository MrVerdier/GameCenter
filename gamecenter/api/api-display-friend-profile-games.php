<?php
require_once(__DIR__.'/connect.php');
$sProfileId = $_GET['profileId'];


try{
    $stmt = $db->prepare(
       'SELECT users.user_image_url, users.name, users_games.user_fk, games.title, games.image_url FROM users
        INNER JOIN users_games ON users.id = users_games.user_fk
        INNER JOIN games ON users_games.game_fk = games.id
        WHERE users.id = :profileId'
        );
    $stmt->bindValue(':profileId', $sProfileId);
    $stmt->execute();

    $aRows = $stmt->fetchAll();

    foreach($aRows as $aRow){
        echo "<div class='my-games'>
                <h3>$aRow->title</h3>
                <img src='$aRow->image_url' class='image-contain'>
            </div>";
    };

}catch( PDOEXception $ex ){
    echo $ex;
}
