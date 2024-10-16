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

function validatePassword() {
    var newPassword = document.getElementById('new_password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&_])[A-Za-z\d@$!%*#?&_]{6,}$/;

    if (!passwordPattern.test(newPassword)) {
        // If the password doesn't match the pattern, show the popup
        document.getElementById('notification-popup').innerHTML = `
            <p>Password must be at least 6 characters long, and include at least one letter, one number, and one special character (!$@%&_).</p>
            <button onclick="closePopup()">OK</button>
        `;
        document.getElementById('notification-popup').classList.add('show');
        document.getElementById('overlay').classList.add('show');
        return false;
    }

    if (newPassword !== confirmPassword) {
        // If the new password and confirm password do not match, show the popup
        document.getElementById('notification-popup').innerHTML = `
            <p>New passwords do not match.</p>
            <button onclick="closePopup()">OK</button>
        `;
        document.getElementById('notification-popup').classList.add('show');
        document.getElementById('overlay').classList.add('show');
        return false;
    }

    return true;
}

function closePopup() {
    document.getElementById('notification-popup').classList.remove('show');
    document.getElementById('overlay').classList.remove('show');
}