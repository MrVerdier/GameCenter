<?php 
ini_set('display_errors', 0);
session_start();
require_once __DIR__.'/connect.php';
    
// if (isset($_GET['game'])) {
    $iUserId = $_SESSION['sUserId'];

try{

    $stmt = $db->prepare(
      'SELECT users.name, users.user_image_url, users.id, users_friends.user_one_fk, users_friends.user_two_fk FROM users
      INNER JOIN users_friends ON users.id = users_friends.user_one_fk
      WHERE users_friends.user_two_fk = :userOneId
      AND users_friends.status = 0');

     $stmt->bindValue(':userOneId', $iUserId);
     $stmt->execute();

     $aRows = $stmt->fetchAll();
     
     if(count($aRows) == 0){

      echo "<h2 id='requestHeadline'>No friend request at this time, check back later!</h2>";
    }else
      echo "<h2 id='requestHeadline'>Someone wants to be your friend!</h2>";
      echo "<h2 id='requestHeadlineAlt'>No friend request at this time, check back later!</h2>";
     foreach($aRows as $aRow){
        echo "
        <div id='requestId$aRow->id' class='friend-request'>
        <img src='imgs/profileimgs/$aRow->user_image_url' onError=\"this.onerror=null;this.src='imgs/placeholder.png';\">
        <h3>$aRow->name</h3>
        <div class='react-button add' onclick='reactToFriendRequest($aRow->id, 1)'>Accept</div>
        <div class='react-button delete' onclick='reactToFriendRequest($aRow->id, 2)'>Decline</div>
        <div class='react-button block' onclick='reactToFriendRequest($aRow->id, 3)'>Block</div>
        </div>"; //FETCH_OBJ
    }
 

    }
    catch( PDOException $ex){
        echo $ex;
      }


// };
