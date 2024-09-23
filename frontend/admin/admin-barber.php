<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/adminbarber.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Designs/adminbarber.css">
    <title>Barber Schedule</title>
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

       
    </div>
  
    <div class="dropdown-container">
        <form method="get" action="/BUZZ-COLLECTIVE/frontend/admin/admin-barber.php">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $startDate; ?>">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $endDate; ?>">
            <input type="submit" value="Show Availability">
        </form>
    </div>

    <div class="container">
        <form id="availability-form" method="post" action="update_availability.php">
            <table>
                <div class="barbers-header">
                    <h1>BARBERS' AVAILABILITY</h1>
                    <h1 class="date">(APRIL 22 - 28, 2024)</h1>
                    <a href="#"><i class="fa-regular fa-pen-to-square" style="color: #000000;"></i></a>
                </div>
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
            <input type="submit" value="Save">
        </form>
    </div>
    <!-- Modal for Save Status -->
    <div id="saveModal" class="modal">
        <div class="modal-content">
            <span id="modal-message"></span>
            <button id="closeModal" onclick="closeModal()">OK</button>
        </div>
    </div>



    <script>
        document.getElementById('availability-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the usual way

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
            } else {
                showModal('Failed to save barber availability.');
            }
        })
        .catch(error => {
            console.error('Error saving availability:', error);
            showModal('An error occurred while saving.'); // Ensure this message matches the context
        });
    });

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
