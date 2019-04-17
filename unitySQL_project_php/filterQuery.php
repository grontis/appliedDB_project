<?php
require 'connection.php';

$zone = $_POST["zone"];
$questID = $_POST["questID"];
$race = $_POST["race"];
$class = $_POST["class"];
$level = $_POST["level"];

//retrieve ID number of currently logged in user account
$zoneIDQuery = "SELECT z_id
                FROM zone
                WHERE z_name = '" . $zone . "'; ";
$zoneIDresult = mysqli_query($con, $zoneIDQuery)or die("error2:user ID Query Failed");
$zonedata = mysqli_fetch_assoc($zoneIDresult);
$zoneID = $zonedata["id"];


//all fields empty
if($zone == "N/A" && $questID == 0 && $race == "N/A" && $class == "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters;";
}

//only zone filled
else if($zone != "N/A" && $questID == 0 && $race == "N/A" && $class == "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . ";";
}

//only quest filled
else if($zone == "N/A" && $questID != 0 && $race == "N/A" && $class == "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN gives_quest Q
                 ON C.ch_id = Q.ch_id AND Q.npcID = " . $questID . ";";
}

//only race filled
else if($zone == "N/A" && $questID == 0 && $race != "N/A" && $class == "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters
                 WHERE race = '" . $race . "';";
}

//only class filled
else if($zone == "N/A" && $questID == 0 && $race == "N/A" && $class != "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters
                 WHERE class = '" . $class . "';";
}

//only level
else if($zone == "N/A" && $questID == 0 && $race == "N/A" && $class == "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters
                 WHERE level = " . $level . ";";
}


//zone and quest
else if($zone != "N/A" && $questID != 0 && $race == "N/A" && $class == "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 INTERSECT
                 SELECT ch_name, race, class, level
                 FROM characters C JOIN gives_quest Q
                 ON C.ch_id = Q.ch_id AND Q.npcID = " . $questID . ";";
}

//zone and race
else if($zone != "N/A" && $questID == 0 && $race != "N/A" && $class == "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE race = '" . $race . "' ;";
}

//zone and class
else if($zone != "N/A" && $questID == 0 && $race == "N/A" && $class != "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE class = '" . $class . "' ;";
}

//zone and level
else if($zone != "N/A" && $questID == 0 && $race == "N/A" && $class == "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE level = " . $level . " ;";
}

//quest and race
else if($zone == "N/A" && $questID != 0 && $race != "N/A" && $class == "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN gives_quest Q
                 ON C.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C.race = '". $race . "';";
}

//quest and class
else if($zone == "N/A" && $questID != 0 && $race == "N/A" && $class != "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN gives_quest Q
                 ON C.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C.class = '". $class . "';";
}

//quest and level
else if($zone == "N/A" && $questID != 0 && $race == "N/A" && $class == "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN gives_quest Q
                 ON C.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C.level = ". $level . ";";
}

//race and class
else if($zone == "N/A" && $questID == 0 && $race != "N/A" && $class != "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters
                 WHERE race = '" . $race ."' AND class = '" . $class . "';";
}

//race and level
else if($zone == "N/A" && $questID == 0 && $race != "N/A" && $class == "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters
                 WHERE race = '" . $race ."' AND level = '" . $level . "';";
}

//class and level
else if($zone == "N/A" && $questID == 0 && $race == "N/A" && $class != "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters
                 WHERE class = '" . $class ."' AND level = " . $level . ";";
}

//zone, quest, race
else if($zone != "N/A" && $questID != 0 && $race != "N/A" && $class == "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE C.race = '" . $race . "'
                 INTERSECT
                 SELECT ch_name, race, class, level
                 FROM characters C1 JOIN gives_quest Q
                 ON C1.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C1.race = '" . $race . "';";
}

//zone, quest, class
else if($zone != "N/A" && $questID != 0 && $race == "N/A" && $class != "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE C.class = '" . $class . "'
                 INTERSECT
                 SELECT ch_name, race, class, level
                 FROM characters C1 JOIN gives_quest Q
                 ON C1.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C1.class = '" . $class . "';";
}

