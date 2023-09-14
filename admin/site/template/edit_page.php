<?php

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM page WHERE id_page=?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<form action="site/script/edit_page.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
    <div style="display:flex; align-items:center; justify-content:space-between;">
        <h1 class="title">Редактирование страницы <span><a href="/index.php?url=page&id=<?php echo $id; ?>" target="_blank" style="color:#3366BB ; font-size:14px">(Перейти на страницу)</a></span></h1>
        <div style="display:flex; gap:30px;">
            <input type="submit" value="Сохранить" class="input-button" />
            <a href="?url=site/template/pages_list" class="button-default">Назад</a>
            <a href="../admin/site/script/delete_page.php?id=<?php echo $id; ?>" class="button-delete" onclick="return confirm('Вы уверены, что хотите удалить страницу?')"><i class="fa-solid fa-trash icon-r"></i>Удалить страницу</a>
        </div>
    </div>
    <div class="tabs">
        <input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
        <label for="tab-btn-1">Основная информация</label>
        <input type="radio" name="tab-btn" id="tab-btn-2" value="">
        <label for="tab-btn-2">Альбом</label>
        <input type="radio" name="tab-btn" id="tab-btn-3" value="">
        <label for="tab-btn-3">Документы</label>
        <div id="content-1">
            <h2 class="title">Редактирование основной информации о странице</h2>

            <div style="margin-bottom: 20px;">
                <label for="title" style="display: block;">Имя страницы: </label>
                <input type="text" name="name" class="input" style="width:98%" required style="display: block; width:100%;" value="<?php echo $row['name'] ?>">
            </div>
            <div style="margin-bottom: 20px;">
                <label for="title" style="display: block;">Краткое описание страницы: </label>
                <input type="text" name="seo_title" style="width:98%;" class="input" value="<?php echo $row['seo_title'] ?>">
            </div>
            <div style="margin-bottom: 20px;">
                <label for="title" style="display: block;">Родительская страница: </label>

                <?php
                $stmt = $pdo->prepare("SELECT name, id_page FROM page");
                $stmt->execute();
                $upperLevelIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($upperLevelIDs)) { /* Выбор родительской страницы */
                    echo '<datalist id="pagesList">';
                    echo '<option value="Нет"></option>'; // Добавляем пункт "Нет"
                    foreach ($upperLevelIDs as $result) {
                        echo '<option value="' . $result['name'] . '">' . $result['name'] . '</option>';
                    }
                    echo '</datalist>';

                    $stmt = $pdo->prepare("SELECT name FROM page WHERE id_page = :part");
                    $stmt->bindParam(':part', $row['part']);
                    $stmt->execute();
                    $part_name = $stmt->fetch(PDO::FETCH_ASSOC);

                    $default_value = ($row['part'] == 0) ? 'Нет' : $part_name['name'];

                    echo '<input list="pagesList" name="part_text" style="width:98%;" class="input" style="width:100%" value="' . $default_value . '">';
                }


                ?>
            </div>
            <div>
                <label for="text" style="display: block; margin-bottom: 10px;">Содержание страницы: </label>
                <textarea id="editor" name="text" required><?php echo $row['text'] ?> </textarea>
            </div>
            <div style="margin: 30px 0px;" class="image-uploader">
                <div class="preview-buttons">
                    <label for="file-upload" class="upload-button" style="font-size: 13px;">
                        <i class="fa-solid fa-image icon-r"></i> Обложка страницы
                    </label>
                    <?php if (!empty($row['image'])) : ?>
                        <a href="../admin/site/script/clear_preview.php?id=<?php echo $id; ?>" class="button-clear" onclick="return confirm('Вы уверены, что хотите удалить обложку?')">
                            <i class="fa-solid fa-trash icon-r"></i> Очистить
                        </a>
                    <?php endif; ?>
                </div>
                <input id="file-upload" type="file" name="page_preview" class="input input-hide">
                <div>
                    <?php if (!empty($row['image'])) : ?>
                        <img id="preview-image" src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Обложка страницы" class="image-preview">
                    <?php else : ?>
                        <img id="preview-image" class="image-preview" style="display: none;">
                    <?php endif; ?>
                </div>
            </div>
