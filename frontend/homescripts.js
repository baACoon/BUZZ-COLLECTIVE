// Ensure all event listeners are set after the DOM is fully loaded
window.onload = function () {
  // Example button click alert
  document.getElementById("subm").onclick = function () {
    alert("Hello World");
  };

  // Image Slider
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

  // Sidebar open/close functionality
  let navLinks = document.querySelector(".nav-links");
  let menuOpenBtn = document.querySelector(".navbar .bx-menu");
  let menuCloseBtn = document.querySelector(".nav-links .bx-x");

  if (menuOpenBtn) {
    menuOpenBtn.onclick = function () {
      navLinks.classList.add("show");
    };
  }

  if (menuCloseBtn) {
    menuCloseBtn.onclick = function () {
      navLinks.classList.remove("show");
    };
  }

  // Sidebar submenu open/close functionality
  let htmlcssArrow = document.querySelector(".htmlcss-arrow");
  if (htmlcssArrow) {
    htmlcssArrow.onclick = function () {
      navLinks.classList.toggle("show1");
    };
  }
  let jsArrow = document.querySelector(".js-arrow");
  if (jsArrow) {
    jsArrow.onclick = function () {
      navLinks.classList.toggle("show3");
    };
  }
};
