<?php
session_start();

// Очистить все данные сессии
$_SESSION = array();

// Завершить сессию
session_destroy();

setcookie(session_name(), '', time() - 3600, '/');

// Перенаправить пользователя на страницу входа
header("Location: ../../login.php");
exit();
