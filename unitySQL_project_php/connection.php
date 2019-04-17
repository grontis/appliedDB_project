<?php
$con = mysqli_connect('localhost', 'root', '', 'unity');

if(mysqli_connect_errno())
{
    echo "error1: ConnectionFailed";
    exit();
}