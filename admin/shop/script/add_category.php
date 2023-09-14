<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$category_name = strip_tags($_POST['category_name']);
$status = 0;

$stmt = $pdo->prepare("INSERT INTO m_category (name, status) VALUES (:name, :status)");
$stmt->bindParam(':name', $category_name);
$stmt->bindParam(':status', $status);
if ($stmt->execute()) {
    // Данные успешно вставлены
    // Добавляем запись в лог
    $logText = "Добавлена новая категория: $category_name";
    $stmt = $pdo->prepare("INSERT INTO logs (id_user, username, text, date) VALUES (:id_user, :username, :text, NOW())");
    $stmt->bindParam(':id_user', $_SESSION['id_user']);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->bindParam(':text', $logText);
    $stmt->execute();
    $url = "categories_list";
    header("Location: ../../index.php?url=shop/template/" . $url);
    exit();
} else {
    $error_message = 'Произошла ошибка при вставке данных.';
    echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
    exit();
}
