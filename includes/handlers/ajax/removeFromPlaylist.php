<?php
include("../../config.php");

if(isset($_POST['playlistId'])&&isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
    $songId=$_POST['songId'];
    $songsQuery =  "DELETE FROM playlistSongs WHERE playlistId=? and songId=?";
    $songResp=$con->prepare($songsQuery);
    $songResp->execute([$playlistId,$songId]);
}
else
{
    echo  "playlistId or songId not passed correctly";
}

?>