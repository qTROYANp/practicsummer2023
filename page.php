<?php

$result =  db_column("page", 'id_page', $_GET['id']);

$album = db_row("page_album", 'id_page', $_GET['id']);

$document = db_row("page_docs", 'id_page', $_GET['id']);

include 'template/desing_page.php';
