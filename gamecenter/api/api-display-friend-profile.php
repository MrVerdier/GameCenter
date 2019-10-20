<?php
require_once(__DIR__.'/connect.php');
$sProfileId = $_GET['profileId'];


try{
    $stmtUser = $db->prepare('SELECT * FROM `users` WHERE id = :profileId');
    $stmtGamesAmount = $db->prepare('SELECT users.id, COUNT(users_games.user_fk) AS numberOfGames FROM users_games
                                     INNER JOIN users ON users.id = users_games.user_fk
                                     WHERE users.id = :profileId');
    $stmtUser->bindValue(':profileId', $sProfileId);
    $stmtGamesAmount->bindValue(':profileId', $sProfileId);
    


    $stmtUser->execute();
    $aRows = $stmtUser->fetchAll();
    
    foreach($aRows as $aRow){
        echo "
        <div class='my-friends-profile'>
        <img src='imgs/profileimgs/$aRow->user_image_url' class='profile-image' onError=\"this.onerror=null;this.src='imgs/placeholder.png';\">
        <div>
        <h3>$aRow->name</h3>
        <p><span>Date created: </span> $aRow->date</p>
        <p><span>About $aRow->name: </span></p>
        <div id='profileDescription'><p>$aRow->description</p></div>  
        ";

            $stmtGamesAmount->execute();
            $aAmounts = $stmtGamesAmount->fetchAll();

            foreach( $aAmounts as $aAmount){
                echo "<div><p><span>Games Owned:</span><br> $aAmount->numberOfGames</p></div>";
            };

            $now = time(); // or your date as well
            $your_date = strtotime("$aRow->date");
            $datediff = $now - $your_date;

            echo "<div><p><span>Profile Age:</span><br>".round($datediff / (60 * 60 * 24))." Days</p></div></div>"  ;

        echo "<div class='friends-details'>
        <div style='color:#fff' onclick='showAllFriendGames($aRow->id); toggleActive(this);'><i class='fas fa-gamepad'></i>Show all Games</div>
        <div style='color:#fff' onclick='showAllFriendGamesInCommon($aRow->id); toggleActive(this);'><i class='fas fa-hands-helping'></i>Games in common</div>
        <div style='color:#fff' onclick='showImages($aRow->id); toggleActive(this);'><i class='fas fa-images'></i>Showroom</div>
        </div>
        </div>
        ";

    };
    

 
}catch( PDOEXception $ex ){
    echo $ex;
}



