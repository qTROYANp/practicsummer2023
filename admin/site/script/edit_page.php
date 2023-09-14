<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$name = $_POST['name'];
$text = $_POST['text'];
$seo_title = $_POST['seo_title'];
$id_page = $_GET['id'];
$part_text = isset($_POST['part_text']) ? $_POST['part_text'] : '';

if ($part_text !== "Нет") {
    $stmt = $pdo->prepare("SELECT id_page FROM page WHERE name=:part_text");
    $stmt->bindParam(':part_text', $part_text);
    $stmt->execute();
    $partResult = $stmt->fetch(PDO::FETCH_ASSOC);
    $part = $partResult['id_page'];
} else {
    $part = 0;
}

// Проверяем, является ли $part идентификатором верхнего уровня
$stmt = $pdo->prepare("SELECT COUNT(*) FROM page WHERE id_page = :part");
$stmt->bindParam(':part', $part);
$stmt->execute();
$count = $stmt->fetchColumn();

if ($count == 0) {
    // Если идентификатор верхнего уровня не найден, присваиваем ему значение 0
    $part = 0;
}

// Получаем текущее изображение страницы
$stmt = $pdo->prepare("SELECT image FROM page WHERE id_page=?");
$stmt->execute([$id_page]);
$currentImage = $stmt->fetchColumn();

// Проверяем, был ли загружен новый файл обложки страницы
if (!empty($_FILES['page_preview']['tmp_name'])) {
    // Проверяем тип файла обложки страницы
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $fileType = $_FILES['page_preview']['type'];

    if (!in_array($fileType, $allowedTypes)) {
        echo "Допускается загрузка только изображений в формате JPEG, JPG, PNG или GIF.";
        exit();
    }
    $previewData = file_get_contents($_FILES['page_preview']['tmp_name']);
} else {
    // Изображение не было загружено, сохраняем текущее изображение
    $previewData = $currentImage;
}

// Обновляем информацию о странице, включая новое изображение в формате BLOB
$stmt = $pdo->prepare("UPDATE page SET name=?, part=?, seo_title=?, text=?, image=? WHERE id_page=?");
if ($stmt->execute([$name, $part, $seo_title, $text, $previewData, $id_page])) {
    // Данные успешно обновлены

    // Добавляем запись в лог
    $logText = "Отредактирована страница: <a href='?url=site/template/edit_page&id=" . $id_page . "'>" . $name . "</a>";
    $stmt = $pdo->prepare("INSERT INTO logs (id_user, username, text, id_page, date) VALUES (:id_user, :username, :text, :id_page, NOW())");
    $stmt->bindParam(':id_user', $_SESSION['id_user']);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->bindParam(':text', $logText);
    $stmt->bindParam(':id_page', $id_page, PDO::PARAM_INT);
    $stmt->execute();

    $url = "pages_list";
    header("Location: ../../index.php?url=site/template/" . $url);
    exit();
} else {
    // Произошла ошибка
    echo "Произошла ошибка при обновлении данных.";
}
