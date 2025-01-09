<?php
session_start();

$appointments = isset($_SESSION['appointments']) ? $_SESSION['appointments'] : [];
unset($_SESSION['appointments']);

// Path to your branches.json file
$json_file = $_SERVER['DOCUMENT_ROOT'] . '/../../admin/data/branches.json';

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
    <link rel="icon" type="image/x-icon" href="/images/buzznCollectives.jpg">
    <link rel="stylesheet" href="/Designs/adminappointment.css">
    <base href="https://admin.buzzcollective.gayvar.com/Buzz-collective/frontend/admin/">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <!-- Navbar for screens below 768px -->
    <div class="mobile-navbar" id="mobile-navbar">
        <div class="mobile-logo">
            <img src="/images/BUZZ-Black.png" alt="Buzz Collective Logo">
        </div>
        <i class='bx bx-menu' id="menu-icon"></i>
    </div>
    <aside class="sidebar">
        <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Add this line for the close button -->
        <div class="logo">
            <a href="/admin-home.php">
                <img src="/images/BUZZ-White.png" alt="Buzz Collective Logo">
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="/dashboard.php">Dashboard</a></li>
                <li><a href="/admin-appointment.php">Appointment Bookings</a></li>
                <li><a href="/admin-barber.php">Barbers' Schedule</a></li>
                <li><a href="/services.php">Services</a><span class="notification-dot"></span></li>
                <li><a href="/admin-aboutus.php">About Us</a></li>
                <li><a href="/news.php">News</a></li>
                <li><a href="/admin-branches.php">Branches</a></li>
                <li><a href="/adminprofile.php">Admin Profile </a></li>
            </ul>
        </nav>
    </aside>

    <div class="content">
        <div class="dropdown-container">
            <select id="status" name="status_id">
                <option value="0">All</option>
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
                         include(__DIR__ . '/../../backend/displayappointment.php'); 
                        
                        foreach ($appointments as $appointment) {
        
                            $receipt_link = isset($appointment['receipt']) && !empty($appointment['receipt']) 
                            ? "<a href='#' class='view-receipt' onclick=\"showReceiptModal('/uploads/receipts/{$appointment['receipt']}')\">View Receipt</a>" 
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


    <script src="/appointment.js"> </script>
</body>
</html>