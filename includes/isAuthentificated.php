<?php
if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = new User($_SESSION['userLoggedIn']);
    $username = $userLoggedIn->getUsername();
    echo "<script>userLoggedIn = '$username';</script>";
}
else {
    header("Location: register.php");
}
?>