<? session_start();

// Проверка наличия сессии пользователя и его роли
if ($_SESSION['role'] != 1) {
    header("Location: /admin"); // Перенаправляем на главную страницу или другую, если необходимо
    exit();
} ?>

<h1 class="title">Список пользователей:</h1>

<div style="margin-top:30px; margin-bottom:30px;">
    <a href="?url=add_user" class="button-a"><i class="fa-solid fa-plus icon-r"></i>Добавить пользователя</a>
</div>

<div class="users-table">
    <table style="margin-top: 40px;">
        <thead>
            <tr>
                <th>Имя пользователя</th>
                <th>Логин</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Роль</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Получаем id_user текущего пользователя из сессии
            $currentUserId = $_SESSION['id_user'];

            // SQL-запрос для выборки пользователей, исключая текущего пользователя
            $stmt = $pdo->prepare("SELECT user.*, role.name FROM user 
                       LEFT JOIN role ON user.id_role = role.id_role
                       WHERE user.id_user <> :currentUserId
                       ORDER BY user.id_role ASC");
            $stmt->bindParam(':currentUserId', $currentUserId, PDO::PARAM_INT);
            $stmt->execute();


            while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) :
            ?>
                <tr>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['login']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['telephone']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <? if ($user['id_user'] !== $_SESSION['id_user']) { ?>
                        <td style="padding:30px;"><a href="?url=update_user&id=<?php echo $user['id_user']; ?>" class="button-a"><i class="fa-solid fa-pen icon-r"></i>Редактировать</a></td>
                        <td style="padding:30px;"><a href="/admin/script/delete_user.php?id=<?php echo $user['id_user']; ?>" class="button-a-del" onclick="return confirm('Вы уверены, что хотите удалить категорию?')"><i class="fa-solid fa-trash icon-r"></i>Удалить</a></td>
                    <? } ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<style>
    .products-table {
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        text-align: left;
    }
</style>