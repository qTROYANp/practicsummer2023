<h1 class="title">Добавление новой страницы</h1>

<div class="tabs">
    <input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
    <label for="tab-btn-1">Основная информация</label>
    <div id="content-1">
        <form action="site/script/add_page.php" method="POST" enctype="multipart/form-data">
            <div>
                <form action="site/script/add_page.php" method="POST" enctype="multipart/form-data">

                    <div style="display:flex; gap:30px; align-items:center;">
                        <div style="margin-bottom: 20px;">
                            <label for="title" style="display: block;">Имя страницы: </label>
                            <input type="text" name="title" style="margin-top:10px; width:600px;" class="input" required>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label for="title" style="display: block; margin-bottom:10px;">Родительская страница: </label>
                            <?php
                            $stmt = $pdo->prepare("SELECT name, id_page FROM page");
                            $stmt->execute();
                            $upperLevelIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // ...

                            if (!empty($upperLevelIDs)) {
                                echo '<datalist id="pagesList">';
                                echo '<option value="Нет"</option>';
                                foreach ($upperLevelIDs as $row) {
                                    echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                }
                                echo '</datalist>';

                                // Получите Parent_id из GET параметра
                                $parent = isset($_GET['parent_id']) ? $_GET['parent_id'] : null;

                                // Отобразите выбранный элемент, если Parent_id существует
                                $selectedPage = ""; // Инициализируйте выбранный элемент пустой строкой
                                if ($parent !== null) {
                                    foreach ($upperLevelIDs as $row) {
                                        if ($row['id_page'] == $parent) {
                                            $selectedPage = $row['name']; // Найдено совпадение, установите выбранный элемент
                                            break;
                                        }
                                    }
                                }

                                // Если $selectedPage пустое, установите его в "Нет"
                                if (empty($selectedPage)) {
                                    $selectedPage = "Нет";
                                }

                                // Прикрепите элемент datalist к полю ввода и установите выбранный элемент
                                echo '<input list="pagesList" name="part_text" class="input"  style="width:350px;" value="' . $selectedPage . '">';
                            }

                            // ...

                            ?>
                        </div>

                    </div>


                    <div>
                        <label for="text" style="display: block; margin-bottom: 10px;">Содержание страницы: </label>
                        <textarea id="editor" name="text" required></textarea>
                    </div>
            </div>
            <div>
                <div style="margin: 30px 0px;" class="image-uploader">
                    <label for="file-upload" class="upload-button" style="font-size:13px;">
                        <i class="fa-solid fa-image icon-r"></i> Обложка страницы
                    </label>
                    <input id="file-upload" type="file" name="page_preview" class="input input-hide" onchange="previewImage(event)">
                </div>
                <img id="preview-image" class="image-preview" <?php if (empty($imageData)) echo 'style="display: none;"'; ?>>
                <div class="input-item">
                    <input type="submit" value="Добавить" class="input-button input-form-button" />
                </div>
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

<script>
    function previewImage(event) {
        var input = event.target;
        var preview = document.getElementById('preview-image');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.setAttribute('src', e.target.result);
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>



<style>
    .ck-editor__editable {
        min-height: 400px;
    }

    .input-hide {
        display: none;
    }
</style>