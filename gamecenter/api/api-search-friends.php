<?php
require_once __DIR__.'/connect.php';
session_start();
$iUserId = $_SESSION['sUserId'];
    
if (isset($_GET['txtSearch'])) {
    $sName = $_GET['txtSearch'];
    
    try {

        $stmt = $db->prepare('SELECT * FROM users WHERE name LIKE :sName LIMIT 8');
        $stmt->bindValue(':sName', "%$sName%");
        $stmt->execute();

        $aRows = $stmt->fetchAll();
    
        if( count($aRows) == 0 ){
            echo '<h2>Sorry, no users with that name</h2>';
        }

        foreach($aRows as $aRow){

            $profileId = $aRow->id;

            echo "<div class='search-friends'>
            <h3>$aRow->name</h3>
            <img src='imgs/profileimgs/$aRow->user_image_url' class='image-cover image-friends-search' onError=\"this.onerror=null;this.src='imgs/placeholder.png';\">
            <div class='tile-overlay' onclick='sendFriendRequestConfirm(this, $profileId)'><i class='fas fa-user-plus'></i>Send friend<br>request</div>
            </div>\n"; //FETCH_OBJ
        }


    }
    catch( PDOEXception $ex){
        echo $ex;
    }
}



