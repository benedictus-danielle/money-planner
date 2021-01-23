<?php
require './vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable("./", '.env');
$dotenv->load();

$HOSTNAME = $_ENV["REMOTE_HOST"];
$USERNAME = "bd";
$PASSWORD = $_ENV["BD_PASSWORD"];
$DBNAME = "money_planner";

$conn = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DBNAME);
if ($conn->errno) {
    die($conn->error);
}
