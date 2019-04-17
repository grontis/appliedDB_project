<?php
require 'connection.php';

$username = $_POST["username"];

//retrieve ID number of currently logged in user account
$userIDQuery = "SELECT id
                FROM users
                WHERE username = '" . $username . "'; ";
$userIDresult = mysqli_query($con, $userIDQuery)or die("error2:user ID Query Failed");
$userdata = mysqli_fetch_assoc($userIDresult);
$userID = $userdata["id"];

//query for all characters related to userID
$charactersQuery = "SELECT ch_name, race, class, level
                    FROM characters
                    WHERE user_id = '" . $userID . "';";

$characters = mysqli_query($con, $charactersQuery) or die("Error: failed to retrieve characters");
$numChars = mysqli_num_rows($characters);

echo "0\t";
echo $numChars . "\t";

while($character = mysqli_fetch_array($characters))
{
    $charName = $character["ch_name"];
    $charRace = $character["race"];
    $charClass = $character["class"];
    $charLevel = $character["level"];

    echo $charName . "\t" . $charRace . "\t" . $charClass . "\t" . $charLevel . "\t" ;
}