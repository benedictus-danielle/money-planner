<?php
$HOSTNAME = getenv("REMOTE_HOST");
$USERNAME = "bd";
$PASSWORD = getenv("BD_PASSWORD");
$DBNAME = "money_planner";

$conn = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DBNAME);
if ($conn->errno) {
    die($conn->error);
}