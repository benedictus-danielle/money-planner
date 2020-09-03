<?php
require_once './helpers/function.php';
require_once './helpers/connection.php';
$query = [
    "CREATE DATABASE IF NOT EXISTS money_planner;",
    "USE money_planner;",
    createTableStatement("category", [
        [
            "column" => "id",
            "data_type" => "int",
            "extras" => ["primary key", "auto_increment"]
        ],
        [
            "column" => "name",
            "data_type" => "varchar(255)",
            "extras" => []
        ]
    ]),
    createTableStatement(
        "spending",
        [
            [
                "column" => "id",
                "data_type" => "int",
                "extras" => ["primary key", "auto_increment"]
            ],
            [
                "column" => "category_id",
                "data_type" => "int",
                "extras" => []
            ],
            [
                "column"=>"description",
                "data_type" => "varchar(255)",
                "extras" => ["DEFAULT '-'"]
            ],
            [
                "column" => "amount",
                "data_type" => "int",
                "extras" => []
            ],
            [
                "column" => "created_at",
                "data_type" => "timestamp",
                "extras" => ["DEFAULT CURRENT_TIMESTAMP"]
            ]
        ],
        [
            "FOREIGN KEY (category_id) REFERENCES category(id) ON UPDATE CASCADE ON DELETE CASCADE"
        ]
    ),
    createTableStatement(
        "income",
        [
            [
                "column" => "id",
                "data_type" => "int",
                "extras" => ["primary key", "auto_increment"]
            ],
            [
                "column" => "source",
                "data_type" => "varchar(255)",
                "extras" => []
            ],
            [
                "column" => "amount",
                "data_type" => "int",
                "extras" => []
            ],
            [
                "column" => "created_at",
                "data_type" => "timestamp",
                "extras" => ["DEFAULT CURRENT_TIMESTAMP"]
            ]
        ]
    )
];
echo "<pre>";
print_r($query);
echo "</pre>";
foreach ($query as $key => $value) {
    $conn->query($value);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initialize</title>
</head>

<body>
    <form action="" method="POST">
        <button type="submit">Initialize</button>
    </form>
</body>

</html>