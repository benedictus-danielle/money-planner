<?php

require_once "$_SERVER[DOCUMENT_ROOT]/vendor/autoload.php";
$dotenv = \Dotenv\Dotenv::createImmutable("$_SERVER[DOCUMENT_ROOT]/", '.env');
$dotenv->load();

$HOSTNAME = $_ENV["REMOTE_HOST"];
$USERNAME = "bd";
$PASSWORD = $_ENV["BD_PASSWORD"];
$DBNAME = "money_planner";

$conn = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DBNAME);
if ($conn->errno) {
    die($conn->error);
}
