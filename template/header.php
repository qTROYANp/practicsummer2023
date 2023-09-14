<div class="pop-up">
  <div class="pop-up-content">
    <div class="pop-up-header-content">
      <h1>Заказать консультацию</h1>
      <span class="fa-solid fa-xmark close-pop-up"></span>
    </div>
    <div class="pop-up-body-content">
      <form action="">
        <div class="input">
          <input type="tel" placeholder="Укажите номер телефона" />

          <button class="button">Отправить</button>
        </div>
        <div class="checkbox">
          <input type="checkbox" name="checkbox" class="checbox-square" />
          <label for="checkbox">Я согласен на обработку моих персональных данных</label>
        </div>

        <span>Оставьте свой номер и мы обязательно вам перезвоним в ближайшее
          время!</span>
      </form>
    </div>
  </div>
</div>

<header class="burger-header">
  <div class="container">
    <div class="burger-header-content">
      <img src="/template/images/logo.svg" alt="" width="300px" class="logo-2" />
      <i class="fa-solid fa-bars"></i>
    </div>
  </div>
</header>

<div class="burger-menu">
  <div class="burger-menu-content">
    <span><i class="fa-solid fa-phone" style="margin-right: 18px"></i>8 (3022)71-55-44</span>
    <ul class="group-1">
      <li><a href="/">Главное</a></li>

      <li><a href="?url=page&id=9">О компании</a></li>
      <li><a href="?url=page&id=7">Услуги</a></li>
      <li><a href="?url=page&id=66">Стрелковый клуб "ВИТЯЗЬ"</a></li>
      <li><a href="https://xn--b1akc4bcs0cwa.xn--p1ai/">Учебный центр</a></li>
    </ul>
    <ul class="group-2">
      <li><a href="#" class="">Оставить заявку</a></li>
    </ul>
  </div>
</div>

<header class="header">
  <div class="container">
    <div class="header-content" style="align-items: center;">
      <a href="/"><img src="template/images/logo.svg" alt="" width="316" /></a>
      <div class="telephones">
        <img src="template/images/tel.jpg" alt="" width="50" height="62" class="tel" />
        <ul>
          <li>Для клиентов: <a href="">8 (3022) 71-55-44</a></li>
          <li>Учебный центр: <a href="">8 (3022) 55-44-44</a></li>
        </ul>
      </div>
      <div class="buttons">
        <a href="?url=page&id=22" class="button-a">Контакты</a>
      </div>
    </div>
  </div>

  <div class="main-header">
    <div class="container">
      <div class="main-header-content">
        <div class="main-header-content-part-1">

          <ul>
            <li><a href="/">Главное</a></li>
            <div class="dropdown">
              <li><a href="?url=page&id=9" class="dropbtn">О компании</a></li>
              <div class="dropdown-content">
                <?php
                $row = db_row("page", "part", 9);
                foreach ($row as $result) {
                  $name = $result["name"];
                  echo '<a href="?url=page&id=' . $result["id_page"] . '">' . $name . '</a>';
                }
                ?>

              </div>
            </div>
            <div class="dropdown">

              <li><a href="?url=page&id=11" class="dropbtn">Услуги</a></li>

              <div class="dropdown-content">
                <?php
                $row = db_row("page", "part", 11);
                foreach ($row as $result) {
                  $name = $result["name"];
                  echo '<a href="?url=page&id=' . $result["id_page"] . '">' . $name . '</a>';
                }

                ?>
                <?php
                $row = db_row("page", "part", 72);
                foreach ($row as $result) {
                  $name = $result["name"];
                  echo '<a href="?url=page&id=' . $result["id_page"] . '">' . $name . '</a>';
                }

                ?>

              </div>
            </div>

            <li><a href="https://xn--b1akc4bcs0cwa.xn--p1ai/">Учебный центр</a></li>
          </ul>
        </div>

        <div class="main-header-content-part-2">
          <ul>
            <li><a href="?url=page&id=66">Стрелковый клуб "ВИТЯЗЬ"</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>