<div class="side-bar" id="sidebar">
    <div class="side-bar-section">
        <a href="?url=site/template/pages_list" class="link nav-item">Страницы</a>
        <a href="?url=shop/template/products_list" class="link nav-item">Товары</a>
        <?php
        // Проверка, был ли установлен уровень доступа пользователя
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

        // Если роль не равна 1, то кнопка "Пользователи" не будет отображаться
        if ($role == 1) {
            echo '<a href="?url=users_list" class="link nav-item">Пользователи</a>';
            echo '<a href="?url=logs" class="link nav-item">Логирование</a>';
        }
        ?>
        <a href="?url=edit_user" class="link nav-item">Аккаунт</a>

    </div>
</div>