<h1 class="title">Добавление нового пользователя:</h1>
<div class="form">
    <form action="/admin/script/add_user.php" method="post">
        <div class="input-item">
            <label for="name">Имя пользователя:</label><br />
            <input type="text" id="name" name="username" class="input" required="" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <label for="login">Логин:</label><br />
            <input type="text" id="login" name="login" class="input" required="" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <label for="password">Пароль:</label><br />
            <input type="password" id="password" name="password" required="" class="input" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <label for="email">Почта:</label><br />
            <input type="email" id="email" name="email" class="input" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <label for="tel">Телефон:</label><br />
            <input type="tel" id="tel" name="telephone" class="input" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <label for="role">Роль:</label><br />
            <select id="role" name="role" class="input" style="margin-top: 10px; width:302px;">
                <?php
                // Здесь выполните запрос к базе данных для получения списка ролей
                include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
                $stmt = $pdo->query("SELECT * FROM role");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['id_role'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="input-item">
            <input type="submit" value="Добавить" class="input-button input-form-button" style="width: 310px;" />
        </div>
    </form>
</div>