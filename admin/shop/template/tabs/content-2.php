<? $idPage = isset($_GET['id_page']) ? $_GET['id_page'] : '';
?>

<form id="image-upload-form" enctype="multipart/form-data" action="site/script/album/album_uploader.php" method="POST">
    <div style="display:flex; gap:20px; align-items:center;">
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
        <span id="selected-image-name"></span>
    </div>
</form>


<div class="album" style="padding-bottom:20px;">

</div>

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