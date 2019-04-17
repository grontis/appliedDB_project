<?php
require 'connection.php';

$username = $_POST["username"];
$charName = $_POST["ch_name"];

//retrieve ID number of currently logged in user account
$userIDQuery = "SELECT id
                FROM users
                WHERE username = '" . $username . "'; ";
$userIDresult = mysqli_query($con, $userIDQuery)or die("error2:user ID Query Failed");
$userdata = mysqli_fetch_assoc($userIDresult);
$userID = $userdata["id"];

//retrieve ID of character
$charIDQuery = "SELECT ch_id
                FROM characters
                WHERE ch_name = '" . $charName . "'; ";
$charIDresult = mysqli_query($con, $charIDQuery)or die("error2:user ID Query Failed");
$chardata = mysqli_fetch_assoc($charIDresult);
$charID = $chardata["ch_id"];

$statsQuery = " SELECT xp, gold
                FROM characters
                WHERE user_id = '" . $userID . "' AND ch_name = '" . $charName . "';";

$stats = mysqli_query($con, $statsQuery) or die ("ERROR_ failed stats query");
$statsData = mysqli_fetch_assoc($stats);

$xp = $statsData["xp"];
$gold = $statsData["gold"];

//checks if character has an active quest
$questQuery =  "SELECT npcID
                FROM gives_quest 
                WHERE ch_id = '" . $charID . "';";

$questResult = mysqli_query($con, $questQuery) or die ("error: quest query failed");
if(mysqli_num_rows($questResult) == 0)
{
    $questID = "none";
}
else
{
    $questData = mysqli_fetch_assoc($questResult);
    $questID = $questData["npcID"];
}

echo "0\t" . $xp . "\t" . $gold . "\t" . $questID . "\t";