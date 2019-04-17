<?php
require 'connection.php';

//sanitize username input before query
$username = mysqli_real_escape_string($con, $_POST["username"]);
$usernameClean = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if($username != $usernameClean)
{
    echo "Error: insecure input behavior";
    exit();
}

$password = $_POST["password"];

//check if name exists
$namecheckquery = "SELECT username, salt, hash
                    FROM users 
                    WHERE username = '" . $usernameClean. "';";
$namecheck = mysqli_query($con, $namecheckquery) or die("error2:Namecheck Query Failed");
if(mysqli_num_rows($namecheck) != 1)
{
    echo "error5: No user with name, or more than 1 for some reason(unlikely)";
    exit();
}

//get login info from query
$userinfo = mysqli_fetch_assoc($namecheck);
$salt = $userinfo["salt"];
$hash = $userinfo["hash"];

$loginhash = crypt($password, $salt);
//validate password information
if($hash != $loginhash)
{
    echo "error6: incorrect password";
    exit();
}

echo"0";