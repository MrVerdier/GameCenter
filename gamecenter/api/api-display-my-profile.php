<?php 
require_once(__DIR__.'/connect.php');
$iUserId = $_SESSION['sUserId'];

try {
    $stmt = $db->prepare(
       'SELECT id, name, user_image_url, description, mail, password, date FROM users WHERE id = :sUserId'
    );
    $stmt->bindValue(':sUserId', $iUserId);
    $stmt->execute();

    $aRows = $stmt->fetchAll();

    foreach($aRows as $aRow){
        echo "
        <div class='my-profile'>
            <div id='changeProfileImage'>
            <img src='imgs/profileimgs/$aRow->user_image_url' class='profile-image' onError=\"this.onerror=null;this.src='imgs/placeholder.png';\">
            <div id='changeImageOverlay' onclick='changeProfileImageModal()'><p>Click to change image</p></div>
            </div>
            <div>
    
                <h3>$aRow->name</h3>
                <p><span>Email: </span>$aRow->mail</p>
                <p><span>Date created: </span> $aRow->date</p>
                <p><span>About me: </span></p>
                <div id='profileDescription'><p>$aRow->description</p></div>  
                <div id='expandDescriptonBox' onclick='expandDescriptionBox()'> <span>Edit description</span></div>
                <form id='updateDescription'>
                    <input name='new-description' type='text' placeholder='Description'>
                    <button id='updateProfileDescription'>Update</button>
                    <button onclick='cancelOperation()'>Cancel</button>
                </form>
            </div>
        </div>
        ";
    }

}
    catch( PDOEXception $ex){
        echo $ex;
    }

