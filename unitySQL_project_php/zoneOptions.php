<?php
require 'connection.php';

$zone = $_POST["zone"];

$zoneQuery =   "SELECT z_name 
                FROM zone
                WHERE z_name != '" . $zone . "';";
                

$zoneResult = mysqli_query($con, $zoneQuery) or die ("Error: zone query failed.");
$numZones = mysqli_num_rows($zoneResult);

echo "0\t";
echo $numZones . "\t";

while($zone = mysqli_fetch_array($zoneResult))
{
    $zoneName = $zone["z_name"];

    echo $zoneName . "\t";
}