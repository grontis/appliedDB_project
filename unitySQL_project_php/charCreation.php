<?php
require 'connection.php';

//sanitize charname input before query
$charName = mysqli_real_escape_string($con, $_POST["charName"]);
$charNameClean = filter_var($charName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if($charName != $charNameClean)
{
    echo "Error: insecure input behavior";
    exit();
}

//check if charname exists
$namecheckquery = "SELECT ch_name 
                    FROM characters 
                    WHERE ch_name = '" . $charName. "';";
$namecheck = mysqli_query($con, $namecheckquery) or die("error2:Namecheck Query Failed");
if(mysqli_num_rows($namecheck) > 0)
{
    echo "error3: Name Already Exists"; //error code number 3
    exit();
}

$username = $_POST["username"];

//retrieve ID number of currently logged in user account
$userIDQuery = "SELECT id
                FROM users
                WHERE username = '" . $username . "'; ";
$userIDresult = mysqli_query($con, $userIDQuery)or die("error2:user ID Query Failed");
$userdata = mysqli_fetch_assoc($userIDresult);
$userID = $userdata["id"];

$charRace = $_POST["charRace"];
$charClass = $_POST["charClass"];

//insert character information into database
$insertCharQuery = "INSERT INTO characters (ch_name, user_id, race, class)
                    VALUES ('" . $charNameClean . "', '". $userID . "', '" . $charRace . "', '" . $charClass . "');";

mysqli_query($con, $insertCharQuery) or die ("error: character insertion failed");

//retrieve ID of character
$charIDQuery = "SELECT ch_id
                FROM characters
                WHERE ch_name = '" . $charName . "'; ";
$charIDresult = mysqli_query($con, $charIDQuery)or die("error2:user ID Query Failed");
$chardata = mysqli_fetch_assoc($charIDresult);
$charID = $chardata["ch_id"];

//insert character into starting zone.
$zoneQuery =    "INSERT INTO located_in (ch_id, z_id)
                 VALUES (". $charID .", 1);";
$zoneResult = mysqli_query($con, $zoneQuery) or die ("Zone insertion failed");

echo("0");