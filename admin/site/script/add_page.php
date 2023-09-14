<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Получаем данные из формы
$name = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
$text = $_POST['text'];

$part_text = isset($_POST['part_text']) ? $_POST['part_text'] : '';

$seo_title = htmlspecialchars($_POST['seo_title']);

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

// Загрузка изображения
$allowedTypes = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp');

// Проверяем, было ли выбрано изображение
if (!empty($_FILES['page_preview']['tmp_name'])) {
    $fileType = $_FILES['page_preview']['type'];

    if (!in_array($fileType, $allowedTypes)) {
        $error_message = 'Допускается загрузка только изображений в формате JPEG, JPG, PNG или GIF.';
        echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
        exit();
    }

    // Загрузить новое изображение
    $previewData = file_get_contents($_FILES['page_preview']['tmp_name']);
} else {
    // Если файл не был загружен, загрузить изображение "no-image"
    $noImagePath = "../../img/no-image.png";

    // Проверяем существование файла "no-image"
    if (file_exists($noImagePath)) {
        // Читаем содержимое файла "no-image"
        $noImageData = file_get_contents($noImagePath);

        // Присваиваем содержимое файла переменной $previewData
        $previewData = $noImageData;
    } else {
        // В случае, если файла "no-image" не существует, присваиваем пустое значение переменной $previewData
        $previewData = '';
    }
}



// Вставляем данные в базу данных
$stmt = $pdo->prepare("INSERT INTO page (name, seo_title, text, part, image, date) VALUES (:name, :seo_title, :text, :part, :image, CURDATE())");

$stmt->bindParam(':name', $name);
$stmt->bindParam(':seo_title', $seo_title);

$stmt->bindParam(':text', $text);
$stmt->bindParam(':part', $part);
$stmt->bindParam(':image', $previewData, PDO::PARAM_LOB); // Указываем тип параметра как BLOB

if ($stmt->execute()) {
    // Данные успешно вставлены
    $lastInsertedPageId = $pdo->lastInsertId(); // Получаем последний вставленный идентификатор страницы

    // Вставляем данные в таблицу логов
    $logText = "Добавлена страница: <a href='?url=site/template/edit_page&id=" . $lastInsertedPageId . "'>" . $name . "</a>";
    // Добавляем id_page в лог
    $stmt = $pdo->prepare("INSERT INTO logs (id_user, username, text, id_page, date) VALUES (:id_user, :username, :text, :id_page, NOW())");
    $stmt->bindParam(':id_user', $_SESSION['id_user']);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->bindParam(':text', $logText);
    $stmt->bindParam(':id_page', $lastInsertedPageId, PDO::PARAM_INT);
    $stmt->execute();

    $url = "pages_list";
    header("Location: ../../index.php?url=site/template/" . $url);
    exit();
} else {
    // Произошла ошибка
    echo "Произошла ошибка при вставке данных.";
}
