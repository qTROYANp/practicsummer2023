<p class="title">Выбор категорий:</p>

<?php
$stmt = $pdo->prepare("SELECT COUNT(*) FROM m_category WHERE status = 1");
$stmt->execute();
// Получаем количество категорий
$cat_count = $stmt->fetchColumn();

if ($cat_count == 0) {
    echo '<p style="margin-bottom:30px !important;">Активных категорий нет</p> ';
    echo '<a href="?url=shop/template/categories_list" class="button-default">Редактор категорий</a>';
}


$stmt = $pdo->prepare("
                SELECT g.name AS product_name, c.name AS category_name
                FROM m_goods AS g
                JOIN m_goods_categories AS gc ON g.id_product = gc.id_product
                JOIN m_category AS c ON gc.id_category = c.id_category
                WHERE g.id_product = ?
            ");
$stmt->execute([$id]);

// Получаем все записи и сохраняем их в массив
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<form method="POST" action="shop/script/add_prod_cat.php" enctype="multipart/form-data">
    <div class="categories-list-wrapper">
        <?php
        $stmt = $pdo->query("SELECT id_category, name, part, status FROM m_category WHERE status = 1");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);



        $stmt = $pdo->prepare("SELECT id_category FROM m_goods_categories WHERE id_product = ?");
        $stmt->execute([$id]);
        $selected_categories_rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Преобразуем полученные строки в массив выбранных категорий (только ID)
        $selected_categories = array_map('intval', $selected_categories_rows);


        create_tree($categories, 0, $selected_categories);

        ?>

        <input type="hidden" name="id_product" value="<?php echo $id; ?>">

        <?php
        if (count($selected_categories) > 0) {
            $btn_name = "Сохранить категории";
        } else {
            $btn_name = "Добавить категории";
        }
        ?>
        <? if ($cat_count !== 0) {  ?>
            <button type="submit" class="input-button" style="height: 40px"> <?php echo $btn_name; ?></button>
        <? } ?>


    </div>
</form>

<?php
// Функция для рекурсивного вывода иерархического списка категорий
function create_tree($categories, $parentId = 0, $selected_categories = [])
{
    echo '<ul class="ul-treefree ul-dropfree">';
    foreach ($categories as $category) {
        if ($category['part'] == $parentId) {
            echo '<li>';

            $isChecked = in_array($category['id_category'], $selected_categories) ? 'checked' : '';

            // Выводим имя категории рядом с чекбоксом
            echo '<label>';
            echo '<input type="checkbox" class="checkbox" name="category_ids[]" value="' . $category['id_category'] . '" ' . $isChecked . '>';
            echo $category['name']; // Выводим имя категории
            echo '</label>';

            create_tree($categories, $category['id_category'], $selected_categories); // Рекурсивный вызов для формирования подкатегорий

            echo '</li>';
        }
    }
    echo '</ul>';
}

?>


<!--             Вывод выбранных категории в виде плашек -->
<?

if (count($rows) > 0) { ?>
    <p class="title" style="padding-top:20px;">Выбранные категорий:</p>
<? } ?>

<?php
// Выводим области категорий
echo '<div class="category-area" style="padding-bottom:20px;">'; // Открываем общий контейнер перед циклом

foreach ($rows as $row) {
    $category_name = $row['category_name'];
?>

    <div class="category-item">
        <?php echo htmlspecialchars($category_name); ?>
        <a href="../admin/shop/script/delete_prod_cat.php?id=<?php echo $id ?>&category-name=<?php echo urlencode($category_name); ?>" class="cancel-icon" onclick="return confirm('Вы уверены, что хотите удалить категорию?')">
            <i class="fa-solid fa-xmark icon-l"></i>
        </a>
    </div>

<?php
}

echo '</div>'; // Закрываем общий контейнер после цикла
?>