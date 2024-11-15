<?php 
$clients = isset($_SESSION['users']) ? $_SESSION['users'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Designs/adminclientprof.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Client Profile</title>
</head>
<body>
     <!-- Navbar for screens below 768px -->
     <div class="mobile-navbar" id="mobile-navbar">
        <div class="mobile-logo">
            <img src="images/BUZZ-Black.png" alt="Buzz Collective Logo">
        </div>
        <i class='bx bx-menu' id="menu-icon"></i>
    </div>
    
    <aside class="sidebar" id="sidebar">
        <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Add this line for the close button -->
        <div class="logo">
            <img src="images/BUZZ-White.png" alt="Buzz Collective Logo">
        </div>
        <nav>
            <ul>
                <li><a href="admin-appointment.php">Appointment Bookings</a></li>
                <li><a href="admin-barber.php">Barbers' Schedule</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="admin-aboutus.php">About Us</a></li>
                <li><a href="news.php">News</a></li>
                <li><a href="admin-branches.php">Branches</a></li>
                <li><a href="clientprofile.php">Client Profile</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </nav>
    </aside>

    <div class="clntprfl">
        <h1>CLIENT PROFILE</h1>
    </div>

    <div id="crud-btn">
        <div class="add-btn">
            <button class="add-button"><a href="">ADD</a></button>
        </div>
        <div class="view-btn">
            <button class="view-button"><a href="">VIEW</a></button>
        </div>
        <div class="delete-btn">
            <button class="delete-button" id="delete-btn" type="button">DELETE</button>
        </div>
    </div>

    <div class="client-table-container">
        <form id="delete-form">
            <table class="client-table">
                <thead>
                    <tr>
                        <th class="left"><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th class="right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/adminclient.php'); ?>
                </tbody>
            </table>
        </form>
    </div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <h2 id="popup-message"></h2>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>

    <script>
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
        
        document.getElementById('delete-btn').addEventListener('click', function() {
            var form = document.getElementById('delete-form');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/BUZZ-COLLECTIVE/backend/delete_client.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('popup-message').innerText = response.message;
                    document.getElementById('popup').style.display = 'flex';
                }
            };
            xhr.send(formData);
        });

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            location.reload();
        }

        // Select or Deselect all checkboxes
        document.getElementById('select-all').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });
    </script>
</body>
</html>
