<?php

echo $login = $_POST['login'];
echo $password = $_POST['password'];

if (isset($_POST['login']) && isset($_POST['password'])) {

    echo $login = $_POST['login'];
    echo $password = $_POST['password'];
    $password = md5($password);

    $stmt = $pdo->prepare("SELECT * FROM user WHERE login=:login AND password=:password LIMIT 1");
    $stmt->execute(['login' => $login, 'password' => $password]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['login'] = $row['login'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['telephone'] = $row['telephone'];
        $_SESSION['role'] = $row['id_role'];

        if (isset($_SESSION['id_user'])) {
            echo "<script>window.location.href='/admin'</script>";
            exit();
        } else {
            $errorMessage = 'Доступ закрыт.';
            echo "<script>window.location.href='/admin/error.php?message=" . urlencode($errorMessage) . "'</script>";
            die();
        }
    } else {
        $errorMessage = 'Такой логин с паролем не найдены в базе данных.';
        echo "<script>window.location.href='/admin/error.php?message=" . $errorMessage . "'</script>";
        echo 123;
        //exit();
    }
} else {
    echo "Error";
}
