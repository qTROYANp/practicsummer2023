<?php
include '../config.php';
include 'parts/header.php';
include 'parts/login-navbar.php';
?>

<div class="login-wrapper">
  <div class="login-form">
    <h1 class="title" style="text-align:center; padding-bottom:10px;">Авторизация</h1>
    <div class="form">
      <form action="/admin/?url=script/login" method="post">
        <div class="input-item">
          <label for="login">Логин: </label><br />
          <input type="text" id="login" name="login" class="input" required="" style="margin-top: 6px;" />
        </div>
        <div class="input-item">
          <label for="password">Пароль: </label><br />
          <input type="password" id="password" name="password" class="input" style="margin-top: 6px;" />
        </div>
        <div class="input-item">
          <input type="submit" value="Войти" class="input-button input-form-button" style="width:302px; margin-top:10px;" />
        </div>
      </form>
    </div>
  </div>
</div>
<?php
include 'parts/footer.php';
?>