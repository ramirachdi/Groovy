<?php

include_once "includes/autoload.php";
include_once("includes/includedFiles.php");
$artistRepo=new ArtistRepository();

if(isset($_GET['id']))
{
    $artistId=$_GET['id'];
}
else
{
    header("Location:index.php");
}

$artist=new Artist($artistId);
 ?>

<style>

</style>

<div class="square">
         <div class="col1">
            <div class="leftSection">
                 <img src='assets/icons/Glogo.svg' id='Glogo'>
                <img src='<?=$artist->getArtworkPath()?>' alt='Example image' class="image">

            </div>
            <div class="rightSection">

                <h2><?=$artist->getName()?></h2>

                <h1>Artist</h1>

            </div>

		</div>

		<div class="col2">
            <div class="mostPopular">
                Most popular :
                <hr>
            </div>

            <div class='AlbumtracklistContainer Space1'>
                <?php
                $i=1;
                $songIdArray=$artist->getSongIds();
                while($i<6){
                    $songId=$songIdArray[$i-1];
                    $song=new Song($songId);
                    $artistSong=$song->getArtist();
                echo "
               <div class='tracklistRow '  >
                        <div class='columnn1' >" . $i . "</div>
                        <div class='columnn2' onclick='setTrack(".$song->getId().",tempPlaylist, true)'>" . $song->getTitle() . "</div>
                        <div class='columnn3'>" . $song->getDuration() . "</div>
                        <div class='more'>
                        <input type='hidden' class='songId' value='".$song->getId()."'>
                        <img  src='assets/icons/more.svg' class='moreImg' alt='' onclick='showOptionsMenu(this)'>
                        </div>
                </div>

                 ";
                $i+=1;} ?>
        </div>
            <script>
                var tempSongIds='<?php echo json_encode($songIdArray);?>';
                tempPlaylist=JSON.parse(tempSongIds);
            </script>

        <div class="AlbumList">
            <div class="Albums">
                Albums :
                <hr>
            </div>
                <?php

                $query = "SELECT * FROM albums where artist=$artistId";
                $response = $con->query($query);
                $albums = $response->fetchAll(PDO::FETCH_OBJ);
                foreach ($albums as $album) {
                    echo "<div class='gridViewItem1 Space2'>
                            <a onclick=\"openPage('album.php?id=".$album->id."')\">
                            <div class='imageContent'>
                            <img src='assets/icons/Glogo.svg' id='Glogo'>
                            <img src='". $album->artworkPath."' id='AlbumImg'></div>
                            <div class='gridViewInfo1' >
                            <div class='albumName'>".$album->title." </div>
                            <div class='artistName'>".$artistRepo->findById($album->artist)->name."</div>
                            <div class='playButton'><img src='assets/icons/playbutton.png'></div>
                            </div>
                            </a>
                        </div >";
                }
                ?>

        </div>


		</div>
    </div>
<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?=Playlist::getPlaylistDropdown($con,$username);?>
</nav>



