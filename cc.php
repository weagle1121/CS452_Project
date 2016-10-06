<?php

include('codebase/connector/scheduler_connector.php');
include('codebase/connector/db_mysqli.php');

$dbtype = "MySQL";
$servername = "localhost";
$username = "";
$password = "";
$database = "nucor";

// Create connection
$res = new mysqli($servername, $username, $password, $database);

 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

$calendar = new schedulerConnector($res,$dbtype);
$calendar->render_table("events","id","start_date","end_date","text");

?>