<?php
include("includes/includedFiles.php");
$playlistRepo=new playlistRepository();
$userLoggedIn=new User($username);
?>

<div class="playlistsContainer">
    <div class="groovyPlaylist">
        <div class="groovyText">Groovy</div>
        <div class="playlistsText">Playlists</div>
        <div class="paraText">
            You can create your own personalized playlists to suit your
            unique taste and preferences. Our user-friendly interface allows you to easily
            search for and add your favorite songs from our vast library of music.
        </div>
    </div>
    <div class="gridViewContainer">

        <div class="gridViewItems">
            <div class="gridViewItem2" role="link" tabIndex="0">
            <img src='assets/icons/playlist.svg' alt='playlist' onclick="createPlaylist()">
            </div>



        <?php
        $username = $userLoggedIn->getUsername();
        $playlists=$playlistRepo->findAllByUsername($username);

        if(empty($playlists)) {
            echo "<span class='noResults'>You don't have any playlists yet.</span>";
        }

        foreach($playlists as $row) {

            $playlist = new Playlist($row);
            echo "<div class='gridViewItem2' role='link' tabindex='0'
            onclick='openPage(\"playlist.php?id=".$playlist->getId()."\")'>

						<div class='playlistImage'>
							<img src='assets/icons/cover2.svg'>
							<div class='playlistName'>". $playlist->getName() ."</div>
						</div>

						<div class='gridViewInfo'>"
                . $playlist->getName() .
                "</div>

					</div>";



        }
        ?>
        </div>
    </div>
</div>


