<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$id_product = $_GET['id'];

// Получение информации о фото для удаления
$stmt = $pdo->prepare("SELECT * FROM m_goods WHERE id_product=?");
$stmt->execute([$id_product]);
$res = $stmt->fetch(PDO::FETCH_ASSOC);

// Получение информации о фото для удаления
$stmt = $pdo->prepare("SELECT img FROM m_goods WHERE id_product = ?");
$stmt->execute([$id_product]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && !empty($row['img'])) {
    // Полный путь к файлу
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/img/fail/goods/' . $row['img'];

    // Удаление файла, если он существует
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

/* Удалять все связи с категориями которые есть в этом товаре */
$stmt = $pdo->prepare("DELETE FROM m_goods_categories WHERE id_product=?");
$stmt->execute([$id_product]);

// Удаление информации о продукте из базы данных
$stmt = $pdo->prepare("DELETE FROM m_goods WHERE id_product=? LIMIT 1");
$stmt->execute([$id_product]);

$name = $res['name'];
// Добавляем запись в лог
$logText = "Удален товар: $name";
$stmt = $pdo->prepare("INSERT INTO logs (id_user, username, text, date) VALUES (:id_user, :username, :text, NOW())");
$stmt->bindParam(':id_user', $_SESSION['id_user']);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->bindParam(':text', $logText);
$stmt->execute();

// Обновляем ссылки в логах
$newLogText = "Добавлен товар: " . $name;
$stmt = $pdo->prepare("UPDATE logs SET text = :newLogText WHERE id_product = :productId AND text LIKE 'Добавлен товар%'");
$stmt->bindParam(':newLogText', $newLogText);
$stmt->bindParam(':productId', $id_product, PDO::PARAM_INT);
$stmt->execute();

// Обновляем записи в логах
$newLogText = "Отредактирован товар: " . $name;
$stmt = $pdo->prepare("UPDATE logs SET text = :newLogText WHERE id_product = :productId AND text LIKE 'Отредактирован товар%'");
$stmt->bindParam(':newLogText', $newLogText);
$stmt->bindParam(':productId', $id_product, PDO::PARAM_INT);
$stmt->execute();

// Перенаправление пользователя на страницу со списком продуктов
$url = "products_list";
header("Location: ../../index.php?url=shop/template/" . $url);
exit();
