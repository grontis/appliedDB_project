<?php
require 'connection.php';

$username = $_POST["username"];
$charName = $_POST["ch_name"];
$quest_giver = $_POST["quest_giver"];

//retrieve ID of character
$charIDQuery = "SELECT ch_id
                FROM characters
                WHERE ch_name = '" . $charName . "'; ";
$charIDresult = mysqli_query($con, $charIDQuery)or die("error2:user ID Query Failed");
$chardata = mysqli_fetch_assoc($charIDresult);
$charID = $chardata["ch_id"];

//retrieve ID of quest NPC
$questIDQuery = "SELECT npcID
                FROM npcs
                WHERE name = '" . $quest_giver . "'; ";
$questIDresult = mysqli_query($con, $questIDQuery)or die("error2:user ID Query Failed");
$questdata = mysqli_fetch_assoc($questIDresult);
$questID = $questdata["npcID"];

$questQuery = "INSERT INTO gives_quest (ch_id, npcID)
                VALUES ('". $charID . "', '" . $questID . "');";

$questResults = mysqli_query($con, $questQuery) or die ("ERROR: failed to insert quest data");

echo "0";