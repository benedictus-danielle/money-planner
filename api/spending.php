<?php

require_once "../helpers/connection.php";
require_once "../helpers/function.php";
if($_SERVER["REQUEST_METHOD"] === "GET") {
    $query = '
    SELECT 
        spending.id,
        category.name as category_name,
        description,
        amount,
        spending.created_at
    FROM 
        spending
        JOIN category ON category_id = category.id
    ' . (isset($_GET["date"]) === true ? (' WHERE CONVERT(spending.created_at, DATE) = \'' . $_GET["date"] . '\' ') : " ") . '
    ORDER BY
        spending.created_at DESC';

    $result = $conn->query($query);
    $categories = $conn->query("SELECT * FROM category");
    $data = [];
    $data["spending"] = getDataFromQueryResult($result);
    $data["categories"] = getDataFromQueryResult($categories);
    $data["grand_total"] = $conn->query("SELECT SUM(amount) as total FROM spending")->fetch_assoc()["total"];
    $data["income_total"] = $conn->query("SELECT SUM(amount) as total FROM income")->fetch_assoc()["total"];
    $data["dates"] = $conn->query("SELECT DISTINCT CONVERT(created_at, DATE) as insert_date FROM spending");


    $spending_by_category = "
                    SELECT
                        category.name as category_name,
                        sum(amount) as total
                    FROM
                        spending
                        JOIN category ON category_id = category.id
                    " . (isset($_GET["date"]) === true ? (' WHERE CONVERT(spending.created_at, DATE) = \'' . $_GET["date"] . '\' ') : " ") . "
                    GROUP BY
                        category.name
                    ORDER BY
                        total DESC
                ";
    $grouped = $conn->query($spending_by_category);
    $data["spending_by_category"] = getDataFromQueryResult($grouped);

    echo json_encode($data);
}
