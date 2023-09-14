<?php
$stmt = $pdo->query("SELECT * FROM m_goods");
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$where = '';

if (!empty($searchQuery)) {
    $where = "WHERE name LIKE :search";
}

$stmt = $pdo->prepare("SELECT * FROM m_goods $where");
if (!empty($searchQuery)) {
    $stmt->bindValue(':search', '%' . $searchQuery . '%');
}
$stmt->execute();

$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
    function submitForm() {
        var searchValue = document.getElementById('search').value;
        var url = new URL(window.location.href);
        url.searchParams.set('search', searchValue);
        window.location.href = url.toString();
    }
</script>

<h1 class="title">Список товаров</h1>

<div style="display: flex; gap:30px; align-items: center; justify-content:space-between">
    <div>
        <form onsubmit="submitForm(); return false;">
            <div style="display: flex; gap:30px; align-items: center; justify-content:space-between">
                <div>
                    <input type="text" id="search" name="search" placeholder="Введите имя товара" class="input" style="width: 300px; height:16px;" value="<?php echo htmlspecialchars($searchQuery); ?>">
                </div>
                <div>
                    <button type="submit" class="input-button"><i class="fa-solid fa-magnifying-glass icon-r"></i>Найти</button>
                </div>
                <div>
                    <a href="?url=shop/template/add_product" class="button-a"><i class="fa-solid fa-plus icon-r"></i>Добавить товар</a>
                </div>
                <div>
                    <a href="?url=shop/template/categories_list" class="button-a"><i class="fa-solid fa-pen icon-r"></i>Редактор категорий</a>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="products-table">
    <table style="margin-top: 40px;">
        <thead>
            <tr>
                <th>Изображение</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Описание</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product as $item) : ?>
                <tr>
                    <td>
                        <?php if (!empty($item['img'])) {
                            $imageSrc = '/files/img/goods/' . $item['img'];
                        ?>
                            <a href="?url=shop/template/edit_product&id=<?php echo $item['id_product']; ?>">
                                <img src="<?php echo $imageSrc; ?>" alt="<?php echo $item['name']; ?>" class="product-image">
                            </a>
                        <?php } else { ?>
                            <p>Нет изображения</p>
                        <?php } ?>
                    </td>

                    <td>
                        <a href="?url=shop/template/edit_product&id=<?php echo $item['id_product']; ?>">
                            <?php echo $item['name']; ?>
                        </a>
                    </td>
                    <td><?php echo $item['price']; ?> ₽</td>
                    <td>
                        <?php
                        $trimmedText = mb_substr(strip_tags($item['text']), 0, 250, 'UTF-8');
                        echo rtrim($trimmedText);
                        if (mb_strlen($item['text'], 'UTF-8') > 250) {
                            echo '...';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<style>
    .products-list a {
        text-decoration: none;
        display: block;
    }

    .products-list {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        padding-top: 40px;
    }

    .card {
        position: relative;
        box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.15);
        border-radius: 12px;
    }

    .card .card-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 12px;
        background-size: cover;
        background-repeat: no-repeat;
        transition: opacity 0.2s ease;
        background-position: center;
        filter: brightness(80%);
    }

    .card .card-body {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        height: 300px;
        width: 300px;
        transition: opacity 0.2s ease;
        cursor: pointer;
        position: relative;
        padding: 30px;
    }

    .card .card-body-title {
        color: white;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 20px;
    }

    .product-name {
        font-weight: 900;
        font-size: 20px;
    }

    .card p {
        color: white;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .card:hover .card-button {
        opacity: 1;
    }

    .card:hover p {
        opacity: 1;
    }

    .card .card-image:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        opacity: 0;
        transition: opacity 0.2s ease;
        border-radius: 12px;
    }

    .card:hover .card-image:before {
        opacity: 1;
    }

    .product-price {
        color: white;
        font-weight: bold;
        background-color: #24a698;
        width: fit-content;
        border-radius: 5px;
        padding: 10px;
    }

    .category-name {
        color: white;
        font-weight: bold;
        background-color: #24a698;
        width: fit-content;
        border-radius: 5px;
        padding: 10px;
    }

    .products-table {
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        text-align: left;
    }

    .product-image {
        max-width: 25s0px;
        max-height: 250px;
        border-radius: 10px;
    }
</style>