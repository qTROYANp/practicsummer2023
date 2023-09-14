<h1 class="title">Добавление нового товара</h1>
<div class="tabs">
    <input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
    <label for="tab-btn-1">Информация о товаре</label>
    <div id="content-1">
        <form action="shop/script/add_product.php" method="POST" enctype="multipart/form-data">
            <div>
                <div style="display:flex; gap:30px; align-items:center;">
                    <div style="margin-bottom: 20px;">
                        <label for="title" style="display: block;">Название товара: </label>
                        <input type="text" name="product_name" style="margin-top:10px; width:600px;" class="input" required>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label for="text" style="display: block; margin-bottom: 10px;">Цена товара (₽): </label>
                        <input type="number" name="product_price" style="margin-top:10px;" class="input" required>
                    </div>
                </div>
                <div>
                    <label for="text" style="display: block; margin-bottom: 10px;">Описание товара: </label>
                    <textarea id="editor" name="text" required></textarea>
                </div>
                <div>
                    <div style="margin-top:30px;" class="image-uploader">
                        <label for="file-upload" class="upload-button" style="font-size:13px;">
                            <i class="fa-solid fa-image icon-r"></i> Обложка товара
                        </label>
                        <input id="file-upload" type="file" name="page_preview" class="input input-hide" onchange="previewImage(event)">
                    </div>
                    <div style="margin-top:20px;">
                        <img id="preview-image" class="image-preview" <?php if (empty($imageData)) echo 'style="display: none;"'; ?>>
                    </div>
                </div>
            </div>
            <div class="input-item" style="margin-top:30px;">
                <input type="submit" value="Добавить" class="input-button input-form-button" />
            </div>
        </form>

    </div>
</div>

<script src="/admin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace("editor", {
        "filebrowserUploadMethod": 'form',
        "extraPlugins": 'uploadimage',
        "filebrowserBrowseUrl": "/admin/ckeditor/browse.php?type=files",
        "filebrowserImageBrowseUrl": "/admin/ckeditor/browse.php?type=images",
        "filebrowserFlashBrowseUrl": "/admin/ckeditor/browse.php?type=flash",
        "filebrowserUploadUrl": "/admin/ckeditor/upload.php?type=files",
        "filebrowserImageUploadUrl": "/admin/ckeditor/upload.php?type=images",
        "filebrowserFlashUploadUrl": "/admin/ckeditor/upload.php?type=flash"
    });

    document.getElementById("file-upload").addEventListener("change", function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var previewImage = document.getElementById("preview-image");
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
        };

        reader.readAsDataURL(file);
    });
</script>

<style>
    .ck-editor__editable {
        min-height: 400px;
    }

    .input-hide {
        display: none;
    }
</style>