<?php

// Проверяем запрос, если это Drag and Drop в JSON то:

if (stristr($_SERVER["REQUEST_URI"], 'responseType=json') == true) {

    $full_path = '';
    $upload_dir = '/files/img/'; // Папка, куда будем складировать все картинки и доставать их оттуда с помощью второго скрипта browse.php
    // Т.е в рамках моего сайта это будет равно kolmogorov.pro/img.

    $images_exts = '.png'; // Всем файлам вставленным через JSON будем устанавливать расширение .png.

    $dir = $_SERVER['DOCUMENT_ROOT'] . $upload_dir; // Сохраняем в переменную полный путь до нашей папки.

    $name = substr(sha1(time()), 0, 16) . $images_exts; // Генерируем уникальное имя для картинки.
    $d = $dir . '/' . $name; // Создаем путь, по которому будет храниться картинка.

    // Проверка на случай если по какой-то причине вы не сможете сохранить файл из-за некорректно настроеных путей

    if (!@move_uploaded_file($_FILES['upload']['tmp_name'], $d)) {
        $message = 'Невозможно сохранить файл, проверьте настройки папки для файлов ' . $_FILES['upload']['name'];

        $jsonForPasteMode = array("uploaded" => 0, "error" => $message);
        echo json_encode($jsonForPasteMode);
    } else {
        // Если все успешно сохранилось отправляем ответ в CKEditor
        $full_path = $upload_dir . '/' . $name;

        $jsonForPasteMode = array("uploaded" => 1, "fileName" => $name, "url" => $full_path);
        echo json_encode($jsonForPasteMode);
    }
} else {
    // Если это обычная загрузка, то...

    $full_path = '';
    $upload_dir = '/files/img/'; // Папка, куда будем складировать все картинки и доставать их оттуда с помощью второго скрипта browse.php
    // Т.е в рамках моего сайта это будет равно kolmogorov.pro/img.

    // Массив разрешенных расширений файлов

    $images_exts = array(
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png'
    );

    $dir = $_SERVER['DOCUMENT_ROOT'] . $upload_dir; // Сохраняем в переменную полный путь до нашей папки.

    // Тут идет череда проверок

    if (!isset($_FILES['upload']) && !is_uploaded_file($_FILES['upload']['tmp_name'])) {
        $message = 'Вы не указали файл для загрузки';
    } else {
        $is = @getimagesize($_FILES['upload']['tmp_name']);

        if (!isset($images_exts[$is[2]])) {
            $message = 'Необходимо указать файл формата ' . implode(', ', $images_exts);
        } else {
            // Здесь меняется имя файла с русских символов на английские
            $name = Transliteration($_FILES['upload']['name']);
            $d = $dir . '/' . $name;

            if (file_exists($d)) {
                $message = 'Файл с именем ' . $_FILES['upload']['name'] . ' уже существует';
            } elseif (!@move_uploaded_file($_FILES['upload']['tmp_name'], $d)) {
                $message = 'Невозможно сохранить файл, проверьте настройки папки для файлов ' . $_FILES['upload']['name'];
            } else {
                $full_path = $upload_dir . '/' . $name;
                $message = 'Файл успешно загружен';
            }
        }
    }

    // Тут происходит основная магия, мы создаем GET запрос для CKEditor
    $callback = $_GET['CKEditorFuncNum'];

    // Создаем и инициализируем скрипт, который запускает функцию передающую путь до файла и сообщение
    echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $callback . '", "' . $full_path . '", "' . $message . '" );</script>';
}

// Функция меняет русские буквы на английские
function Transliteration($str)
{
    $transl = array(
        "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D", "Е" => "E", "Ё" => "YO", "Ж" => "ZH", "З" => "Z", "И" => "I", "Й" => "J", "К" => "K", "Л" => "L", "М" => "M",
        "Н" => "N", "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH", "Ш" => "SH", "Щ" => "SCH", "Ь" => "",
        "Ъ" => "", "Ы" => "Y", "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "yo", "ж" => "zh", "з" => "z",
        "и" => "i", "й" => "j", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
        "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ь" => "", "ъ" => "", "ы" => "y", "э" => "e", "ю" => "yu", "я" => "ya", " " => "", "~" => "", "," => "",
        ":" => "", ";" => "", "#" => "", "$" => "", "%" => "", "^" => "", "&" => "", "*" => "", "(" => "", ")" => "", "@" => "", "`" => "", "[" => "",
        "]" => "", "{" => "", "}" => ""
    );
    return preg_replace("/_+/", "_", strtolower(str_replace(array_keys($transl), array_values($transl), $str)));
}

exit();
?>



<?
/*
function getex($filename) {
return end(explode(".", $filename));
}
if($_FILES['upload'])
{
if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
{
$message = "Вы не выбрали файл";
}
else if ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 2050000)
{
$message = "Размер файла не соответствует нормам";
}
else if (($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
{
$message = "Допускается загрузка только картинок JPG и PNG.";
}
else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
{
$message = "Что-то пошло не так. Попытайтесь загрузить файл ещё раз.";
}
else{
$name =rand(1, 1000).'-'.md5($_FILES['upload']['name']).'.'.getex($_FILES['upload']['name']);
move_uploaded_file($_FILES['upload']['tmp_name'], "../../fail/img/".$name);
$full_path = 'https://'.$_SERVER['HTTP_HOST'].'/fail/img/'.$name;
$message = "Файл ".$_FILES['upload']['name']." загружен";
$size=@getimagesize('../../fail/img/'.$name);
if($size[0]<50 OR $size[1]<50){
unlink('../../fail/img/'.$name);
$message = "Файл не является допустимым изображением";
$full_path="";
}
}
$callback = $_REQUEST['CKEditorFuncNum'];
echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$full_path.'", "'.$message.'" );</script>';
}*/
?>