//zone,quest, level
else if($zone != "N/A" && $questID != 0 && $race == "N/A" && $class == "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE C.level = '" . $level . "'
                 INTERSECT
                 SELECT ch_name, race, class, level
                 FROM characters C1 JOIN gives_quest Q
                 ON C1.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C1.level = '" . $level . "';";
}

//zone, race, class
else if($zone != "N/A" && $questID == 0 && $race != "N/A" && $class != "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE race = '" . $race . "' AND class = '" . $class  . "';";
}

//zone, race, level
else if($zone != "N/A" && $questID == 0 && $race != "N/A" && $class == "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE race = '" . $race . "' AND level = " . $level  . ";";
}

//zone, class, level
else if($zone != "N/A" && $questID == 0 && $race == "N/A" && $class != "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE class = '" . $class . "' AND level = " . $level  . ";";
}


//quest, race, class
else if($zone == "N/A" && $questID != 0 && $race != "N/A" && $class != "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN gives_quest Q
                 ON C.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C.race = '". $race . "' AND class = '" . $class ."';";
}

//quest, race, level
else if($zone == "N/A" && $questID != 0 && $race != "N/A" && $class == "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN gives_quest Q
                 ON C.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C.race = '". $race . "' AND level = " . $level .";";
}

//quest class, level
else if($zone == "N/A" && $questID != 0 && $race == "N/A" && $class != "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN gives_quest Q
                 ON C.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C.class = '". $class . "' AND level = " . $level .";";
}

//race, class, level
else if($zone == "N/A" && $questID == 0 && $race != "N/A" && $class != "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters
                 WHERE race = '" . $race . "' AND class = '" . $class ."' AND level = " . $level . ";";
}

//zone, quest, race, class
else if($zone != "N/A" && $questID != 0 && $race != "N/A" && $class != "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE C.race = '" . $race . "' AND C.class = '" . $class . "'
                 INTERSECT
                 SELECT ch_name, race, class, level
                 FROM characters C1 JOIN gives_quest Q
                 ON C1.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C1.race = '" . $race . "'AND C.class = '" . $class . "';";
}

//zone, quest, race, level
else if($zone != "N/A" && $questID != 0 && $race != "N/A" && $class == "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE C.race = '" . $race . "' AND C.level = " . $level. "
                 INTERSECT
                 SELECT ch_name, race, class, level
                 FROM characters C1 JOIN gives_quest Q
                 ON C1.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C1.race = '" . $race . "'AND C.level = '" . $level . "';";
}

//zone, race, class, level
else if($zone != "N/A" && $questID == 0 && $race != "N/A" && $class != "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM located_in Z JOIN characters C
                 ON Z.ch_id = C.ch_id AND Z.z_id = " . $zoneID ."
                 WHERE C.race = '" . $race . "' AND C.class = '". $class ."' 
                 AND C.level = '" . $level . "'; ";
}

//quest, race, class, level
else if($zone == "N/A" && $questID != 0 && $race != "N/A" && $class != "N/A" && $level != 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM gives_quest Q JOIN characters C
                 ON Q.ch_id = C.ch_id AND Q.npcID = " . $questID ."
                 WHERE C.race = '" . $race . "' AND C.class = '". $class ."' 
                 AND C.level = '" . $level . "'; ";
}

//all fields
else
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C JOIN located_in L
                 ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 WHERE C.race = '" . $race . "' AND C.class = '" .$class . "' AND C.level = " . $level. "
                 INTERSECT
                 SELECT ch_name, race, class, level
                 FROM characters C1 JOIN gives_quest Q
                 ON C1.ch_id = Q.ch_id AND Q.npcID = " . $questID . "
                 WHERE C1.race = '" . $race . "'AND C.class = '" .$class . "' AND C.level = '" . $level . "';";
}





$results = mysqli_query($con, $query) or die("Error: player search failed.");
$numResults = mysqli_num_rows($results);


echo "0\t";
echo $numResults . "\t";

while($result = mysqli_fetch_array($results))
{
    $charName = $result["ch_name"];
    $charRace = $result["race"];
    $charClass = $result["class"];
    $charLevel = $result["level"];

    echo $charName . "\t" . $charRace . "\t" . $charClass . "\t" . $charLevel . "\t";
}

