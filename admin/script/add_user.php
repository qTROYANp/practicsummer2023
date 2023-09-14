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

$username = $_POST['username'];
$login = $_POST['login'];
$password = $_POST['password'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$role = $_POST['role']; // Получаем выбранную роль из формы

// Проверка наличия всех необходимых данных
if (!empty($username) && !empty($login) && !empty($password) && !empty($role)) {

    // Проверка, занят ли логин
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE login = ?");
    $stmt->execute([$login]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $error_message = 'Логин уже занят. Пожалуйста, выберите другой логин.';
        echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO user (username, login, password, email, telephone, id_role, date) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$username, $login, md5($password), $email, $telephone, $role]);

        // Перенаправление пользователя на страницу с информацией о списке пользователей
        header("Location: /admin/index.php?url=users_list");
        exit();
    }
} else {
}
