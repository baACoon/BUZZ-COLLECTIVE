<?php
session_start();
$appointments = isset($_SESSION['appointments']) ? $_SESSION['appointments'] : [];
unset($_SESSION['appointments']);

// Path to your branches.json file
$json_file = $_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/frontend/admin/data/branches.json';

// Get the contents of the JSON file
$json_data = file_get_contents($json_file);

// Decode the JSON data into a PHP array
$branches = json_decode($json_data, true);

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

    <div class="content">
        <div class="dropdown-container">
            <select id="status" name="status_id">
                <option value="1">Pending</option>
                <option value="2">Confirmed</option>
                <option value="3">Cancelled</option>
            </select>
            <div class="delete-btn">
                <button class="delete-button" id="delete-btn" type="button">DELETE</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
                <button type="button" class="confirm-btn" id="confirm-btn">Confirm</button>
            </div>
        </div>

        <div class="appointments-table-container">
            <h2>Appointments List</h2>
            <form id="delete-form">
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th class="left"><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>Branch</th>
                            <th>Date & Time</th>
                            <th>Booking Data</th>
                            <th>Services</th>
                            <th>Payment Option</th>
                            <th>Reciept</th>
                            <th>Payment Status</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/displayappointment.php');
                        
                        foreach ($appointments as $appointment) {
        
                            $receipt_link = isset($appointment['receipt']) && !empty($appointment['receipt']) 
                            ? "<a href='#' onclick=\"showReceiptModal('/BUZZ-COLLECTIVE/frontend/uploads/receipts/{$appointment['receipt']}')\">View Receipt</a>" 
                            : 'No Receipt Uploaded';

                            $branch_name = 'Main Branch';
                            foreach ($branches as $key => $branch) {
                                if ($branch['branchName'] == $branch_name) {
                                    $branch_location = $branch['branchLocation'];
                                    break; 
                                }
                            }
                            $payment_status = isset($appointment['payment_status_name']) ? $appointment['payment_status_name'] : 'N/A';
                            $payment_display = ($payment_status === 'Paid') ? 'Paid' : 'Unpaid'; 

                            $payment_option = isset($appointment['payment_option']) ? $appointment['payment_option'] : 'Not specified';
                    
                            echo "
                            <tr data-appointment-id='{$appointment['appointment_id']}'>
                                <td><input type='checkbox' name='appointments[]' value='{$appointment['appointment_id']}'></td>
                                <td>{$appointment['appointment_id']}</td>
                                <td>
                                    <strong>Branch Name:</strong> {$branch_name}
                                </td> 
                                <td>
                                    <strong>Date:</strong> {$appointment['date']}<br>
                                    <strong>Time:</strong> {$appointment['timeslot']}
                                </td>
                                <td>
                                    <strong>First Name:</strong> {$appointment['first_name']}<br>
                                    <strong>Last Name:</strong> {$appointment['last_name']}<br>
                                    <strong>Email:</strong> {$appointment['email']}<br>
                                    <strong>Phone Number:</strong> {$appointment['phone_num']}
                                </td>
                                <td>
                                    <strong>Service:</strong> {$appointment['services']}<br>
                                    <strong>Stylist:</strong> {$appointment['barber']}
                                <td>{$payment_option}</td>
                                <td>{$receipt_link}</td>
                                <td>{$payment_display}</td>                                
                                <td>{$appointment['status_name']}</td>
                            </tr>";

                        }
                            ?>
                    </tbody>
                </table>
            </form>
        </div>

        <!-- Receipt Modal -->
        <div id="receiptModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close-btn" onclick="closeReceiptModal()">&times;</span>
                <img id="receiptImage" src="" alt="Receipt Image" style="width: 100%; max-height: 80vh;">
            </div>
        </div>

        <div class="popup" id="popup">
            <div class="popup-content">
                <h2 id="popup-message"></h2>
                <button onclick="closePopup()">OK</button>
            </div>
        </div>
    </div>


    <script>
        // Select or Deselect all checkboxes
        document.getElementById('select-all').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });

        function getSelectedAppointments() {
            var selectedAppointments = [];
            document.querySelectorAll('input[name="appointments[]"]:checked').forEach(function(checkbox) {
                selectedAppointments.push(checkbox.value);
            });
            return selectedAppointments;
        }

        // DELETE event handler
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

        // Confirm button event handler
        document.getElementById('confirm-btn').addEventListener('click', function() {
            var selectedAppointments = getSelectedAppointments();
            if (selectedAppointments.length > 0) {
                var formData = new FormData();
                selectedAppointments.forEach(function(appointmentId) {
                    formData.append('appointments[]', appointmentId);
                });

                fetch('/BUZZ-COLLECTIVE/backend/confirm_appointment.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        document.getElementById('popup-message').innerText = 'Appointment confirmed successfully!';
                        document.getElementById('popup').style.display = 'flex';
                    } else {
                        document.getElementById('popup-message').innerText = 'Error confirming appointment.';
                        document.getElementById('popup').style.display = 'flex';
                    }
                })
                .catch(error => {
                    document.getElementById('popup-message').innerText = 'Error confirming appointment: ' + error.message;
                    document.getElementById('popup').style.display = 'flex';
                });
            } else {
                document.getElementById('popup-message').innerText = 'Please select an appointment to confirm.';
                document.getElementById('popup').style.display = 'flex';
            }
        });

        // Cancel button event handler
        document.getElementById('cancel-btn').addEventListener('click', function() {
            var selectedAppointments = getSelectedAppointments();
            if (selectedAppointments.length > 0) {
                var formData = new FormData();
                selectedAppointments.forEach(function(appointmentId) {
                    formData.append('appointments[]', appointmentId);
                });

                fetch('/BUZZ-COLLECTIVE/backend/cancel_appointment.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        document.getElementById('popup-message').innerText = 'Appointment canceled successfully!';
                        document.getElementById('popup').style.display = 'flex';
                    } else {
                        document.getElementById('popup-message').innerText = 'Error canceling appointment.';
                        document.getElementById('popup').style.display = 'flex';
                    }
                })
                .catch(error => {
                    document.getElementById('popup-message').innerText = 'Error canceling appointment: ' + error.message;
                    document.getElementById('popup').style.display = 'flex';
                });
            } else {
                document.getElementById('popup-message').innerText = 'Please select an appointment to cancel.';
                document.getElementById('popup').style.display = 'flex';
            }
        });
        
        function showReceiptModal(imageUrl) {
            document.getElementById('receiptImage').src = imageUrl;
            // Show the modal
            document.getElementById('receiptModal').style.display = 'block';
        }

        function closeReceiptModal() {
            // Hide the modal
            document.getElementById('receiptModal').style.display = 'none';
            document.getElementById('receiptImage').src = '';
        }

        // Status dropdown change event handler
        var statusDropdown = document.getElementById('status');
        statusDropdown.addEventListener('change', function() {
            var selectedStatus = this.value;
            var appointmentRows = document.querySelectorAll('tbody tr');

            // Loop through each appointment row
            appointmentRows.forEach(function(row) {
                var currentStatus = row.cells[5].innerText.trim(); 

                // Show/Hide rows based on selected status
                if ((selectedStatus === '1' && currentStatus === 'Pending') ||
                    (selectedStatus === '2' && currentStatus === 'Confirmed') ||
                    (selectedStatus === '3' && currentStatus === 'Cancelled')) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>