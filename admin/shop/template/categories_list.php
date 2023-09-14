<?php

$stmt = $pdo->query("SELECT id_category, name, part, status FROM m_category");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="title">Редактор категорий</h1>

<div>
    <!-- Форма добавления новой категории -->
    <form action="shop/script/add_category.php" style="display:flex; gap:20px; align-items:center;" method="POST">
        <input type="text" class="input" placeholder="Введите название категории" style="height:20px" name="category_name" required>
        <input type="submit" value="Добавить" class="input-button" style="height:40px" />
    </form>
</div>

<div class="pages-list-wrapper">
    <?php create_tree($categories); ?>
</div>

<?php
// Функция для рекурсивного вывода иерархического списка страниц
function create_tree($categories, $parentId = 0)
{

    echo '<ul class="ul-treefree ul-dropfree">';
    foreach ($categories as $category) {
        if ($category['part'] == $parentId) {
            echo '<li>';

            if ($category['part'] !== 0) {
                $echoImg = '<img src="img/ico/page_on.jpg">';
            } else {
                $echoImg = '<img src="img/ico/cat.jpg">';
            }

            if ($category['name'] == '') {
                $category['name'] = 'Новая страница';
            }

            echo $echoImg . '<span style="position: relative; top: -5px;"><a href="?url=shop/template/edit_category&id=' . $category['id_category'] . '" title="Редактировать категорию">' . $category['name'] . ' (id ' . $category['id_category'] . ') (' . ($category['status'] == 1 ? 'Активна' : 'Не активна') . ')</a></span>';

            echo '<a href="../admin/shop/script/add_category_child.php?id=' . $category['id_category'] . '" class="add-child-page" title="Добавить дочернюю категорию">+</a>';
            create_tree($categories, $category['id_category']); // Рекурсивный вызов для формирования подстраниц

            echo '</li>';
        }
    }
    echo '</ul>';
}

?>