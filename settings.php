<?php
include_once "includes/includedFiles.php";
$user=new User($username);
?>
<div class="userEntityInfo">
    <div class="settingsCenterSection">
        <div class="userInfo">
            <h1><?=$user->getFirstAndLastName()?></h1>
        </div>
    </div>
</div>
<div class="buttonItems">
    <button class="button1" onclick="openPage('updateDetails.php')">USER DETAILS</button>
    <button class="button2" onclick="logout()">LOGOUT</button>
</div>




