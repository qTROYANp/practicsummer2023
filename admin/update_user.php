<?php

if ($_SESSION['role'] != 1) {
    header("Location: /admin"); // Перенаправляем на главную страницу или другую, если необходимо
    exit();
}

// Получение id пользователя из параметра GET
$id_user = isset($_GET['id']) ? $_GET['id'] : null;


$stmt = $pdo->prepare("SELECT * FROM user WHERE id_user = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<h1 class="title">Редактирование пользователя: <?php echo $user['username']; ?></h1>
<div class="form">
    <form action="/admin/script/update_user.php" method="post">
        <input type="hidden" id="id_user" name="id_user" class="input" value="<?php echo $user['id_user']; ?>" />
        <div class="input-item">
            <label for="name">Имя пользователя:</label><br />
            <input type="text" id="name" name="username" class="input" required="" style="margin-top: 10px;" value="<?php echo $user['username']; ?>" />
        </div>

        <div class="input-item">
            <label for="login">Логин:</label><br />
            <input type="text" id="login" name="login" class="input" required="" style="margin-top: 10px;" value="<?php echo $user['login']; ?>" />
        </div>

        <div class="input-item">
            <label for="password">Пароль:</label><br />
            <input type="password" id="password" name="password" class="input" style="margin-top: 10px;" />
        </div>

        <div class="input-item">
            <label for="email">Почта:</label><br />
            <input type="email" id="email" name="email" class="input" style="margin-top: 10px;" value="<?php echo $user['email']; ?>" />
        </div>

        <div class="input-item">
            <label for="tel">Телефон:</label><br />
            <input type="tel" id="tel" name="telephone" class="input" style="margin-top: 10px;" value="<?php echo $user['telephone']; ?>" />
        </div>

        <div class="input-item">
            <label for="role">Роль:</label><br />
            <select id="role" name="role" class="input" style="margin-top: 10px; width: 302px;">
                <?php
                // Здесь выполните запрос к базе данных для получения списка ролей
                $stmt = $pdo->query("SELECT * FROM role");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($row['id_role'] == $user['id_role']) ? 'selected' : '';
                    echo '<option value="' . $row['id_role'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="input-item">
            <input type="submit" value="Сохранить" class="input-button input-form-button" style="width: 310px;" />
        </div>
    </form>
</div>