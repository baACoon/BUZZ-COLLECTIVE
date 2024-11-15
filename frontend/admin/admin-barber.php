<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/adminbarber.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Designs/adminbarber.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Barber Schedule</title>
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
                <li><a href="services.php">Services</a><span class="notification-dot"></span></li>
                <li><a href="admin-aboutus.php">About Us</a></li>
                <li><a href="news.php">News</a></li>
                <li><a href="admin-branches.php">Branches</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </nav>
    </aside>

    <div class="dropdown-container">
        <form method="get" action="/BUZZ-COLLECTIVE/frontend/admin/admin-barber.php">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $startDate; ?>">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $endDate; ?>">
            <input type="submit" value="Show Availability" class="show-btn"> 
        </form>
    </div>

    <div class="container">
        <div class="barbers-header">
            <h1>BARBERS' AVAILABILITY</h1>
            <h1 class="date">(<?php echo date('F j', strtotime($startDate)) . ' - ' . date('F j, Y', strtotime($endDate)); ?>)</h1>
        
        </div>

        <!-- Wrapper for schedule and editable form -->
        <div class="schedule-wrapper">
            <!-- Display current schedule from the database -->
            <table id="scheduleTable">
                <thead class="barbers">
                    <tr>
                        <th class="schedule">Day</th>
                        <?php foreach ($barbers as $barber): ?>
                            <th><?php echo $barber; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="barber-container">
                    <?php foreach ($daysOfWeek as $index => $day): ?>
                        <?php $date = date('Y-m-d', strtotime("$startDate +$index days")); ?>
                        <tr>
                            <td><?php echo $day; ?></td>
                            <?php foreach ($barbers as $barber): ?>
                                <td>
                                    <?php 
                                    // Display a checkmark if the barber is available, otherwise display an empty space
                                    echo isset($availability[$barber][$date]) && $availability[$barber][$date] ? '✔️' : '❌'; 
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                <button id="editButton" class="edit-btn">Edit</button>
               
                <!-- Editable form, initially hidden, appears when the Edit button is clicked -->
                <form id="availabilityForm" method="post" action="update_availability.php" style="display: none;">
                    <table>
                        <thead class="barbers">
                            <tr>
                                <th class="schedule">Day</th>
                                <?php foreach ($barbers as $barber): ?>
                                    <th><?php echo $barber; ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody class="barber-container">
                            <?php foreach ($daysOfWeek as $index => $day): ?>
                                <?php $date = date('Y-m-d', strtotime("$startDate +$index days")); ?>
                                <tr>
                                    <td><?php echo $day; ?></td>
                                    <?php foreach ($barbers as $barber): ?>
                                        <td>
                                            <input type="checkbox" name="availability[<?php echo $barber; ?>][<?php echo $date; ?>]" value="1"
                                                <?php echo isset($availability[$barber][$date]) && $availability[$barber][$date] ? 'checked' : ''; ?>>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <input type="hidden" name="start_date" value="<?php echo $startDate; ?>">
                    <input type="hidden" name="end_date" value="<?php echo $endDate; ?>">
                    <input type="submit" value="Save" class="save-btn">
                </form>
            </div>
    </div>

        <!-- Modal for Save Status -->
        <div id="saveModal" class="modal">
            <div class="modal-content">
                <span id="modal-message"></span>
                <button id="closeModal" onclick="closeModal()">OK</button>
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

            // Toggle between showing the schedule and the availability form
            const editButton = document.getElementById('editButton');
            const form = document.getElementById('availabilityForm');
            const scheduleTable = document.getElementById('scheduleTable');

            editButton.addEventListener('click', function() {
                if (form.style.display === 'none') {
                    form.style.display = 'block'; // Show the form with checkboxes
                    scheduleTable.style.display = 'none'; // Hide the schedule
                    editButton.style.display = 'none'; // Hide the edit button
                }
            });

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Collect form data
                const formData = new FormData(this);

                // Send the form data using Fetch API
                fetch('update_availability.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showModal('Barber availability saved successfully!');
                        toggleToViewMode(); // Go back to the view mode after saving
                    } else {
                        showModal('Failed to save barber availability.');
                    }
                })
                .catch(error => {
                    console.error('Error saving availability:', error);
                    showModal('An error occurred while saving.');
                });
            });

            function toggleToViewMode() {
                form.style.display = 'none'; // Hide the form
                scheduleTable.style.display = 'block'; // Show the schedule
                editButton.style.display = 'block'; // Show the edit button again
            }

            function showModal(message) {
                document.getElementById('modal-message').textContent = message;
                document.getElementById('saveModal').style.display = 'block';
            }

            function closeModal() {
                document.getElementById('saveModal').style.display = 'none';
            }
        </script>

    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            text-align: center;
        }

        #closeModal {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

    
    </style>

</body>
</html>
