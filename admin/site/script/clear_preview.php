<?php

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Получаем id страницы из параметров запроса
$id_page = $_GET['id'];

// Проверяем, существует ли страница с указанным id
$stmt = $pdo->prepare("SELECT COUNT(*) FROM page WHERE id_page = ?");
$stmt->execute([$id_page]);
$count = $stmt->fetchColumn();

if ($count == 0) {
    echo "Страница не найдена.";
    exit();
}

// Загрузка изображения "no-image"
$noImagePath = "../../img/no-image.png";

// Проверяем существование файла "no-image"
if (file_exists($noImagePath)) {
    // Читаем содержимое файла "no-image"
    $noImageData = file_get_contents($noImagePath);

    // Обновляем запись страницы в базе данных, заменяя изображение на "no-image"
    $stmt = $pdo->prepare("UPDATE page SET image = ? WHERE id_page = ?");
    $stmt->execute([$noImageData, $id_page]);

    // Перенаправление пользователя на страницу со списком страниц
    header("Location: ../../index.php?url=site/template/edit_page&id=" . $id_page);
} else {
    echo "Ошибка: Файл с изображением 'no-image' не найден.";
}
