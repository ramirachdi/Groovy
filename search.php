<?php
include_once("includes/includedFiles.php");
$con = ConnexionBD::getInstance();
$artistRepo = new ArtistRepository();
if (isset($_GET['term'])) {
    $term = urldecode($_GET['term']);
} else {
    $term = "";
}
?>
<div class="searchContainer">
    <div class="inputWrapper">
        <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Search here..." onfocus="this.value = this.value;
  this.setSelectionRange(this.value.length, this.value.length);">
        <div class="searchIcon">
            <img class="searchStatus" src="assets/icons/search-status.svg" alt="">
        </div>
    </div>

    <?php
    if ($term == "") {
        echo "
           <div class='tracklistContainerVide'>
                <div class='defaultSearch'>
                        <img src='assets/icons/GroupdefaultSearch.svg' >
                        <p class='searchPageLogo'> Search your favorite music, artist and albums.</p>
                </div>
           </div>
        ";
    } else {
        $songQuery = $con->prepare("SELECT id FROM songs WHERE title LIKE ('$term%')");
        $songQuery->execute();
        $songIdArray = $songQuery->fetchAll(PDO::FETCH_COLUMN);
        echo " <h2>Songs</h2><br>";
        echo "<div class='tracklistContainer'>
                   <div class='tracklist'>
                    ";
        if (empty($songIdArray)) {
            echo "<div class='noResults'>No songs found matching " . $term . " ..</div>";
        } else {
            $i = 1;
            foreach ($songIdArray as $songId) {
                if ($i > 15) {
                    break;
                }
                $song = new Song($songId);
                $songArtist = $song->getArtist();

                echo "
                    <div class='tracklistRow'  >
                        <div class='columnn1'>" . $i . "</div>
                        <div class='columnn2' onclick='setTrack(".$song->getId().",tempPlaylist, true)'>" . $song->getTitle() . "</div>
                        <div class='columnn3'>" . $song->getArtist()->getName() . "</div>
                        <div class='columnn4'>" . $song->getDuration() . "</div>
                        <div class='more'>
                        <input type='hidden' class='songId' value='".$song->getId()."'>
                        <img  src='assets/icons/more.svg' class='moreImg' alt='' onclick='showOptionsMenu(this)'>
                        </div>
                    </div>
                    ";
                $i += 1;
            }
        }
        echo " </div> </div>";
        echo "<div class='artistContainer'>
                    <h2>Artists</h2><br>
                    ";
        $artistQuery = $con->prepare("SELECT id FROM artists WHERE name LIKE ('$term%')");
        $artistQuery->execute();
        $artistIdArray = $artistQuery->fetchAll(PDO::FETCH_COLUMN);
        if (empty($artistIdArray)) {
            echo "<div class='noResults'>

                        No artist found matching " . $term . " ..</div>";
        } else {
            $i = 1;

            foreach ($artistIdArray as $artistId) {
                if ($i > 15) {
                    break;
                }
                $artist = new Artist($artistId);
                echo "
                    <div class='artistRow'>
                        <div class='artistName'>" . $artist->getName() . "</div>

                            <div class='artistButton' onclick='openPage(\"artist.php?id=" . $artist->getId() . "\")' >
                              <div>Visit ".$artist->getName()." page here</div>
                              <img src='assets/icons/loginvisit.svg' alt=''>
                            </div>
                    </div>
                    ";
                $i += 1;
            }
        }
            echo " </div>";
            echo "<div class='AlbumsContainer'>
                    <h2>Albums</h2><br>
                    ";
            $query = "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10";
            $response = $con->query($query);
            $albums = $response->fetchAll(PDO::FETCH_OBJ);
            if (empty($albums)) {
                echo "<div class='noResults'>

                        No album found matching " . $term . " ..</div>";
            } else {
                foreach ($albums as $album) {
                    echo "<div class='gridViewItem ' onclick='openPage(\"album.php?id=" . $album->id. "\")'>
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
            }

    } ?>
    <script>
        var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
        tempPlaylist = JSON.parse(tempSongIds);
    </script>
</div>
<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?=Playlist::getPlaylistDropdown($con,$username);?>
</nav>
<script>
    $(".searchInput").focus();
    $(function () {
        var timer;
        $(".searchInput").keyup(function () {
            clearTimeout(timer);
            timer = setTimeout(function () {
         var val = $(".searchInput").val();
         openPage("search.php?term=" + val);

            }, 1); //}, 1000);
        })
    })
</script>

