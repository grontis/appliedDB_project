<?php


//zone and quest
else if($zone != "N/A" && $questID != 0 && $race == "N/A" && $class == "N/A" && $level == 0)
{
    $query =    "SELECT ch_name, race, class, level
                 FROM characters C 
                 JOIN located_in L ON C.ch_id = L.ch_id AND L.z_id = ". $zoneID . "
                 JOIN gives_quest Q ON C.ch_id = Q.ch_id AND Q.npcID = " . $questID . ";";
}

