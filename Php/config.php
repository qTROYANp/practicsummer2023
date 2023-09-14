<?php
//------------------------Constant-------------------------//
//--Db--//
$name_server = "localhost";
$name_db = "praktika2";
$db_user = "praktika2";
$db_password = "";
//--Time--//
$data_format = "";
$time_format = "";
$datetime_format = "";
$data_timezone = "";
//--Security--//
$min_password_lenght = 8;
$session_life_time = 3600;
$encryption_key = "key";
//--Headr-Htmtl--//
//Не придумал, что сюда запунуть

//---------------------connect-with-DB---------------------//

try{
    $connection_string = "mysql:host=$name_server;dbname=$name_db;charset=utf8mb4";
    $pdo = new PDO($connection_string, $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Ошибка подключения к БД";
}

//---------------------------------------------------------//


?>
