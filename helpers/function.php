<?php

/**
 * @param $table_name
 * @param $attributes
 * @param null $foreign_keys
 * @return string
 */
function createTableStatement($table_name, $attributes, $foreign_keys = NULL): string
{
    $statement = "CREATE TABLE IF NOT EXISTS $table_name( ";
    foreach ($attributes as $key => $value) {
        $statement .= $value["column"] . " ";
        $statement .= $value["data_type"] . " ";
        $statement .= implode(" ", $value["extras"]);
        if($key !== array_key_last($attributes) || $foreign_keys !== NULL)
            $statement .= ",";
    }
    if($foreign_keys !== NULL){
        $statement .= implode(", ", $foreign_keys);
    }
    $statement .= ");";
    return $statement;
}


function pretty_print($printable){
    echo "<pre>".print_r($printable)."</pre>";
}

function formattingNumber($number): string
{
    return number_format($number);
}

function getDataFromQueryResult($result): array
{
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}