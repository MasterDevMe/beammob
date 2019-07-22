<?php
require_once("includes/config.php");
require_once("includes/classes/Artist.php");

// Get logged Artist
$artistLogged = Artist::getLoggedIn()
?>
<!DOCTYPE html>
<html>
<head>
    <title>Beammob</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/upload.css">

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/sugar.min.js"></script>
    <!-- <script src="assets/js/jquerymy.js"></script> -->
    <script src="assets/js/jquerymy-1.2.14.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/commonActions.js"></script>

</head>
<body>

    <div id="pageContainer">

        <div id="mastHeadContainer">
            <button class="navShowHide">
                <img src="assets/images/icons/menu.png">
            </button>

            <a class="logoContainer" href="uploadSong.php">
                <img src="assets/images/icons/logo_name.png" title="logo" alt="Site logo">
            </a>


            <div class="rightIcons">
                <a href="uploadArtistPic.php">
                    <img class="upload" src="assets/images/profile-pics/default.png">
                </a>
            </div>

        </div>

        <div id="sideNavContainer" style="display:none;">
            <div class="artist-songs">
                <div class="clearfix text-center"><a id="artistLogout" href="#" class="btn btn-danger text-light">LOGOUT&nbsp;<span class="oi oi-account-logout"></span></a></div>
                <?php
                $songs = $artistLogged->getSongs();
                
                if( count($songs) ) :
                    foreach( $songs as $song ) {
                        printf('<div class="song"><strong>Title:</strong> %s<br/><strong>Plays:</strong> %s</div>', $song['title'], $song['plays']);
                    }
                else: ?>
                    <a href="uploadSong.php" class="btn btn-primary">Upload your first song</a>
                    <?php
                endif; ?>
            </div>
        </div>

        <div id="mainSectionContainer">

            <div id="mainContentContainer">
