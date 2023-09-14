<div class="header">
    <div class="header-logo">
        <button class="toggle-side-bar-button" style="margin-right: 30px" onclick="toggleSidebar()">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a href="/index.php" class="logo">
            <h1>Админ</h1>
            <span>-панель</span>
        </a>
    </div>
    <div class="header-buttons" style="display: flex; align-items:center;">
        <a href="?url=edit_user" class="link"><i class="fa-solid fa-user icon-r"></i><? echo $_SESSION['username'] ?></a>
        <div>
            <a href="/" class="button-a" target="_blank"><i class="fa-classic fa-solid fa-eye icon-r"></i>Перейти на сайт</a>
        </div>
        <a href="site/script/logout.php" class="button-a">Выход<i class="fa-solid fa-right-from-bracket icon-l"></i></a>
    </div>
</div>