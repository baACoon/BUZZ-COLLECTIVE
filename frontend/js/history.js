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

// JavaScript to handle the profile image input
const fileInput = document.getElementById('profile-image-input');
const profileImg = document.getElementById('profile-img');
const defaultImage = "design/image/default-placeholder.png";

fileInput.addEventListener('change', function() {
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            profileImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('remove-image-button').addEventListener('click', function() {
    // Update the profile image to default on click
    profileImg.src = defaultImage;
});
