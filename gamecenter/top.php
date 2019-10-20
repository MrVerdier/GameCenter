<?php 
session_start();
if( !isset($_SESSION['sUserId'] ) ){
    header('Location: login.php');
}
$sUserId = $_SESSION['sUserId'];
$sUserName = $_SESSION['sUserName'];
$sUserImage = $_SESSION['sUserImage'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $sTitle ?></title>
    <link rel="stylesheet" href="public/stylesheets/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<body>

<!------------------ RESPONSIVE MESSAGE ------------------>

<div id="responsiveMessage"><h1>This application is not yet supported on tablets,
phones and smaller screens. Sorry for the inconvenience!</h1></div>
<!------------------ NAVIGATION ------------------>
<i class="fas fa-angle-double-left small-nav-button" onclick="hideMenu()"></i>
<nav>
<!-- <div id="logo">
    <img src="imgs/templogo.png" alt="">     
</div> -->
<div class="nav-link nav-item includes-searchbar" data-showpage="friends">friends <div><i class="fas fa-user-friends"></i></div></div>
<div class="nav-link nav-item includes-searchbar" data-showpage="games">games <div><i class="fas fa-gamepad"></i></div></div>
<div class="nav-link nav-item showroom" data-showpage="showroom">showroom<div><i class="fas fa-images"></i></div></div>
<div class="nav-link nav-item" onclick="logOutUser()">log out<div><i class="fas fa-sign-out-alt"></i></div></div>

<div id="profileContainer">
    <div id="notificationIcon"><i class="fas fa-exclamation"></i></div>
    <div id="profile-nav" class="nav-link" data-showpage="profile">
    <img src="imgs/profileimgs/<?=$sUserImage?>" onError="this.onerror=null;this.src='imgs/placeholder.png';" />
    <div><?=$sUserName?></div>

    </div>
</div>
<label class="switch">
<i class="fas fa-sun"></i><i class="fas fa-moon"></i>
    <input onclick="switchMode()" type="checkbox" checked >
    <span class="slider round"></span>
    </label>
</nav>

