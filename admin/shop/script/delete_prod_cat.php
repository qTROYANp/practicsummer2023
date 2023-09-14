<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['category-name'])) {
    // Получаем значения id товара и имени категории из параметров URL
    $product_id = $_GET['id'];
    $category_name = $_GET['category-name'];

    // Подготовленный запрос для удаления записи из таблицы m_goods_category
    $stmt = $pdo->prepare("DELETE FROM m_goods_categories WHERE id_product = ? AND id_category IN (SELECT id_category FROM m_category WHERE name = ?)");

    // Передаем значения в запрос и выполняем его
    $stmt->execute([$product_id, $category_name]);


    // Данные успешно обновлены
    echo '<script>
    localStorage.setItem("currentTab", "3");
    window.location.href = "/admin/index.php?url=shop/template/edit_product&id=' .  $product_id . '#categories";
  </script>';
    exit();
} else {
}
