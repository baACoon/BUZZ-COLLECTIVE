<?php
session_start();

$mysqli = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$successMessage = $errorMessage = "";

// Handle update appointment fee
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_appointment_fee'])) {
    $newFee = (float)$_POST['new_appointment_fee'];
    $query = "UPDATE appointment_fees SET appointment_fee = ? WHERE id = 1";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("d", $newFee);
    
    if ($stmt->execute()) {
        $successMessage = "Appointment fee updated successfully!";
    } else {
        $errorMessage = "Error updating fee: " . $mysqli->error;
    }
    $stmt->close();
}

// Fetch current fee
$result = $mysqli->query("SELECT appointment_fee FROM appointment_fees WHERE id = 1");
$currentFee = $result->fetch_assoc()['appointment_fee'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective - Appointment Fee</title>
    <link rel="icon" type="image/x-icon" href="../design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="Designs/admin-appointmentfee.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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
        <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Close button -->
        <div class="logo">
            <a href="../admin/admin-home.php">
                <img src="images/BUZZ-White.png" alt="Buzz Collective Logo">
            </a>
        </div>
        <nav>
            <ul class="links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="admin-appointment.php">Appointment Bookings</a></li>
                <li><a href="admin-barber.php">Barbers' Schedule</a></li>
                <li class="services">
                    <a href="services.php">Services</a><span class="notification-dot"></span>
                    <ul class="sub-menu">
                        <li><a href="appointment-fee.php">Appointment Fee</a></li>
                    </ul>
                </li>
                <li class="about-us"><a href="admin-aboutus.php">About Us</a></li>
                <li><a href="news.php">News</a></li>
                <li><a href="admin-branches.php">Branches</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </nav>
    </aside>


    <div class="appointment-fee-content">
        <div class="appointment-fee-header">
            <h1>Appointment Fee</h1>
            <?php if ($successMessage): ?>
                <p style="color: green;"><?php echo $successMessage; ?></p>
            <?php elseif ($errorMessage): ?>
                <p style="color: red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </div>

            <form method="POST">
                <label for="new_appointment_fee">Appointment Fee:</label>
                <input type="number" step="0.01" id="new_appointment_fee" name="new_appointment_fee" value="<?php echo $currentFee; ?>" required>
                <button type="submit" class="update-btn">Update Fee</button>
            </form>
   
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
 
</script>
    
</body>
</html>
