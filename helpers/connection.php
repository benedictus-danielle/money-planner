<?php
$HOSTNAME = "localhost";
$USERNAME = "root";
$PASSWORD = "";
$DBNAME = "money_planner";

$conn = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DBNAME);
if ($conn->errno) {
    die($conn->error);
}