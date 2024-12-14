// sidebar open close js code
let navLinks = document.querySelector(".nav-links");
let menuOpenBtn = document.querySelector(".navbar .bx-menu");
let menuCloseBtn = document.querySelector(".nav-links .bx-x");

menuOpenBtn.onclick = function() {
navLinks.classList.add("show");
};

menuCloseBtn.onclick = function() {
navLinks.classList.remove("show");
};

// sidebar submenu open close js code
let htmlcssArrow = document.querySelector(".htmlcss-arrow");
htmlcssArrow.onclick = function() {
navLinks.classList.toggle("show1");
}

jQuery(document).ready(function ($) {
    $(".slider-img").on("click", function () {
      $(".slider-img").removeClass("active");
      $(this).addClass("active");
    });
  });


// Select DOM elements
const nextBtn = document.querySelector('.next');
const prevBtn = document.querySelector('.prev');
const carousel = document.querySelector('.carousel');
const list = document.querySelector('.list');
const items = document.querySelectorAll('.item');

let index = 0; // Index for tracking current slider position

// Timing variables
let timeRunning = 3000; 
let timeAutoNext = 7000; 

// Declare a global `runningTime` variable for animation
let runningTime = document.createElement('div'); 
runningTime.style.animation = 'runningTime 7s linear 1 forwards'; 
document.body.appendChild(runningTime); // Temporarily added to the DOM

// Event listeners for next and previous buttons
if (nextBtn) {
    nextBtn.onclick = function () {
    showSlider('next');
    };
}

if (prevBtn) {
    prevBtn.onclick = function () {
        showSlider('prev');
    };
}

let runTimeOut; // Timeout for animation reset
let runNextAuto = setTimeout(() => {
    nextBtn.click(); // Trigger next slider automatically
}, timeAutoNext);

// Function to reset the running time animation
function resetTimeAnimation() {
    if (runningTime) {
        runningTime.style.animation = 'none'; // Clear the animation
        runningTime.offsetHeight; // Trigger a reflow
        runningTime.style.animation = 'runningTime 7s linear 1 forwards'; // Restart the animation
    }
}

// Function to handle slider transitions
function showSlider(type) {
    let sliderItemsDom = list.querySelectorAll('.carousel .list .item');

    if (type === 'next') {
        list.appendChild(sliderItemsDom[0]); // Move first item to the end
        carousel.classList.add('next');
    } else {
        list.prepend(sliderItemsDom[sliderItemsDom.length - 1]); // Move last item to the front
        carousel.classList.add('prev');
    }

    // Clear the transition timeout
    clearTimeout(runTimeOut);

    runTimeOut = setTimeout(() => {
        carousel.classList.remove('next');
        carousel.classList.remove('prev');
    }, timeRunning);

    // Clear and reset the auto-next timer
    clearTimeout(runNextAuto);
    runNextAuto = setTimeout(() => {
        nextBtn.click(); // Trigger the next button click
    }, timeAutoNext);

        resetTimeAnimation(); // Reset the running time animation
    }