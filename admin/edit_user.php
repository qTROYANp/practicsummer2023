<h1 class="title">Редактирование личных данных</h1>
<div class="form">
    <form action="/admin/script/edit_user.php" method="post">
        <div class="input-item">
            <label for="name">Имя пользователя: </label><br />
            <input type="text" id="name" name="username" class="input" required="" value="<?php echo $_SESSION['username']; ?>" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <label for="login">Логин: </label><br />
            <input type="text" id="login" name="login" class="input" required="" value="<?php echo $_SESSION['login']; ?>" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <label for="password">Пароль: </label><br />
            <input type="password" id="password" name="password" class="input" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <label for="email">Почта: </label><br />
            <input type="email" id="email" name="email" required="" value="<?php echo $_SESSION['email']; ?>" class="input" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <label for="tel">Телефон: </label><br />
            <input type="tel" id="tel" name="telephone" required="" value="<?php echo $_SESSION['telephone']; ?>" class="input" style="margin-top: 10px;" />
        </div>
        <div class="input-item">
            <input type="submit" value="Сохранить" class="input-button input-form-button" style="width:310px;" />
        </div>
    </form>
</div>