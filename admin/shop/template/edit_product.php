<?php

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM m_goods WHERE id_product=?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<form action="shop/script/edit_product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
    <div style="display:flex; align-items:center; justify-content:space-between;">
        <h1 class="title">Редактирование: <span><span><? echo $row['name'] ?></span><a href="" target="_blank" style="color:#3366BB ; font-size:14px; margin-left:10px;">(Перейти в карточку товара)</a></span></h1>
        <div style="display:flex; gap:30px;">
            <input type="submit" value="Сохранить" class="input-button" />
            <a href="?url=shop/template/products_list" class="button-default">Назад</a>
            <a href="../admin/shop/script/delete_product.php?id=<?php echo $id; ?>" class="button-delete" onclick="return confirm('Вы уверены, что хотите удалить товар?')"><i class="fa-solid fa-trash icon-r"></i>Удалить товар</a>
        </div>
    </div>

    <div class="tabs">
        <input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
        <label for="tab-btn-1">Основная информация</label>
        <input type="radio" name="tab-btn" id="tab-btn-2" value="">
        <label for="tab-btn-2">Альбом</label>
        <input type="radio" name="tab-btn" id="tab-btn-3" value="">
        <label for="tab-btn-3">Категории</label>
        <div id="content-1">
            <?
            include 'shop/template/tabs/content-1.php';
            ?>
        </div>
        <div id="content-2">
            <?
            include 'shop/template/tabs/content-2.php';
            ?>
        </div>
        <div id="content-3">
            <?
            include 'shop/template/tabs/content-3.php';
            ?>
        </div>

    </div>
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

        var currentTab = localStorage.getItem('currentTab');
        if (currentTab) {
            var tabBtn = document.getElementById('tab-btn-' + currentTab);
            if (tabBtn) {
                tabBtn.checked = true;
            }
        }

        var tabButtons = document.querySelectorAll('input[name="tab-btn"]');
        tabButtons.forEach(function(btn) {
            btn.addEventListener('change', function() {
                localStorage.setItem('currentTab', this.getAttribute('value'));
            });
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