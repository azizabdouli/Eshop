<?php
/* Database connection settings */
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db';
$mysqli = new mysqli($host,$user,$pass,$db,'3306') or die($mysqli->error);
