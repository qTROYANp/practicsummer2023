<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Проверка наличия идентификатора картинки в параметрах запроса
if (isset($_GET['id_page'])) {
    $id_page = $_GET['id_page'];
}

if (isset($_GET['id'])) {
    $imageId = $_GET['id'];

    // Подготовка запроса на удаление картинки
    $stmt = $pdo->prepare("DELETE FROM page_album WHERE id_image = ?");
    $stmt->execute([$imageId]);

    if ($stmt->rowCount() > 0) {
        echo '<script>
                localStorage.setItem("currentTab", "2");
                window.location.href = "../../../index.php?url=site/template/edit_page&id=' . $id_page . '#album";
              </script>';
        exit();
    } else {
        $error_message = 'Ошибка при удалении картинки.';
        echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
    }
}
