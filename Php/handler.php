<?php
//------------------------Обработчик-запросов-------------------------//

$url = 'home.php';

if(isset($_GET["url"])){
    $url = $_GET["url"].'.php'; 
}


?>