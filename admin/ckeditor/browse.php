<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выбор файла</title>

    <style>
        @import url(https://fonts.googleapis.com/css?family=Montserrat:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic);

        body {
            font-family: "Montserrat";
            box-sizing: border-box;
            background-color: #f6f6f6;
        }


        .uk-container {
            width: 90%;
            margin: auto;
        }

        .uk-text-emphasis{
            font-size: 14px;
        }

        .l-wrap {
            margin: auto;
        }

        .grid-item {
            margin-right:20px;
            width:auto;
            padding: 0px 10px;
            float: left;
            word-break: break-all;

            justify-content: center;
            align-items: center;
            min-height: 400px;
            text-align: center;
            margin-bottom: 1em;
            margin-top: 1em;
            border: 1px solid #CCCCCC;
            border-radius:4px;
        }

        .grid-item .img-table {
            width: 96%;
            height: 150px;
            background-size: contain !important;
            background-position: center !important;
            margin: auto;
        }

        .grid-item .row {
            width: 100%;
        }

        .down {
            width: 200px;
            margin: auto;
        }


        .but {
            text-align: center;
            padding: 10px 15px;
            border-radius: 6px;
            margin-top: 2px;
            margin-left: 4px;
            margin-right: 4px;
            cursor: pointer;
            text-decoration: none;
            border: 0px;
            display: block;
            margin-bottom:20px;
        }

        .but:hover {
            opacity: 0.9;
            text-decoration: none;
        }

        .green {
            background: #388a3b;
            color: #FFFFFF;
        }

        .red {
            color: #fff !important;
            background-color: #dc3545;
            border-color: #dc3545;
        }


    </style>

    <script>
        // Функция для получения параметров из строки запроса.
        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam);

            return (match && match.length > 1) ? match[1] : null;
        }

        // Немного измененая функция из официальной документации, которая передает нужные параметры обратно в CKEditor.
        // Она принимает КНОПКУ КАК ОБЪЕКТ которую ВЫ выбрали.
        // Далее мы вынимаем у кнопки атрибут href (а он соотвествует ссылке у картинки), через split и pop получаем название файла (например 1.png)
        // И прибавляем к нему путь той самой папки c картинкам куда мы изначально складывали их с помощью upload.php.
        function returnFileUrl(img) {
            var funcNum = getUrlParam('CKEditorFuncNum');
            var href = img.href.split('/').pop();
            href = '/files/img/' + href;
            window.opener.CKEDITOR.tools.callFunction(funcNum, href);
            window.close();
        }
    </script>
    <script src="/admin/js/jquery-3.5.1.min.js"></script>
    <script>
        function deletefile(filename) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/admin/ajax/deleteFile.php",
                data: {
                    filename: filename
                },
                success: function(res) {

                }
            });

            document.location.reload(true);
        }
    </script>
</head>

<body>
    <div class="uk-container">
        <h1 style="padding-top: 2em;" class="uk-h2">Выберите изображение</h1>
        <div class="l-wrap">
            <div class="three-col-grid">

                <?php

                $srcdir = '/files/img/'; // Папка c картинкам куда мы изначально складывали их с помощью upload.php.

                $dir = $_SERVER['DOCUMENT_ROOT'] . $srcdir; // Тут мы создали переменную dir в которую поместили полный путь к нашей папке где хранятся картинки.

                $files = array_diff(scandir($dir), array('..', '.')); // Здесь мы просканировали нужную нам директорию, получили N-ое кол-во файлов, после удалили мусор из массива.

                // Тут мы пускаем цикл, который будет выполняться пока массив files не опустеет.
                // А с помощью onclick="returnFileUrl(this); return false;" мы получаем по нажатию на кнопку выбранный объект (кнопку на которую нажали) и передаем в функцию returnFileUrl
                // А и еще, return false; запрещает переход по кнопке.
                foreach ($files as &$value) {
                    echo '<div class="wrapper"><div class="grid-item">
                        <p class="uk-text-emphasis">
                            <div class="img-table" style="background: url(/files/img/' . $value . ') no-repeat;"></div>
                            <div>
                                <p class="uk-text-emphasis down"><b>'
                        . $value .
                        '</b></p>
                                <br />
                                <p class="uk-text-emphasis down">
                                   <a onclick="returnFileUrl(this); return false;" href="' . $value . '" class="but green">Выбрать</a>
                                   <a href="#" onclick="if(confirm(\'Подтверждаете удаление?\')){deletefile(\'files/img/' . $value . '\')}" class="but red">Удалить</a>
                                </p>
                            </div>
                    </div></div>';
                }
                ?>
            </div>
        </div>

    </div>
</body>

</html>
