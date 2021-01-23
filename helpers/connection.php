<?php
$HOSTNAME = "128.199.198.148";
$USERNAME = "bd";
$PASSWORD = "2704205210393635";
$DBNAME = "money_planner";

$conn = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DBNAME);
if ($conn->errno) {
    die($conn->error);
}