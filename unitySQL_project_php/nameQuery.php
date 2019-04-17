<?php
require 'connection.php';

$charName = $_POST["name"];

//retrieve ID of character
$charIDQuery = "SELECT ch_id
                FROM characters
                WHERE ch_name = '" . $charName . "'; ";
$charIDresult = mysqli_query($con, $charIDQuery)or die("error2:user ID Query Failed");

if (mysqli_num_rows($charIDresult) == 0)
{
    echo "0\t" . "0\t";
}
else
{
    $chardata = mysqli_fetch_assoc($charIDresult);
    $charID = $chardata["ch_id"];

    $query =   "SELECT ch_name, race, class, level
            FROM characters
            WHERE ch_id = ". $charID . ";";

    $result = mysqli_query($con, $query) or die ("Query failed for name search");

    $characterData = mysqli_fetch_assoc($result);

    $name = $characterData["ch_name"];
    $race = $characterData["race"];
    $class = $characterData["class"];
    $level = $characterData["level"];

    echo "0\t" . "1\t" .  $name . "\t" . $race . "\t" . $class . "\t" . $level . "\t";
}
