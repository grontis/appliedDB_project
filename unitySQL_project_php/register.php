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
$email = $_POST["email"];

//check if name exists
$namecheckquery = "SELECT username 
                    FROM users 
                    WHERE username = '" . $usernameClean. "';";
$namecheck = mysqli_query($con, $namecheckquery) or die("error2:Namecheck Query Failed");
if(mysqli_num_rows($namecheck) > 0)
{
    echo "error3: Name Already Exists"; //error code number 3
    exit();
}

//add user to the table
$salt = "\$5\$rounds=5000\$" . "mixmagdj" . $username . "\$";
$hash = crypt($password, $salt);
$insertuserquery = "INSERT INTO users (username, hash, salt, email)
                    VALUES ('" . $usernameClean ."', '" . $hash . "' , '" . $salt . "','" . $email . "');";
mysqli_query($con, $insertuserquery) or die("4: insertion query failed"); //error code #4

echo("0");