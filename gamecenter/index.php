<?php
$sTitle = 'GameCenter';
require_once(__DIR__.'/top.php');

?>
<!------------------ PROFILE ------------------->
<div id="loader"></div>

<div id="profile" class="page">
    <div class="content-container">
        <?php include(__DIR__.'/api/api-display-my-profile.php'); ?>
        <div class="lower-background-profile">
            <div id="myFriendRequest" class="grid-1-1 friend-request-active">
                <?php include(__DIR__.'/api/api-friend-request.php'); ?>
            </div>
            <h1>My Games</h1>
            <div id="myGamesProfile" class="grid-4-3">
                <?php include(__DIR__.'/api/api-display-my-games.php'); ?>
            </div>
        </div>  
    </div>
</div>

<!------------------ FRIENDS ------------------->
<div id="friends" class="page">
<form class="frm-search">
        <input id="findFriends" class="txt-search" name="name" type="text" autocomplete="off" placeholder="Search for new friends">
</form>
    <div class="content-container">

        <div id="friendsSearchResults" class="search-results grid-4-3"></div> 

        <div id="myFriends">   
                <?php include(__DIR__.'/api/api-display-my-friends.php'); ?>
        </div>


        <div id="friendProfile">
        <h2><i class="fas fa-arrow-left"></i> Select a friend and discover what they are playing</h2>
        </div>

            <div class="lower-background-friends">
                <div id="friendProfileGames" class="grid-3-4"></div>
        </div>
    </div>
</div>

<!------------------ GAMES ------------------->

<div id="games" class="page">
    <form class="frm-search">
        <input id="findGames" class="txt-search" name="name" type="text" autocomplete="off" placeholder="Search for games to add">
    </form>
    <div class="content-container">
            <h2 id="gameSearchHeadline"><i class="fas fa-arrow-left"></i> Search for new games to add to your library</h2>
    <div id="gamesSearchResults" class="search-results grid-4-3"></div>

    <div class="lower-background-games">
        <h1>My Games</h1>
            <div id="myGames" class="grid-4-3">
                 <?php include(__DIR__.'/api/api-display-my-games.php'); ?>
            </div>
        </div>
    </div>
</div>

<!------------------ SHOWROOM ------------------->

<div id="showroom" class="page">

<div class="iframe-container">
    <iframe id="showroomIframe" src="showroom.php" frameborder="0"></iframe>

  </div>
</div>

<!------------------ BOTTOM ------------------->
<?php
$sLinkToScript = '<script src="js/one-page.js"></script>';
require_once(__DIR__.'/bottom.php');
?>

