<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

/* Получаем id продукта */

if (!empty($_POST['id_product'])) {
    $product_id = $_POST['id_product'];
} else {
    exit('Не передан id продукта');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['category_ids'])) {

        // Удаляем все текущие категории товара из таблицы m_goods_categories
        $stmt_delete = $pdo->prepare("DELETE FROM m_goods_categories WHERE id_product = ?");
        $stmt_delete->execute([$product_id]);

        // Получаем выбранные id категорий из чекбоксов
        $selected_categories = $_POST['category_ids'];

        // Перебираем выбранные категории и добавляем их в базу данных
        foreach ($selected_categories as $category_id) {
            // Подготовленный запрос для добавления записей в таблицу m_goods_categories
            $stmt_insert = $pdo->prepare("INSERT INTO m_goods_categories (id_product, id_category) VALUES (:id_product, :id_category)");
            // Приводим значение категории к типу INTEGER
            $category_id = (int)$category_id;
            $stmt_insert->bindParam(':id_product', $product_id);
            $stmt_insert->bindParam(':id_category', $category_id);
            // Выполняем запрос на вставку записи
            $stmt_insert->execute();
        }


        // Данные успешно обновлены
        echo '<script>
        localStorage.setItem("currentTab", "3");
        window.location.href = "/admin/index.php?url=shop/template/edit_product&id=' .  $product_id . '#categories";
        </script>';
        exit();
    } else {
        $stmtDeleteCategories = $pdo->prepare("DELETE FROM m_goods_categories WHERE id_product = :id");
        $stmtDeleteCategories->bindParam(':id', $product_id);
        $stmtDeleteCategories->execute();
        $url = "products_list";
        header("Location: ../../index.php?url=shop/template/edit_product&id=" . $product_id);
        exit();
    }
}
