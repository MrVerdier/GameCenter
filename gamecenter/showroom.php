<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Showroom</title>
    <link rel="stylesheet" href="public/stylesheets/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <style>
        html, body {
            height: 99%;
            overflow:hidden;
        }
        body > div {
            height: 100%;
            width: 100%;
            overflow: hidden;
            position: relative;
        }
    </style>
</head>
<body class="iframe-body">
    
<div>
    <div class="iframe-inner-container">
    <h1>Upload your images from your awesome moments!</h1>
    <button onclick="uploadImageToShowroom()">Click to upload</button>

        <div class="grid-3-4">
                <?php include(__DIR__.'/api/api-showroom.php'); ?>
        </div>
    </div>
</div>
<?php
$sLinkToScript = '<script src="js/one-page.js"></script>';
require_once(__DIR__.'/bottom.php');
?>