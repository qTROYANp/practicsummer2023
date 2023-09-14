<?php

function db_row($table, $table_pole = 0, $id = 0)
{

    if (empty($table_pole)) {
        $stmt = $GLOBALS["pdo"]->query("SELECT * FROM $table");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }
    if ($table_pole!=0 and $id!=0) {
        $stmt = $GLOBALS["pdo"]->query("SELECT * FROM $table WHERE $table_pole=$id");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}


function db_column($table, $table_pole = 0, $id = 0)
{
    if ($table_pole!=0 and $id!=0) {
        $stmt = $GLOBALS["pdo"]->query("SELECT * FROM $table WHERE $table_pole=$id");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

}

// function db_column($table, $table_pole, $id)
// {
//     $stmt = $GLOBALS["pdo"]->prepare("SELECT * FROM :table WHERE id_page=:id");
//     $stmt->bindParam(":id", $id);
//     $stmt->bindParam(":table", $table);
//     $stmt->execute();
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $result;
// }
