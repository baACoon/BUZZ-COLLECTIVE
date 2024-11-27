<?php 
include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/adminbarber.php'); 
// Handle availability form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['availability'])) {
    $mysqli = new mysqli('localhost', 'root', '', 'barbershop');
    
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $response = ['success' => false, 'error' => ''];
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    if (empty($startDate) || empty($endDate)) {
        $response['error'] = 'Start date and end date are required';
    } else {
        try {
            $mysqli->begin_transaction();

            // Remove existing availability within the selected range
            $stmt = $mysqli->prepare("DELETE FROM barber_availability WHERE date BETWEEN ? AND ?");
            $stmt->bind_param('ss', $startDate, $endDate);
            $stmt->execute();
            $stmt->close();

            // Insert new availability
            if (isset($_POST['availability']) && is_array($_POST['availability'])) {
                $stmt = $mysqli->prepare("INSERT INTO barber_availability (barber_name, date, is_available) VALUES (?, ?, ?)");
                
                foreach ($_POST['availability'] as $barber => $dates) {
                    foreach ($dates as $date => $available) {
                        $isAvailable = 1;
                        $stmt->bind_param('ssi', $barber, $date, $isAvailable);
                        $stmt->execute();
                    }
                }
                
                $stmt->close();
            }

            // Set availability to 0 for unchecked dates
            $allBarbers = [];
            $barberQuery = "SELECT name FROM barbers";
            $result = $mysqli->query($barberQuery);
            while ($row = $result->fetch_assoc()) {
                $allBarbers[] = $row['name'];
            }

            $currentDate = new DateTime($startDate);
            $endDateTime = new DateTime($endDate);
            
            while ($currentDate <= $endDateTime) {
                $currentDateStr = $currentDate->format('Y-m-d');
                
                foreach ($allBarbers as $barber) {
                    if (!isset($_POST['availability'][$barber][$currentDateStr])) {
                        $isAvailable = 0;
                        $stmt = $mysqli->prepare("INSERT INTO barber_availability (barber_name, date, is_available) VALUES (?, ?, ?)");
                        $stmt->bind_param('ssi', $barber, $currentDateStr, $isAvailable);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
                
                $currentDate->modify('+1 day');
            }

            $mysqli->commit();
            $success = true;
            header("Location: /BUZZ-COLLECTIVE/frontend/admin/admin-barber.php?start_date=$startDate&end_date=$endDate&success=true");
            exit;
        } catch (Exception $e) {
            $mysqli->rollback();
            header("Location: /BUZZ-COLLECTIVE/frontend/admin/admin-barber.php?start_date=$startDate&end_date=$endDate&error=" . urlencode($e->getMessage()));
            exit;
        }
    }
    $mysqli->close();
}


// Show success message if redirected after successful update
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    echo "<script>
        window.onload = function() {
            showSuccessModal('Barber availability has been successfully updated!');
            // Remove success parameter from URL
            let url = new URL(window.location.href);
            url.searchParams.delete('success');
            window.history.replaceState({}, '', url);
        }
    </script>";
}

