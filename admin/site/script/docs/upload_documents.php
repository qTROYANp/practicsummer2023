<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$id = $_GET['id']; // Получаем id страницы из URL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Путь к папке для сохранения загруженных документов
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/admin/site/docs';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowed_extensions = array('pdf', 'doc', 'docx', 'txt'); // Разрешенные расширения

    if (!empty($_FILES['documents']['name'][0])) {
        foreach ($_FILES['documents']['name'] as $key => $name) {
            $tmp_name = $_FILES['documents']['tmp_name'][$key];
            $document_name = $_POST['document_names'][$key]; // Получаем имя документа
            $file_extension = pathinfo($name, PATHINFO_EXTENSION); // Расширение файла
            $file_name = uniqid() . '.' . $file_extension; // Создаем уникальное имя файла
            $file_path = $uploadDir . '/' . $file_name;

            if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                $error_message = 'Загрузка файлов такого типа запрещена.';
                echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
                exit();
            }

            // Перемещаем файл в указанную папку
            move_uploaded_file($tmp_name, $file_path);

            // Записываем информацию о документе в базу данных
            $stmt = $pdo->prepare("INSERT INTO page_docs (id_page, name, filename) VALUES (?, ?, ?)");
            $stmt->execute([$id, $document_name, $file_name]);
        }

        echo '<script>
    localStorage.setItem("currentTab", "3");
    window.location.href = "../../../index.php?url=site/template/edit_page&id=' . $id . '#album";
  </script>';
        exit();
    } else {
        $error_message = 'Выберите документы для загрузки.';
        echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
        exit();
    }
}
