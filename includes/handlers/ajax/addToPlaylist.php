<?php
include("../../config.php");
if(isset($_POST['playlistId'])&&isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];
    $orderIdQuery ="SELECT max(playlistOrder) FROM playlistSongs WHERE playlistid= ? ";
    $orderIdResp=$con->prepare($orderIdQuery);
    $orderIdResp->execute([$playlistId]);
    $order=$orderIdResp->fetch(PDO::FETCH_COLUMN);
    $query="INSERT INTO playlistSongs VALUES('','$songId','$playlistId','$order')";
    $resp=$con->prepare($query);
    $resp->execute();

}
else {
    echo "PlaylistId or Song Id were not passed into addToPlaylist.php";
}
?>
