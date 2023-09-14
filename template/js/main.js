const menuBtn = document.querySelector(".fa-bars");
const menu = document.querySelector(".burger-menu");

menuBtn.addEventListener("click", function () {
  menu.classList.toggle("active");
  menuBtn.classList.toggle("fa-bars");
  menuBtn.classList.toggle("fa-xmark");
});

/* Открытие поп-ап окна */

const openPopUpBtn = document.querySelector(".open-pop-up");
const popUp = document.querySelector(".pop-up");

openPopUpBtn.addEventListener("click", function () {
  popUp.classList.toggle("active");
});

/* Закрытие поп-ап окна */

const closePopUpBtn = document.querySelector(".close-pop-up");

closePopUpBtn.addEventListener("click", function () {
  popUp.classList.remove("active");
});
