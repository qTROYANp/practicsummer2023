<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Получаем id страницы из параметров запроса
$id_page = $_GET['id'];

// Проверяем, существует ли страница с указанным id
$stmt = $pdo->prepare("SELECT COUNT(*) FROM m_goods WHERE id_product = ?");
$stmt->execute([$id_page]);
$count = $stmt->fetchColumn();

if ($count == 0) {
    echo "Товар не найден.";
    exit();
}

// Получение информации о фото для удаления
$stmt = $pdo->prepare("SELECT img FROM m_goods WHERE id_product = ?");
$stmt->execute([$id_page]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && !empty($row['img']) && $row['img'] !== 'no-image.jpg') {
    // Полный путь к файлу
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/files/img/goods/' . $row['img'];

    // Удаление файла, если он существует
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Обновляем запись страницы в базе данных, заменяя изображение на "no-image"
$stmt = $pdo->prepare("UPDATE m_goods SET img = 'no-image.jpg' WHERE id_product = ?");
$stmt->execute([$id_page]);

// Перенаправление пользователя на страницу со списком страниц
header("Location: ../../index.php?url=shop/template/edit_product&id=" . $id_page);
