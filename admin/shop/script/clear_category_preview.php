<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Получаем id категории из параметров запроса
$id_cat = $_GET['id'];

// Проверяем, существует ли категория с указанным id
$stmt = $pdo->prepare("SELECT COUNT(*) FROM m_category WHERE id_category = ?");
$stmt->execute([$id_cat]);
$count = $stmt->fetchColumn();

if ($count == 0) {
    echo "Категория не найдена.";
    exit();
}

// Загрузка изображения "no-image"
$noImagePath = "../../img/no-image.png";

// Проверяем существование файла "no-image"
if (file_exists($noImagePath)) {
    // Используем функцию LOAD_FILE для чтения содержимого файла "no-image" в виде бинарных данных
    $noImageData = file_get_contents($noImagePath);

    // Обновляем запись категории в базе данных, заменяя изображение на "no-image"
    $stmt = $pdo->prepare("UPDATE m_category SET img = ? WHERE id_category = ?");
    $stmt->execute([$noImageData, $id_cat]);

    // Перенаправляем пользователя на страницу редактирования категории
    header("Location: ../../index.php?url=shop/template/edit_category&id=" . $id_cat);
} else {
    $error_message = 'Ошибка: Файл с изображением no-image не найден.';
    echo "<script>window.location.href='/admin/error.php?message=" . $error_message . "'</script>";
}
