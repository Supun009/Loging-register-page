<?php
$serverName = "localhost";
$dbUsername = "supunprasad";
$dbPassword = "abcd1234";
$dbName = "loging1";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if(!$conn){
    die("Connection faild: " .mysqli_connect_error);
}
else {
    echo 'working';
}