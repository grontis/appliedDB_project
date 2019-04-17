<?php
require 'connection.php';

$charName = $_POST["ch_name"];

$query =    "DELETE FROM characters
             WHERE ch_name = '". $charName . "';";

mysqli_query($con, $query) or die("Delete query failed");

echo "0";