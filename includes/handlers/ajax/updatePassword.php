<?php
include("../../config.php");

if(!isset($_POST['username'])) {
    echo "ERROR: Could not set username";
    exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1'])  || !isset($_POST['newPassword2'])) {
    echo "Not all passwords have been set";
    exit();
}

if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == ""  || $_POST['newPassword2'] == "") {
    echo "Please fill in all fields";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$oldMd5 = md5($oldPassword);

$query="SELECT password from users Where username=?";
$resp=$con->prepare($query);
$resp->execute([$username]);
$passwordCheck=$resp->fetch(PDO::FETCH_COLUMN);
if($oldMd5!= $passwordCheck)
{
    echo "Incorrect Password";
    exit();
}
elseif($newPassword1!=$newPassword2)
{
    echo "Newa passwords don't match";
    exit();
}
//check that the password contains letters and numbers only
if(preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
    echo "Your password must only contain letters and/or numbers";
    exit();
}
// control length of password
if(strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
    echo "Your username must be between 5 and 30 characters";
    exit();
}
//encode the new Password
$newMd5=md5($newPassword1);
$query="UPDATE users set password= ? where username=?";
$resp=$con->prepare($query);
$resp->execute([$newMd5,$username]);
echo "Password has been changed !";

?>
