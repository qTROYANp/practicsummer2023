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

$id_user = $_POST['id_user'];

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Проверка, был ли отправлен запрос на обновление
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $username = $_POST['username'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $role = $_POST['role'];

    // Проверка, был ли введен новый пароль
    $newPassword = $_POST['password'];
    if (!empty($newPassword)) {
        $passwordHash = md5($newPassword); // Если новый пароль указан, хешируем его
        // Выполните обновление данных пользователя, включая новый пароль
        $stmt = $pdo->prepare("UPDATE user SET username=?, login=?, password=?, email=?, telephone=?, id_role=? WHERE id_user=?");
        $stmt->execute([$username, $login, $passwordHash, $email, $telephone, $role, $id_user]);
    } else {
        // Если новый пароль не указан, оставьте текущий пароль без изменений
        $stmt = $pdo->prepare("UPDATE user SET username=?, login=?, email=?, telephone=?, id_role=? WHERE id_user=?");
        $stmt->execute([$username, $login, $email, $telephone, $role, $id_user]);
    }

    // Перенаправление пользователя на страницу с информацией о списке пользователей
    header("Location: /admin/index.php?url=users_list");
    exit();
}
