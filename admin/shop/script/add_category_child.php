<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$id_category = $_GET['id'];
$status = 0;
$category_name = "Новая подкатегория";

$stmt = $pdo->prepare("INSERT INTO m_category (name, part, status) VALUES (:name, :part, :status)");
$stmt->bindParam(':name', $category_name);
$stmt->bindParam(':part', $id_category);
$stmt->bindValue(':status', $status);
if ($stmt->execute()) {
    // Данные успешно вставлены
    $url = "categories_list";
    header("Location: ../../index.php?url=shop/template/" . $url);
    exit();
} else {
    // Произошла ошибка
    echo "Произошла ошибка при вставке данных.";
    exit();
}
