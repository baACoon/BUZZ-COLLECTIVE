document.addEventListener("DOMContentLoaded", function () {
  // Image Slider
  const swiper = new Swiper(".mySwiper", {
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

  // Sidebar open/close js code
  const navLinks = document.querySelector(".nav-links");
  const menuOpenBtn = document.querySelector(".navbar .bx-menu");
  const menuCloseBtn = document.querySelector(".nav-links .bx-x");

  if (menuOpenBtn) {
    menuOpenBtn.onclick = function () {
      navLinks?.classList.add("show");
    };
  } else {
    console.error("Menu Open Button not found.");
  }

  if (menuCloseBtn) {
    menuCloseBtn.onclick = function () {
      navLinks?.classList.remove("show");
    };
  } else {
    console.error("Menu Close Button not found.");
  }

  // Sidebar submenu open/close js code
  const htmlcssArrow = document.querySelector(".htmlcss-arrow");
  const moreArrow = document.querySelector(".more-arrow");
  const jsArrow = document.querySelector(".js-arrow");

  if (htmlcssArrow) {
    htmlcssArrow.onclick = function () {
      navLinks?.classList.toggle("show1");
    };
  } else {
    console.error("HTML/CSS Arrow not found.");
  }

  if (moreArrow) {
    moreArrow.onclick = function () {
      navLinks?.classList.toggle("show2");
    };
  } else {
    console.error("More Arrow not found.");
  }

  if (jsArrow) {
    jsArrow.onclick = function () {
      navLinks?.classList.toggle("show3");
    };
  } else {
    console.error("JS Arrow not found.");
  }
});
