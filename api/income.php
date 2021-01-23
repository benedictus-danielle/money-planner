<?php
require_once "../helpers/connection.php";
require_once "../helpers/function.php";
if($_SERVER["REQUEST_METHOD"] === "GET") {
    $income = $conn->query("SELECT * FROM income ORDER BY created_at DESC");
    $data["income"] = getDataFromQueryResult($income);

    echo json_encode($data);
}
