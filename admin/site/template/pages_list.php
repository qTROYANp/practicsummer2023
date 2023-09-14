<?php

$stmt = $pdo->query("SELECT id_page, name, part FROM page");
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h1 class="title">Страницы сайта</h1>

<div style="display: flex; gap:30px;">
    <div>
        <a href="?url=site/template/add_page" class="button-a"><i class="fa-solid fa-plus icon-r"></i>Добавить страницу</a>
    </div>
</div>


<div class="pages-list-wrapper">
    <?php create_tree($pages); ?>
</div>

<?php
// Функция для рекурсивного вывода иерархического списка страниц
function create_tree($pages, $parentId = 0)
{

    echo '<ul class="ul-treefree ul-dropfree">';
    foreach ($pages as $page) {
        if ($page['part'] == $parentId) {
            echo '<li>';

            if ($page['part'] !== 0) {
                $echoImg = '<img src="img/ico/page_on.jpg">';
            } else {
                $echoImg = '<img src="img/ico/cat.jpg">';
            }

            if ($page['name'] == '') {
                $page['name'] = 'Новая страница';
            }

            echo $echoImg . '<span style="position: relative; top: -5px;"><a href="?url=site/template/edit_page&id=' . $page['id_page'] . '" title="Редактировать страницу">' . $page['name'] . ' (id ' . $page['id_page'] . ')</a></span>';
            echo '<a href="?url=site/template/add_page&parent_id=' . $page['id_page'] . '" class="add-child-page" title="Добавить дочернюю страницу">+</a>';
            create_tree($pages, $page['id_page']); // Рекурсивный вызов для формирования подстраниц

            echo '</li>';
        }
    }
    echo '</ul>';
}

?>

<style>
    .ul-treefree li a {
        color: #444444;
        margin-left: 10px;
        text-decoration: none;
        transition: 0.1s ease color;
    }

    .ul-treefree li a:hover {
        color: #292929;
        margin-left: 10px;
        text-decoration: underline;
    }


    .ul-treefree li span img {
        margin-left: 5px;
        position: relative;
        top: 5px;
    }

    ul.ul-treefree {
        padding-left: 10px;
    }

    ul.ul-treefree ul {
        margin: 0;
        padding-top: 10px;
        padding-left: 6px;
    }

    ul.ul-treefree li {
        position: relative;
        list-style: none outside none;
        border-left: solid 1px #999;
        margin: 0;
        padding: 0 0 6px 19px;
        line-height: 23px;
    }

    ul.ul-treefree li:before {
        content: '';
        content: '';
        display: block;
        border-bottom: solid 1px #999;
        position: absolute;
        width: 18px;
        height: 25px;
        left: 0;
        top: -15px;
    }

    ul.ul-treefree li:last-child {
        border-left: 0 none;
    }

    ul.ul-treefree li:last-child:before {
        border-left: solid 1px #999;
    }

    /* ul-dropfree */
    ul.ul-dropfree div.drop {
        width: 11px;
        height: 11px;
        position: absolute;
        z-index: 10;
        top: 11px;
        left: -6px;
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAALCAIAAAD0nuopAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAE1JREFUeNpinDlzJgNlgAWI09LScEnPmjWLoAImrHpIAkwMFAMqGMGC6X44GzkIsHoQooAFTTVQKdbAwxOigyMsmIh3MC7ASHnqBAgwAD4CGeOiDhXRAAAAAElFTkSuQmCC');
        background-position: -11px 0;
        background-repeat: no-repeat;
        cursor: pointer;
    }
</style>