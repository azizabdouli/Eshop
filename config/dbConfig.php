<?php
//DB details
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'db';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName,'3306');

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}
?>
