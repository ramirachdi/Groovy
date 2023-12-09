<?php
include_once("includes/includedFiles.php");
?>
<div class="settingsHeader">Settings</div>
<div class="userDeatils">
<div class="userMailContainer">
    <h2 class="mailcontainer">Email</h2>

        <input type="text" class="email" name="email" placeholder="Current Email Adress" required>
        <span class="message1"></span>
        <button class="saveButton" onclick="updateEmail('email')">SAVE</button>
</div>
    <div class="userPasswordContainer">
        <h2 class="passwordcontainer1">Current Password</h2>
        <input type="password" class="oldPassword" name="oldPassword" placeholder="Current password"  required>
        <h2 class="passwordcontainer2">New Password</h2>
        <input type="password" class="newPassword1" name="newPassword1" placeholder="New password"  required>
        <h2 class="passwordcontainer3">Confirm New Password</h2>
        <input type="password" class="newPassword2" name="newPassword2" placeholder="Confirm password" required>
        <span class="message2"></span>
        <button class="saveButton" onclick="updatePassword('oldPassword','newPassword1','newPassword2')">
            SAVE
        </button>
    </div>
</div>
