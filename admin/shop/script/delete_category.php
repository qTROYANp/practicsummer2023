<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$id_category = $_GET['id'];

// Получаем имя категории из базы данных
$stmt = $pdo->prepare("SELECT name FROM m_category WHERE id_category=?");
$stmt->execute([$id_category]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

$category_name = $category['name'];

// Обновляем информацию категории в базе данных
$stmt = $pdo->prepare("DELETE FROM m_category WHERE id_category=? LIMIT 1");
$stmt->execute([$id_category]);

// Добавляем запись в лог
$logText = "Удалена категория: $category_name";
$stmt = $pdo->prepare("INSERT INTO logs (id_user, username, text, date) VALUES (:id_user, :username, :text, NOW())");
$stmt->bindParam(':id_user', $_SESSION['id_user']);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->bindParam(':text', $logText);
$stmt->execute();

// Перенаправление пользователя на страницу с информацией о категориях
$url = "categories_list";
header("Location: ../../index.php?url=shop/template/" . $url);
exit();
