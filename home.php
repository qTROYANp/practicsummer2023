<section class="cards-section">
  <div class="container">
    <div class="title-area">
      <h1 class="area-title">НАШИ УСЛУГИ</h1>
      <p class="area-under-title">КАЧЕСТВО НА ВЫСОКОМ УРОВНЕ</p>
    </div>
    <div class="cards-area">
      <h1 class="area-title">ФИЗИЧЕСКАЯ ОХРАНА</h1>
      <div class="cards">
        <?php
        // Достаем карточки услуг физ. охраны 
        $stmt = $GLOBALS["pdo"]->query("SELECT * FROM page");
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
          if ($result["part"] == 14) {
            $seo_title = $result["seo_title"];
            $name = $result["name"];
            $imageData = $result["image"];
            $image = 'data:image/jpeg;base64,' . base64_encode($imageData);
            echo '<div class="card">  
                        <div class="card-image" style="background-image: url(\'' . $image . '\') !important;"></div>
                  <!-- Новый элемент для фоновой картинки -->  
                  <div class="card-body">  
                    <div class="card-body-title">  
                      <span>' . $name . '</span>  
                    </div>  
                    <p>' . $seo_title . '</p>  
                    <a href="?url=page&id=' . $result["id_page"] . '" class="card-button">Подробнее</a>

                  </div>  
              </div>';
          }
        }
        ?>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
</section>


<section class="cards-section">
  <div class="container">
    <div class="cards-area">
      <h1 class="area-title">ДЛЯ БИЗНЕСА</h1>
      <div class="cards">
        <?php
        // Достаем карточки услуг физ. охраны
        $stmt = $GLOBALS["pdo"]->query("SELECT * FROM page");

        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
          if ($result["part"] == 72) {

            $seo_title = $result["seo_title"];
            $name = $result["name"];
            $image = $result["img"];

            echo '<div class="card">
                <div class="card-image" style="background-image: url(\'template/images/staticimg/' . $image . '\') !important;"></div>
                  <!-- Новый элемент для фоновой картинки -->
                  <div class="card-body">
                    <div class="card-body-title">
                      <span>' . $name . '</span>
                    </div>
                    <p>' . $seo_title . '</p>
                    <a href="?url=page&id=' . $result["id_page"] . '" class="card-button">Подробнее</a>
                  </div>
              </div>';
          }
        }
        ?>
      </div>
    </div>
  </div>
  </div>
  </div>
</section>

<!-- Секция с информацией и клиентами -->

<section class="info-section">
  <div class="container">
    <div class="info-area">
      <div style="width: 400px">
        <div class="title">
          <div class="title-icon"></div>
          <h1>Почему мы?</h1>
        </div>

        <ul>
          <li><span>30</span>Районов края</li>
          <li><span>23</span>Новых обьекта за месяц</li>
          <li><span>40</span>Новых партнеров за год</li>
          <li><span>638</span>Подготовлено охранников</li>
        </ul>
      </div>
      <div class="clients">
        <div class="title">
          <div class="title-icon"></div>
          <h1>Наши клиенты</h1>
        </div>

        <div class="client-cards">
          <img src="template/images/clients/1.jpg" alt="" />
          <img src="template/images/clients/2.jpg" alt="" />
          <img src="template/images/clients/3.jpg" alt="" />
          <img src="template/images/clients/4.jpg" alt="" />
          <img src="template/images/clients/5.jpg" alt="" />
          <img src="template/images/clients/6.jpg" alt="" />
        </div>
      </div>
    </div>
  </div>
</section>
<section class="message-section">
  <div class="container">
    <div class="content">
      <div class="message-area">
        <h1>ОБРАЩЕНИЕ РУКОВОДИТЕЛЯ</h1>
        <ul>
          <li>
            <a href="?url=page&id=9" class="yellow-link">О компании</a>
            <a href="?url=page&id=13" class="yellow-link">Видео</a>
            <a href="?url=page&id=23" class="yellow-link">Наши партнеры</a>
          </li>
        </ul>
        <p>
          Группа предприятий охраны «Русский Витязь» благодарит Вас за
          посещение нашего сайта и надеется на то, что состоявшееся
          знакомство будет приятным, долгим и плодотворным. <br />
          <br />- Мы строим наши отношения в виде индивидуального подхода к
          каждому клиенту. <br />- Преимущества работы с нами уже смогли
          оценить многие отечественные компании в городе Чите и
          Забайкальском крае. <br />- Под нашей охраной находятся различные
          объекты охраны от малого до большого.
        </p>
      </div>
      <div class="video-area">
        <iframe class="video" width="420" height="315" src="https://www.youtube.com/embed/txYeyM_8pf8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</section>

<!--    Секция с картой -->

<section class="map-section">
  <div class="container">
    <div class="adress-area">
      <h1>КАК НАС НАЙТИ</h1>
      <span>г. Чита, ул. 1-ая Новопроточная, дом 4а</span>
    </div>

    <div style="position: relative; overflow: hidden; border-radius:5px;">
      <a href="https://yandex.ru/maps/org/vityaz/122070255596/?utm_medium=mapframe&utm_source=maps" style="color: #eee; font-size: 12px; position: absolute; top: 0px">Витязь</a><a href="https://yandex.ru/maps/68/chita/category/security_company/184105374/?utm_medium=mapframe&utm_source=maps" style="color: #eee; font-size: 12px; position: absolute; top: 14px">Охранное предприятие в Чите</a><iframe src="https://yandex.ru/map-widget/v1/org/vityaz/122070255596/?ll=113.483047%2C52.038539&z=17" width="100%" height="400px" frameborder="0" allowfullscreen="true" style="position: relative"></iframe>
    </div>
  </div>
</section>