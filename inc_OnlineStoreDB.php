<?php
$ErrorMsgs = array();
$hostname = "localhost";
$username = "root";
$password = "root";
$database = "ggg";

$DBConnect = new mysqli($hostname, $username, $password,$database);

if (!$DBConnect)
    $ErrorMsgs[] = "The database server is not available.";

