<? $id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM m_category WHERE id_category=?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC); ?>


<form action="shop/script/edit_category.php" method="POST" enctype="multipart/form-data">
    <div style="margin-bottom: 20px;">
        <label for="title" style="display: block;">Название категории: </label>
        <input type="text" name="name" style="width:30%" class="input" required value="<?php echo $row['name'] ?>">
        <input type="hidden" name="id_category" value="<?php echo htmlspecialchars($id); ?>">
    </div>
    <div style="margin-bottom: 20px; display:flex; gap:10px; align-items:center;">
        <label for="title" style="display: block;">Активная категория:</label>
        <input type="checkbox" name="status" <?php echo $row['status'] == 1 ? 'checked' : ''; ?>>
    </div>
    <div style="margin-bottom:30px;" class="image-uploader">
        <div class="preview-buttons">
            <? $stmt = $pdo->prepare("SELECT * FROM m_category WHERE id_category=?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC); ?>
            <label for="file-upload" class="upload-button" style="font-size:13px;">
                <i class="fa-solid fa-image icon-r"></i> Обложка категории
            </label>
            <? if (!empty($row['img'])) {
                echo '<a href="../admin/shop/script/clear_category_preview.php?id=' . $id . '&type=category" class="button-clear" onclick="return confirm(\'Вы уверены, что хотите удалить обложку?\')"><i class="fa-solid fa-trash icon-r" ></i>Очистить</a>';
            } ?>
        </div>
        <input id="file-upload" type="file" name="page_preview" class="input input-hide">

        <div>
            <? if (!empty($row['img'])) {
                $base64Image = base64_encode($row['img']);
                $imageSrc = "data:image/jpeg;base64,$base64Image";
                echo '<img id="preview-image" src="' . $imageSrc . '" class="image-preview">';
            } else {
                echo '<img id="preview-image" class="image-preview" style="display: none;">';
            } ?>
        </div>
    </div>
    <div style="display:flex; gap:30px;">
        <input type="submit" value="Сохранить" class="input-button" />
        <a href="?url=shop/template/categories_list" class="button-default">Назад</a>
        <a href="../admin/shop/script/delete_category.php?id=<?php echo $id; ?>" class="button-delete" onclick="return confirm('Вы уверены, что хотите удалить категорию?')"><i class="fa-solid fa-trash icon-r"></i>Удалить категорию</a>
    </div>
</form>

<style>
    .input-hide {
        display: none;
    }
</style>

<script>
    var previewImage = document.getElementById("preview-image");
    var fileUpload = document.querySelector('input[type="file"]');

    fileUpload.addEventListener("change", function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
        };

        reader.readAsDataURL(file);
    });

    // Отобразить выбранное изображение при загрузке страницы (если оно уже есть)
    if (fileUpload.files.length > 0) {
        var file = fileUpload.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
</script>