<?php
include "includes/includedFiles.php";
include_once ("includes/config.php");
$artistRepo=new ArtistRepository();
?>
<div class="browsingPageContainer">
    <div class="subscriptionContainer">
        <div class="subscriptionContent">
            <span class="subscriptionText">Subscribe to Groovy Premium for a tailored music playing</span>
            <span class="subscriptionLink"><a href="">click here.</a> </span>
        </div>
    </div>
    <div class="BrowseContainer ">
        <div class="BrowseAlbum ">Browse</div>
        <div class='LikedAlbums '>Albums you might like</div>
        <div class="viewMoreAlbums ">View more</div>
    </div>
    </br>
    <div class="gridViewContainer ">
        <?php

        $query = "SELECT * FROM albums ORDER BY RAND() LIMIT 10";
        $response = $con->query($query);
        $albums = $response->fetchAll(PDO::FETCH_OBJ);
        foreach ($albums as $album) {
            echo "<div class='gridViewItem' onclick='openPage(\"album.php?id=".$album->id."\")'>
                <div class='imageContent'>
                <img src='assets/icons/Glogo.svg' id='Glogo'>
                <img src='" . $album->artworkPath ."' id='AlbumImg'></div>
                <div class='gridViewInfo' >
                <div class='albumName'>".$album->title." </div>
                <div class='artistName'>".$artistRepo->findById($album->artist)->name."</div>
                <div class='playButton'><img src='assets/icons/playbutton.png'></div>
                </div>
              </div >";
        }
        ?>
    </div>
</div>
<div id="featuresContainer">
    <div class="lyricsFeature"> Lyrics
    </div>
    <div class="comingSoon">Coming Soon...</div>
    <div class="friendsActivity">Friends Activity</div>
    <div class="friendsList">
        <div class="lock"><img src="assets/icons/Lock.png"> </div>
        <div class="friendsListInfo">Available on Groovy Premium</div>
        <div class="friendsListInfoSub">Subscribe to Groovy Premium Plan to unlock this feature</div>
    </div>
</div>