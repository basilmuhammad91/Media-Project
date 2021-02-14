<?php

$host = "localhost"; 
$user = 'root';
$pass = '';
$dbname = 'mediadb';

$con = mysqli_connect($host, $user, $pass, $dbname);

if(!$con)
{
    echo "Database not connected: ";
}

?>
