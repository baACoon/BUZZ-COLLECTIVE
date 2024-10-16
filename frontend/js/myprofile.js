  // Auto-submit form when a new profile image is selected
  document.getElementById('profile-image-input').addEventListener('change', function() {
    document.getElementById('profile-image-form').submit();
});

// Close notification popup
function closePopup() {
    document.getElementById("notification-popup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}

// Get modal elements
var emailModal = document.getElementById("email-modal");
var overlay = document.querySelector(".overlay");

// Get open modal button
var changeBtn = document.querySelector(".change-btn");

// Get close button
var closeBtn = document.querySelector(".close-modal");

// Listen for open click
changeBtn.addEventListener("click", function(event) {
    event.preventDefault();
    emailModal.style.display = "block";
    setTimeout(function() {
        emailModal.classList.add("show");
    }, 10);
});

// Listen for close click
closeBtn.addEventListener("click", function() {
    emailModal.classList.remove("show");
    setTimeout(function() {
        emailModal.style.display = "none";
    }, 300);
});

// Close modal if outside click
window.addEventListener("click", function(event) {
    if (event.target === emailModal) {
        emailModal.classList.remove("show");
        setTimeout(function() {
            emailModal.style.display = "none";
        }, 300);
    }
});

// menu icon
document.addEventListener('DOMContentLoaded', function() {
    const menuIcon = document.getElementById('menu-icon');
    const sidebar = document.querySelector('.sidebar');
    const closeSidebar = document.getElementById('close-sidebar');

    // Add click event to the menu icon
    menuIcon.addEventListener('click', function() {
        sidebar.classList.toggle('open'); // Toggle the 'open' class on the sidebar
        closeSidebar.style.display = sidebar.classList.contains('open') ? 'block' : 'none'; // Show/hide close button
    });

    // Add click event to the close button
    closeSidebar.addEventListener('click', function() {
        sidebar.classList.remove('open'); // Remove the 'open' class on the sidebar
        closeSidebar.style.display = 'none'; // Hide close button
    });
});