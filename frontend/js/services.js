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


function showMoreImages() {
    var additionalImages = document.querySelector('.additional-images');
    var seeMoreLink = document.querySelector('.see-more-link');
    
    // Toggle visibility of additional images
    if (additionalImages.style.display === 'none' || additionalImages.style.display === '') {
        additionalImages.style.display = 'grid';  // Show the images
        seeMoreLink.textContent = 'See Less'; // Change text to 'See Less'
    } else {
        additionalImages.style.display = 'none'; // Hide the images
        seeMoreLink.textContent = 'See More'; // Change text back to 'See More'
    }
}