<form action="shop/script/add_product.php" method="POST" enctype="multipart/form-data">

    <div>
        <div style="margin-bottom: 20px;">
            <label for="title" style="display: block;">Название товара: </label>
            <input type="text" name="product_name" style="width:99%;" class="input" required value="<?php echo $row['name'] ?>">
        </div>
        <div style="margin-bottom: 20px;">
            <label for="text" style="display: block; margin-bottom: 10px;">Цена товара (₽): </label>
            <input type="number" name="product_price" style="width:99%" class="input" required value="<?php echo $row['price'] ?>">
        </div>
        <div>
            <? $stmt = $pdo->prepare("SELECT * FROM m_goods WHERE id_product=?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC); ?>
            <label for="text" style="display: block; margin-bottom: 10px;">Описание товара: </label>
            <textarea id="editor" name="text" required><?php echo $row['text'] ?></textarea>
        </div>
    </div>

    <div style="margin: 30px 0px; width:30%;" class="image-uploader">
        <div>
            <?php if (!empty($row['img'])) : ?>
                <img id="preview-image" src="/files/img/goods/<?php echo $row['img']; ?>" class="image-preview">
            <?php else : ?>
                <img id="preview-image" style="max-width: 300px; margin-top: 30px; display: none; border-radius: 6px;" class="image-preview">
            <?php endif; ?>
        </div>
        <div class="preview-buttons">
            <? $stmt = $pdo->prepare("SELECT * FROM m_goods WHERE id_product=?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC); ?>
            <label for="file-upload" class="upload-button" style="font-size:13px;">
                <i class="fa-solid fa-image icon-r"></i> Обложка товара
            </label>
            <? if (!empty($row['img'])) {
                echo '                <a href="../admin/shop/script/clear_preview.php?id=' . $id . '" class="button-clear" onclick="return confirm(\'Вы уверены, что хотите удалить обложку?\')"><i class="fa-solid fa-trash icon-r" ></i>Очистить</a>';
            } ?>
        </div>
        <input id="file-upload" type="file" name="page_preview" class="input input-hide">

    </div>
</form>