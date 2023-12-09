<?php
//IF THE USERNAME IS NOT SET
include("../../config.php");
if(!isset($_POST['username']))
{
    echo 'Error: username is not set';
    exit();
}
// IF THE ENTERED EMAIL IS NOT NULL
if(isset($_POST['email'])&&$_POST['email']!="")
{
    $username=$_POST['username'];
    $email=$_POST['email'];
    // IF THE FORMAT IS INCORRECT
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        echo "Email is invalid";
        exit();
    }
    $query="Select email from users WHERE email= ? and username!= ?";
    $response=$con->prepare($query);
    $response->execute([$email,$username]);
    $emailCheck=$response->rowCount();

    if($emailCheck>0)
    {
        echo "Email already in use !";
        exit();
    }
  $userRepo->update('email',$email,$username);
    echo "update Succesful !";

}
else
{
    echo 'You must provide an email';
}

