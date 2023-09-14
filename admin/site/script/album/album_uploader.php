<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

if (!empty($_FILES['image']['tmp_name'])) {
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $fileType = $_FILES['image']['type'];

    if (!in_array($fileType, $allowedTypes)) {
        $error_message = 'Допускается загрузка только изображений в формате JPEG, JPG, PNG или GIF.';
        echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
        exit();
    }

    $imageData = file_get_contents($_FILES['image']['tmp_name']);

    // Получаем ID страницы
    $idPage = $_POST['id_page'];

    // Вставляем данные в базу данных
    $stmt = $pdo->prepare("INSERT INTO page_album (id_page, image) VALUES (:id_page, :image)");
    $stmt->bindParam(':id_page', $idPage, PDO::PARAM_INT);
    $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB); // Указываем тип параметра как BLOB

    if ($stmt->execute()) {
        echo '<script>
                localStorage.setItem("currentTab", "2");
                window.location.href = "../../../index.php?url=site/template/edit_page&id=' . $idPage . '#album";
              </script>';
        exit();
    } else {
        $error_message = 'Ошибка при сохранении изображения.';
        echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
        exit();
    }
}
