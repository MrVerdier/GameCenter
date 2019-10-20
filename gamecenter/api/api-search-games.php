<?php
require_once __DIR__.'/connect.php';
    
if (isset($_GET['txtSearch'])) {
    $sTitle = $_GET['txtSearch'];
    
    try {
        $stmt = $db->prepare(
            'SELECT * FROM games 
             WHERE title LIKE :sTitle 
             AND type = "game" 
             ORDER BY title ASC 
             LIMIT 12'
             );
        $stmt->bindValue(':sTitle', "%$sTitle%");
        $stmt->execute();

        $aRows = $stmt->fetchAll();
    
        if( count($aRows) == 0 ){
            echo '<h2>Sorry, No games where found</h2>';
            exit;
        }
        
        foreach($aRows as $aRow){
            echo "<div id='searchResultsInner' class='search-games'>
            <h3>$aRow->title</h3>
            <img src='$aRow->image_url' class='image-contain'>
            <div class='tile-overlay' onclick='addToLibraryConfirm(this)'><i class='fas fa-plus'></i>Add to library</div>
            </div>\n"; //FETCH_OBJ
        }
    }

    catch( PDOEXception $ex){
        echo $ex;
    }
}



