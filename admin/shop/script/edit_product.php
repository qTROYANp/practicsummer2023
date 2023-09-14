<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $productName = htmlspecialchars($_POST['product_name'], ENT_QUOTES, 'UTF-8');
    $text = $_POST['text'];
    $price = $_POST['product_price'];

    // Загрузка изображения
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/files/img/goods/'; // Папка для сохранения изображений
    $allowedTypes = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp');

    if (!empty($_FILES['page_preview']['tmp_name'])) {
        $fileType = $_FILES['page_preview']['type'];

        if (!in_array($fileType, $allowedTypes)) {
            $error_message = 'Допускается загрузка только изображений в формате JPEG, JPG, PNG или GIF.';
            echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
            exit();
        }

        // Генерация уникального имени файла
        $fileName = uniqid() . '_' . $_FILES['page_preview']['name'];
        $filePath = $uploadDir . $fileName;

        // Сохранение изображения в папку
        if (move_uploaded_file($_FILES['page_preview']['tmp_name'], $filePath)) {
            // Обновление данных в базе данных
            $stmt = $pdo->prepare("UPDATE m_goods SET name = :name, price = :price, img = :img, text = :text WHERE id_product = :id");

            $stmt->bindParam(':name', $productName);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':img', $fileName); // Сохраняем только имя файла в базе данных
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                // Данные успешно обновлены
                // Добавляем запись в лог
                $logText = "Отредактирован товар: $productName";
                $stmt = $pdo->prepare("INSERT INTO logs (id_user, username, text, date) VALUES (:id_user, :username, :text, NOW())");
                $stmt->bindParam(':id_user', $_SESSION['id_user']);
                $stmt->bindParam(':username', $_SESSION['username']);
                $stmt->bindParam(':text', $logText);
                $stmt->execute();

                $url = "products_list";
                header("Location: ../../index.php?url=shop/template/edit_product&id=" . $id);
                exit();
            } else {
                // Произошла ошибка
                echo "Произошла ошибка при обновлении данных.";
                exit();
            }
        } else {
            $error_message = 'Произошла ошибка при загрузке файла.';
            echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
            exit();
        }
    } else {
        // Если новое изображение не было выбрано
        $stmt = $pdo->prepare("UPDATE m_goods SET name = :name, price = :price, text = :text WHERE id_product = :id");

        $stmt->bindParam(':name', $productName);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Данные успешно обновлены
            // Добавляем запись в лог
            $logText = "Отредактирован товар: $productName";
            $stmt = $pdo->prepare("INSERT INTO logs (id_user, username, text, date) VALUES (:id_user, :username, :text, NOW())");
            $stmt->bindParam(':id_user', $_SESSION['id_user']);
            $stmt->bindParam(':username', $_SESSION['username']);
            $stmt->bindParam(':text', $logText);
            $stmt->execute();
            $url = "products_list";
            header("Location: ../../index.php?url=shop/template/edit_product&id=" . $id);
            exit();
        } else {
            // Произошла ошибка
            echo "Произошла ошибка при обновлении данных.";
            exit();
        }
    }
}
