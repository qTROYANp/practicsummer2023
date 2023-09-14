<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$id_page = $_GET['id'];

// Получаем имя страницы
$stmt = $pdo->prepare("SELECT name FROM page WHERE id_page = ?");
$stmt->execute([$id_page]);
$pageData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($pageData) {
    $name = $pageData['name'];

    // Удаляем страницу
    $stmt = $pdo->prepare("DELETE FROM page WHERE id_page = ?");
    $stmt->execute([$id_page]);

    // Добавляем запись в лог об удалении
    $logText = "Удалена страница: $name";
    $stmt = $pdo->prepare("INSERT INTO logs (id_user, username, text, date) VALUES (:id_user, :username, :text, NOW())");
    $stmt->bindParam(':id_user', $_SESSION['id_user']);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->bindParam(':text', $logText);
    $stmt->execute();

    // Обновляем ссылки в логах
    $newLogText = "Добавлена страница: " . $name;
    $stmt = $pdo->prepare("UPDATE logs SET text = :newLogText WHERE id_page = :pageId AND text LIKE 'Добавлена страница%'");
    $stmt->bindParam(':newLogText', $newLogText);
    $stmt->bindParam(':pageId', $id_page, PDO::PARAM_INT);
    $stmt->execute();

    // Обновляем записи в логах
    $newLogText = "Отредактирована страница: " . $name;
    $stmt = $pdo->prepare("UPDATE logs SET text = :newLogText WHERE id_page = :pageId AND text LIKE 'Отредактирована страница%'");
    $stmt->bindParam(':newLogText', $newLogText);
    $stmt->bindParam(':pageId', $id_page, PDO::PARAM_INT);
    $stmt->execute();
}

// Перенаправление пользователя на страницу с информацией о списке страниц
$url = "pages_list";
header("Location: ../../index.php?url=site/template/" . $url);
exit();
