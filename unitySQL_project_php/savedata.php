<?php
require 'connection.php';

$username = $_POST["username"];
$charName = $_POST["ch_name"];
$level = $_POST["level"];
$xp = $_POST["xp"];
$gold = $_POST["gold"];

//retrieve ID number of currently logged in user account
$userIDQuery = "SELECT id
                FROM users
                WHERE username = '" . $username . "'; ";
$userIDresult = mysqli_query($con, $userIDQuery)or die("error2:user ID Query Failed");
$userdata = mysqli_fetch_assoc($userIDresult);
$userID = $userdata["id"];

$updatequery = "UPDATE characters 
                SET level = " . $level . " , xp = " . $xp . ", gold = " . $gold . "
                WHERE user_id = '" . $userID . "' AND ch_name = '" . $charName . "';";

mysqli_query($con, $updatequery) or die("error7: save query failed");

echo "0";