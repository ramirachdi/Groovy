
<?php
include "includes/includedFiles.php";
$artistRepo=new ArtistRepository();
$albumRepo=new AlbumRepository();
if(isset($_GET['id']))
{
    $albumId=$_GET['id'];
}
else
{
    header("Location:index.php");
}
$album=new Album($albumId);
$artist=$album->getArtist();
 ?>
<div class="square">
         <div class="col1">
            <div class="leftSection">
                <img src='assets/icons/Glogo.svg' id='Glogo'>
                <img src='<?=$album->getArtworkPath()?>' alt='Example image' class="image">


            </div>
            <div class="rightSection">

                <h2><?=$album->getTitle()?></h2>

                <h1>By </h1>
                <h0 onclick="openPage('artist.php?id=<?=$artist->getId()?>')"><?=$artist->getName();?></h0>

            </div>
            <hr class="divider">
            <div class="bottomSection">

                <p class="bottomLeft bold"><?=$album->getNumberOfSongs()?></p>
                <p class="bottomRight"><span class="bold">45</span><span>min</span></p>
            </div>
             <br>
            <div class="bottomSection1">

                <p class="bottomLeft">Songs</p>
                <p class="bottomRight">Playtime</p>
            </div>
		</div>

    <div class="col2">
        <div class="top">
            <div class="columnn1">#</div>
            <div class="columnn2 ">Title</div>
            <div class="columnn3" ">Duration</div>
        <div class="more"></div>
    </div>
    <div class='AlbumtracklistContainer'>
        <?php
        $i=1;
        $songIdArray=$album->getSongIds();
        foreach($songIdArray as $songId)
        {
            $song=new Song($songId);
            $artistSong=$song->getArtist();
            echo "
               <div class='tracklistRow'  >
                        <div class='columnn1'>" . $i . "</div>
                        <div class='columnn2' onclick='setTrack(".$song->getId().",tempPlaylist, true)'>" . $song->getTitle() . "</div>
                        <div class='columnn3'>" . $song->getDuration() . "</div>

                        <div class='more'>
                         <input type='hidden' class='songId' value='".$song->getId()."'>
                        <img  src='assets/icons/more.svg' alt='' class='moreImg' onclick='showOptionsMenu(this)'></div>
                    </div>

                 ";
            $i+=1;} ?>
        <script>
            var tempSongIds='<?php echo json_encode($songIdArray);?>';
            tempPlaylist=JSON.parse(tempSongIds);
        </script>
    </div>
    </div>
</div>
<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?=Playlist::getPlaylistDropdown($con,$username);?>
</nav>






