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

document.getElementById('toggleBranches').addEventListener('click', function() {
    var otherBranches = document.getElementById('otherBranches');
    var arrow = document.querySelector('.arrow');
    if (otherBranches.style.display === "none") {
        otherBranches.style.display = "block"; // Show the branches
        arrow.classList.add('rotate');
    } else {
        otherBranches.style.display = "none"; // Hide the branches
        this.textContent = "Other Branches"; // Change button text back
        arrow.classList.remove('rotate');
    }
});