</form>
</div>
<div id="content-2">
    <h2 class="title">Выберите и загрузите изображения</h2>
    <? $idPage = isset($_GET['id_page']) ? $_GET['id_page'] : '';
    ?>

    <form id="image-upload-form" enctype="multipart/form-data" action="site/script/album/album_uploader.php" method="POST">
        <div style="display:flex; gap:20px; align-items:center; padding-bottom:20px;">
            <div>
                <input type="hidden" name="id_page" value="<?php echo $id; ?>">

                <label for="image-input" class="upload-button input-form-button" style="font-size:13px;">
                    <i class="fa-solid fa-image icon-r"></i> Выберите фотографию
                </label>

                <input type="file" name="image" id="image-input" class="input-hide" required onchange="displayFileNameForImages(this)">

            </div>
            <div>
                <button type="submit" id="upload-button" class="upload-button-send"><i class="fa-solid fa-upload icon-r"></i>Загрузить</button>
            </div>
        </div>
        <div>
            <div>
                <span id="selected-image-name"></span>
            </div>

        </div>
    </form>


    <div class="album">
        <?php
        // Подготовка запроса для выборки всех картинок
        $stmt = $pdo->prepare("SELECT id_image, image FROM page_album WHERE id_page = ?");
        $stmt->execute([$id]);

        // Итерация по результатам запроса
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $imageId = $row['id_image'];
            $imageData = $row['image'];
            $imageBase64 = base64_encode($imageData);
            echo '<div class="album-element">';
            echo '<img src="data:image/jpeg;base64,' . $imageBase64 . '" class="album-image" />';
            echo '<div class="image-card-buttons"><a href="site/script/album/delete_image.php?id=' . $imageId . '&id_page=' . $id . '" class="del-button" onclick="return confirm(\'Вы уверены, что хотите удалить изображение?\')"><i class="fa-solid fa-trash icon-r"></i>Удалить</a></div>';
            echo '</div>';
        }
        ?>
    </div>


</div>
<div id="content-3">
    <h2 class="title">Выберите и загрузите документы</h2>
    <form action="site/script/docs/upload_documents.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div style="display: flex; align-items:center; gap:30px;  padding-bottom:20px;">
            <div>
                <label for="document-input" class="upload-button input-form-button" style="font-size:13px;">
                    <i class="fa-solid fa-image icon-r"></i> Выберите файл
                </label>
                <input type="file" name="documents[]" id="document-input" class="input-hide" required onchange="displayFileNameForDocuments(this)">
            </div>
            <div>
                <span id="selected-file-name-documents"></span>
            </div>

            <div>
                <input type="text" name="document_names[]" placeholder="Имя для документа" required class="input" style="height:24px;">
            </div>
            <div>
                <button type="submit" id="upload-button" class="upload-button-send"><i class="fa-solid fa-upload icon-r"></i>Загрузить</button>
            </div>
        </div>
    </form>

    <?php
    $stmt = $pdo->prepare("SELECT * FROM page WHERE id_page=?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверяем, есть ли документы
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM page_docs WHERE id_page = ?");
    $stmt->execute([$id]);
    $docCount = $stmt->fetchColumn();

    if ($docCount > 0) {
        echo '<h3 class="title" style="margin-top:30px;">Список документов:</h3>';
        echo '<ul style="all:unset;">';
        $stmt = $pdo->prepare("SELECT id_doc, name, filename FROM page_docs WHERE id_page = ?");
        $stmt->execute([$id]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $file_path = 'site/docs/' . $row['filename']; // Относительный путь к файлу
            echo '<li>';
            echo '<a href="' . $file_path . '" target="_blank" style="color:#3366BB ; font-size:14px">' . $row['name'] . '</a>';
            echo ' <a href="site/script/docs/delete_document.php?id=' . $row['id_doc'] . '&id_page=' . $id . '" class="delete-link" onclick="return confirm(\'Вы уверены, что хотите удалить документ?\')" style="color:#3366BB ; font-size:14px; margin-left:10px;">Удалить</a>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
    }
    ?>



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

<!-- JavaScript для первой формы -->
<script>
    function displayFileNameForDocuments(input) {
        const selectedFile = input.files[0];
        const selectedFileNameElement = document.getElementById("selected-file-name-documents");

        if (selectedFile) {
            selectedFileNameElement.textContent = "Выбранный файл: " + selectedFile.name;
        } else {
            selectedFileNameElement.textContent = "";
        }
    }
</script>

<!-- JavaScript для второй формы -->
<script>
    function displayFileNameForImages(input) {
        const selectedFile = input.files[0];
        const selectedFileNameElement = document.getElementById("selected-image-name");

        if (selectedFile) {
            selectedFileNameElement.textContent = "Выбранный файл: " + selectedFile.name;
        } else {
            selectedFileNameElement.textContent = "";
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