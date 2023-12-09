<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) // if the request is an ajax request
{
    include("includes/config.php");
    if(isset($_GET['userLoggedIn']))
    {
        $username=$_GET['userLoggedIn'];
    }
    else
    {
        echo "Username variable was not passed into page. Check the openPage JS function";
        exit();
    }

}
else
    {
        include("includes/header.php");
        include("includes/footer.php");
        $url=$_SERVER['REQUEST_URI'];
        echo "<script>openPage('$url',true); 
        history.pushState(null, null, '$url'); // Use the History API to update the browser's history
        </script>";
        exit();
}
?>
