<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id_category'];
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $status = isset($_POST['status']) ? 1 : 0;

    // Загрузка изображения
    $allowedTypes = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp');

    // Проверяем, было ли выбрано новое изображение
    if (!empty($_FILES['page_preview']['tmp_name'])) {
        $fileType = $_FILES['page_preview']['type'];

        if (!in_array($fileType, $allowedTypes)) {
            echo "Допускается загрузка только изображений в формате JPEG, JPG, PNG или GIF.";
            exit();
        }

        // Загрузить новое изображение
        $imageData = file_get_contents($_FILES['page_preview']['tmp_name']);

        // Обновляем информацию о товаре в базе данных, включая новое изображение
        $stmt = $pdo->prepare("UPDATE m_category SET name = :name, status = :status, img = :img WHERE id_category = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':img', $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Данные успешно обновлены
            $url = "categories_list";
            header("Location: ../../index.php?url=shop/template/" . $url);
            exit();
        } else {
            // Произошла ошибка при обновлении данных
            echo "Произошла ошибка при обновлении данных.";
            exit();
        }
    } else {
        // Если файл не был загружен, обновляем данные без изменения изображения
        $stmt = $pdo->prepare("UPDATE m_category SET name = :name, status = :status WHERE id_category = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Данные успешно обновлены
            header("Location: ../../index.php?url=shop/template/edit_category&id=" . $id);
            exit();
        } else {
            // Произошла ошибка при обновлении данных
            echo "Произошла ошибка при обновлении данных.";
            exit();
        }
    }
}
