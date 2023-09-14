<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $productName = htmlspecialchars($_POST['product_name'], ENT_QUOTES, 'UTF-8');
    $text = $_POST['text'];
    $price = $_POST['product_price'];

    // Загрузка изображения
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/files/img/goods/'; // Папка для загрузки изображений
    $allowedTypes = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp');

    // Проверяем, было ли выбрано изображение
    if (!empty($_FILES['page_preview']['tmp_name'])) {
        $fileType = $_FILES['page_preview']['type'];

        if (!in_array($fileType, $allowedTypes)) {
            echo "Допускается загрузка только изображений в формате JPEG, JPG, PNG или GIF.";
            exit();
        }

        // Генерация уникального имени файла
        $fileName = uniqid() . '_' . $_FILES['page_preview']['name'];
        $filePath = $uploadDir . $fileName;

        // Сохранение изображения в папку
        if (move_uploaded_file($_FILES['page_preview']['tmp_name'], $filePath)) {
            // Вставляем данные в базу данных
            $stmt = $pdo->prepare("INSERT INTO m_goods (name, price, img, text) VALUES (:name, :price, :img, :text)");

            $stmt->bindParam(':name', $productName);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':img', $fileName); // Используйте bindParam для передачи значения
            $stmt->bindParam(':text', $text);

            if ($stmt->execute()) {
                // Данные успешно вставлены
                $url = "products_list";
                header("Location: ../../index.php?url=shop/template/" . $url);
                exit();
            } else {
                // Произошла ошибка
                echo "Произошла ошибка при вставке данных.";
                exit();
            }
        } else {
            echo "Произошла ошибка при загрузке файла.";
            exit();
        }
    } else {
        // Если файл не был загружен, загрузить имя файла "no-image"
        $noImageFileName = "no-image.jpg";

        // Вставляем данные в базу данных
        $stmt = $pdo->prepare("INSERT INTO m_goods (name, price, img, text) VALUES (:name, :price, :img, :text)");

        $stmt->bindParam(':name', $productName);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $noImageFileName); // Используйте bindParam для передачи значения
        $stmt->bindParam(':text', $text);

        if ($stmt->execute()) {
            // Данные успешно вставлены
            // Добавляем запись в лог
            $lastInsertedPageId = $pdo->lastInsertId();
            $logText = "Добавлен товар: <a href='?url=shop/template/edit_product&id=" . $lastInsertedPageId . "'>" . $productName . "</a>";
            $stmt = $pdo->prepare("INSERT INTO logs (id_user, username, text, date, id_product) VALUES (:id_user, :username, :text, NOW(), :id_product)");
            $stmt->bindParam(':id_user', $_SESSION['id_user']);
            $stmt->bindParam(':username', $_SESSION['username']);
            $stmt->bindParam(':text', $logText);
            $stmt->bindParam(':id_product', $lastInsertedPageId);
            $stmt->execute();
            $url = "products_list";
            header("Location: ../../index.php?url=shop/template/" . $url);
            exit();
        } else {
            // Произошла ошибка
            echo "Произошла ошибка при вставке данных.";
            exit();
        }
    }
}
