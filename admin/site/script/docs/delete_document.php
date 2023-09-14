<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $document_id = $_GET['id'];
    $page_id = $_GET['id_page'];

    // Получаем имя файла из базы данных
    $stmt = $pdo->prepare("SELECT filename FROM page_docs WHERE id_doc = ? AND id_page = ?");
    $stmt->execute([$document_id, $page_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $filename = $row['filename'];

        // Удаляем запись из базы данных
        $stmt = $pdo->prepare("DELETE FROM page_docs WHERE id_doc = ?");
        $stmt->execute([$document_id]);

        // Удаляем файл из папки
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/admin/site/docs/' . $filename;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        echo '<script>
        localStorage.setItem("currentTab", "3");
        window.location.href = "../../../index.php?url=site/template/edit_page&id=' . $page_id . '#album";
      </script>';
        exit();
    } else {
        $error_message = 'Документ не найден.';
        echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
    }
}
