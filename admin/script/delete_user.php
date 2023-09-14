<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 1) {
    header("Location: /admin"); 
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$id_user = $_GET['id'];


// Удаление пользователя из базы данных
$stmt = $pdo->prepare("DELETE FROM user WHERE id_user=? LIMIT 1");
$stmt->execute([$id_user]);

header("Location: /admin/index.php?url=users_list");
exit();
?>