// Show error message if there was an error
if (isset($_GET['error'])) {
    echo "<script>
        window.onload = function() {
            showModal('Failed to update availability: " . htmlspecialchars($_GET['error']) . "');
            // Remove error parameter from URL
            let url = new URL(window.location.href);
            url.searchParams.delete('error');
            window.history.replaceState({}, '', url);
        }
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../design/image/buzznCollectives.jpg">
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
            <a href="../admin/admin-home.php">
                <img src="images/BUZZ-White.png" alt="Buzz Collective Logo">
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="admin-appointment.php">Appointment Bookings</a></li>
                <li><a href="admin-barber.php">Barbers' Schedule</a></li>
                <li><a href="services.php">Services</a></li>
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
                        <?php foreach ($barbers as $index => $barber): ?>
                            <th>
                                <span id="barberName<?php echo $index; ?>"><?php echo $barber; ?></span>
                            </th>
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
                                    echo isset($availability[$barber][$date]) && $availability[$barber][$date] ? '✔️' : '❌'; 
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <button id="editButton" class="edit-btn">Edit Availability</button>
            <button id="editNamesButton" class="edit-btn">Edit Barber Names</button>
         
            <!-- Editable form for availability -->
            <form id="availabilityForm" method="post" style="display: none;">
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

            <!-- New form for editing barber names -->
            <form id="barberNamesForm" method="post" action="/BUZZ-COLLECTIVE/backend/update_barbers_name.php" style="display: none;">
                <!-- Add a button and input for new barber -->
                <div class="add-barber-section">
                    <input type="text" id="newBarberName" placeholder="Enter new barber name">
                    <button type="button" id="addBarberButton" class="add-btn">Add Barber</button>
                </div>
                <table class="editbarbers">
                    <thead>
                        <tr>
                            <th>Current Name</th>
                            <th>New Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barbers as $index => $barber): ?>
                            <tr>
                                <td><?php echo $barber; ?></td>
                                <td>
                                    <input type="text" name="barber_names[<?php echo $index; ?>]" 
                                           value="<?php echo $barber; ?>" 
                                           placeholder="Enter new name">
                                    <input type="hidden" name="original_names[<?php echo $index; ?>]" 
                                           value="<?php echo $barber; ?>">
                                </td>
                                <td>
                                    <button type="button" class="delete-btn" data-barber="<?php echo $barber; ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="submit" value="Save Names" class="save-btn">
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

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content success">
            <div class="modal-header">
                <h2>Success!</h2>
            </div>
            <div class="modal-body">
                <i class="fas fa-check-circle"></i>
                <p id="success-message"></p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn" onclick="closeSuccessModal()">OK</button>
            </div>
        </div>
    </div>

    <script>
        // Existing menu icon and toggle script remains the same

        // Add new script for barber names editing
        const editNamesButton = document.getElementById('editNamesButton');
        const barberNamesForm = document.getElementById('barberNamesForm');
        const scheduleTable = document.getElementById('scheduleTable');
        const editButton = document.getElementById('editButton');
        const availabilityForm = document.getElementById('availabilityForm');

        // Edit Availability Button Click
        editButton.addEventListener('click', function() {
            if (availabilityForm.style.display === 'none') {
                availabilityForm.style.display = 'block';
                scheduleTable.style.display = 'none';
                editButton.style.display = 'none';
                editNamesButton.style.display = 'none';
            }
        });

        editNamesButton.addEventListener('click', function() {
            if (barberNamesForm.style.display === 'none') {
                barberNamesForm.style.display = 'block';
                scheduleTable.style.display = 'none';
                editButton.style.display = 'none';
                editNamesButton.style.display = 'none';
            }
        });

        // Update existing toggleToViewMode function
        function toggleToViewMode() {
            availabilityForm.style.display = 'none';
            barberNamesForm.style.display = 'none';
            scheduleTable.style.display = 'block';
            editButton.style.display = 'block';
            editNamesButton.style.display = 'block';
        }

        const addBarberButton = document.getElementById('addBarberButton');
        const newBarberNameInput = document.getElementById('newBarberName');

        addBarberButton.addEventListener('click', function() {
            const newBarberName = newBarberNameInput.value.trim();
            if (newBarberName) {
                fetch('/BUZZ-COLLECTIVE/backend/update_barbers_name.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=add&barber_name=${encodeURIComponent(newBarberName)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessModal(`Barber "${newBarberName}" has been successfully added!`);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showModal('Failed to add barber: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showModal('An error occurred while adding the barber.');
                });
            } else {
                showModal('Please enter a barber name.');
            }
        });
        // Fix for name saving
        barberNamesForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            formData.append('action', 'update');

            fetch('/BUZZ-COLLECTIVE/backend/update_barbers_name.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessModal('Barber names have been successfully updated!');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showModal('Failed to save barber names: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error saving barber names:', error);
                showModal('An error occurred while saving.');
            });
        });



        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this barber?')) {
                    const barberName = this.getAttribute('data-barber');
                    
                    fetch('/BUZZ-COLLECTIVE/backend/update_barbers_name.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=delete&barber_name=${encodeURIComponent(barberName)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showSuccessModal(`Barber "${barberName}" has been successfully deleted!`);
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showModal('Failed to delete barber: ' + (data.error || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showModal('An error occurred while deleting the barber.');
                    });
                }
            });
        });

    function showSuccessModal(message) {
        const modal = document.getElementById('successModal');
        const messageElement = document.getElementById('success-message');
        messageElement.textContent = message;
        modal.style.display = 'block';
}

    function closeSuccessModal() {
        const modal = document.getElementById('successModal');
        modal.style.display = 'none';
        location.reload();
    }
    </script>
</body>
</html>