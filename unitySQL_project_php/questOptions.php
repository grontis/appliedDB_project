<?php
require 'connection.php';

$zone = $_POST["zone"];

$questQuery =  "SELECT npcID, name
                FROM npcs N
                WHERE N.in_zone = '". $zone . "';";

$questResult = mysqli_query($con, $questQuery) or die ("Error: quest query failed");
$numQuests = mysqli_num_rows($questResult);

echo "0\t";
echo $numQuests . "\t";

while($quest = mysqli_fetch_array($questResult))
{
    $npcName = $quest["name"];
    $npcID = $quest["npcID"];

    echo $npcName . "\t" . $npcID . "\t" ;
}