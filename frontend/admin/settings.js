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
 
 // Add event listener for "Add New Administrator" button
 document.getElementById('add-new-btn').addEventListener('click', function() {
    // Change the header title
    document.getElementById('settings-title').textContent = "Settings: Add New Admin";
    
    // Hide the button container
    document.getElementById('button-container').style.display = "none";
    
    // Show the new admin container
    document.getElementById('new-admin-container').style.display = "block";
});

// Add event listener for the Cancel button
document.getElementById('cancel-btn').addEventListener('click', function() {
    // Change the header title back to "Settings"
    document.getElementById('settings-title').textContent = "Settings";
    
    // Show the button container again
    document.getElementById('button-container').style.display = "flex";
    
    // Hide the new admin container
    document.getElementById('new-admin-container').style.display = "none";
});