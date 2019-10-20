<?php
ini_set('display_errors', 0);
require_once __DIR__.'/connect.php';
session_start();
$iUserId = $_SESSION['sUserId'];
    
    try {
        $stmt = $db->prepare(
           'SELECT users.name, users.id, users.online_status, users.user_image_url, users_friends.user_one_fk, users_friends.user_two_fk FROM users_friends
           INNER JOIN users on users.id = user_two_fk
           WHERE user_one_fk = :userId
           AND STATUS = 1'
        );
        $stmt->bindValue(':userId', $iUserId);
        $stmt->execute();
        $aRows = $stmt->fetchAll();

        foreach($aRows as $aRow){

            echo "<div class='my-friends' onclick='viewFriendProfile($aRow->id)'>
                    <img src='imgs/profileimgs/$aRow->user_image_url' class='round-image' onError=\"this.onerror=null;this.src='imgs/placeholder.png';\">
                    <p>$aRow->name</p>
                ";
                if($aRow->online_status == 1){
                    echo "<div class='online'></div></div>";
                }else{
                    echo "<div class='offline'></div></div>";
                }
            }
        }
    catch( PDOEXception $ex){
        echo $ex;
    }
