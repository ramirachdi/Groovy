<?php
include("../../config.php");

if(isset($_POST['playlistId'])) {
    $playlistId = $_POST['playlistId'];

    $playlistQuery ="DELETE FROM playlists WHERE id=?";
    $playlistResp=$con->prepare($playlistQuery);
    $playlistResp->execute([$playlistId]);
    $songsQuery =  "DELETE FROM playlistSongs WHERE playlistId=?";
    $songResp=$con->prepare($songsQuery);
    $songResp->execute([$playlistId]);
}
else {
    echo "PlaylistId was not passed into deletePlaylist.php";
}


?>