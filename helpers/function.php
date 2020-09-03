<?php 

/**
 * @param Array Object
 * [\
 *      [\
 *        "column"=>"x",\
 *        "data_type"=>"y",\
 *        "extras"=>[]\
 *      ]\
 * ]
 */
function createTableStatement($table_name, $attributes, $foreign_keys = NULL){
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

function formattingNumber($number){
    return number_format($number);
}