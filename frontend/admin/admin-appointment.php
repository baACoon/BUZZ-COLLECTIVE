<?php

// Retrieve the appointments data from session
$appointments = isset($_SESSION['appointments']) ? $_SESSION['appointments'] : [];

// Clear the appointments data from session
unset($_SESSION['appointments']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Buzz & Collective</title>
    <link rel="stylesheet" href="Designs/adminappointment.css">
</head>
<body>
             <aside class="sidebar">
                <div class="logo">
                    <img src="images/BUZZ-White.png" alt="Buzz Collective Logo">
                 </div>
                    <nav>
                        <ul>
                        <li><a href="admin-appointment.php">Appointment Bookings</a></li>
                        <li><a href="admin-barber.php">Barbers' Schedule</a></li>
                        <li><a href="services.php">Services</a><span class="notification-dot"></span></li>
                        <li><a href="admin-aboutus.php">About Us</a></li>
                        <li><a href="news.php">News</a></li>
                        <li><a href="admin-branches.php">Branches</a></li>
                        <li><a href="clientprofile.php">Client Profile</a></li>
                        <li><a href="settings.php">Settings</a></li>
                        </ul>
                    </nav>
                 </aside>

        <div class="dropdown-container">
                <select id="status" name="status">
                    <option value="Pending">Pending</option>
                    <option value="Complete">Complete</option>
                    <option value="Noshow">No show</option>
                </select>
                
                <div class="delete-btn">
                    <button class="delete-button" id="delete-btn" type="button">DELETE</button>
                </div>
        </div>

           

    <div class="appointments-table-container">
        <h2>Appointments List</h2>
        <form id="delete-form">
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th class="left"><input type="checkbox" id="select-all"></th>
                        <th >ID</th>
                        <th>Booking Data</th>
                        <th>Services</th>
                        <th>Booking Date & Time</th>
                        <th class="right">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/displayappointment.php'); 
                ?>                
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
            document.getElementById('delete-btn').addEventListener('click', function() {
            var form = document.getElementById('delete-form');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/BUZZ-COLLECTIVE/backend/delete_appointment.php', true);
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
