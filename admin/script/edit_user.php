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

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$id_user = $_SESSION['id_user'];
$username = $_POST['username'];
$login = $_POST['login'];

$new_password = $_POST['password']; // Новый пароль

$save_role = $_SESSION['role'];


if (!empty($new_password)) {
    $password = md5($new_password); // Хешируем новый пароль
} else {
    $password = $_SESSION['password'];
}

$email = $_POST['email'];
$telephone = $_POST['telephone'];

// Проверка, был ли изменен пароль
if ($_SESSION['password'] !== $password) {
    $logTextPassword = "Смена пароля пользователя: " . $_SESSION['username'];

    // Добавление записи о смене пароля в логи
    $stmtPasswordLog = $pdo->prepare("INSERT INTO logs (id_user, username, text, date) VALUES (:id_user, :username, :logText, NOW())");
    $stmtPasswordLog->bindParam(':id_user', $_SESSION['id_user']);
    $stmtPasswordLog->bindParam(':username', $_SESSION['username']);
    $stmtPasswordLog->bindParam(':logText', $logTextPassword);
    $stmtPasswordLog->execute();
}

// Проверка, было ли изменено имя пользователя
if ($_SESSION['username'] !== $username) {
    $usernameLogText = "Смена имени: " . $_SESSION['username'] . " на " . $username;

    // Добавление записи о смене имени в логи
    $stmtUsernameLog = $pdo->prepare("INSERT INTO logs (id_user, username, text, date) VALUES (:id_user, :username, :logText, NOW())");
    $stmtUsernameLog->bindParam(':id_user', $_SESSION['id_user']);
    $stmtUsernameLog->bindParam(':username', $_SESSION['username']);
    $stmtUsernameLog->bindParam(':logText', $usernameLogText);
    $stmtUsernameLog->execute();
}

// Обновление информации пользователя в базе данных
$stmt = $pdo->prepare("UPDATE user SET username=?, login=?, password=?, email=?, telephone=? WHERE id_user=?");
$stmt->execute([$username, $login, $password, $email, $telephone, $id_user]);

// Обновление сессионных данных
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
$_SESSION['login'] = $login;
$_SESSION['email'] = $email;
$_SESSION['telephone'] = $telephone;

$_SESSION['role'] = $save_role;

// Перенаправление пользователя на страницу с информацией о пользователе
header("Location: /admin/index.php?url=edit_user");
exit();
