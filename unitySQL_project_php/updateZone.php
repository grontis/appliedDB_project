<?php
require 'connection.php';

$charName = $_POST["ch_name"];
$zone = $_POST["zone"];

//retrieve ID of character
$charIDQuery = "SELECT ch_id
                FROM characters
                WHERE ch_name = '" . $charName . "'; ";
$charIDresult = mysqli_query($con, $charIDQuery)or die("error2:user ID Query Failed");
$chardata = mysqli_fetch_assoc($charIDresult);
$charID = $chardata["ch_id"];

//retrieve ID of zone
$zoneIDQuery = "SELECT z_id
                FROM zone
                WHERE z_name = '" . $zone . "'; ";
$zoneIDresult = mysqli_query($con, $zoneIDQuery)or die("error2:zone ID Query Failed");
$zonedata = mysqli_fetch_assoc($zoneIDresult);
$zoneID = $zonedata["z_id"];


$zoneQuery =    "UPDATE located_in
                 SET z_id = " . $zoneID . "
                 WHERE ch_id = ". $charID . ";";

mysqli_query($con, $zoneQuery) or die("Zone query update failed");

echo "0";