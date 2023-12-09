<?php
include("../../config.php");
if(isset($_POST['name']) && isset($_POST['username'])) {

    $name = $_POST['name'];
    $username = $_POST['username'];
    $date = date("Y-m-d");

    $query = "INSERT INTO playlists VALUES('','$name', '$username', '$date')";
    $response=$con->prepare($query);
    $response->execute();
}
else {
    echo "Name or username parameters not passed into file";
}

?>