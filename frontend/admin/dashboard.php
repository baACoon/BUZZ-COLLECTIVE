<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images/buzznCollectives.jpg">
    <link rel="stylesheet" href="/Designs/dashboard.css?v=901">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <base href="https://admin.buzzcollective.gayvar.com/Buzz-collective/frontend/admin">
    <title>DASHBOARD</title>
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

    <div class="dashboard-content">
    <h1>DASHBOARD</h1>

    <!-- Overview Cards -->
    <div class="overview-cards">
        <div class="card">
            <h3>Total Appointments</h3>
            <p id="total-appointments">0</p>
        </div>
        <div class="card">
            <h3>Unique Barbers</h3>
            <p id="total-barbers">0</p>
        </div>
        <div class="card">
            <h3>Most Active Barber</h3>
            <p id="most-active-barber">N/A</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="container">
        <!-- Line Chart for Appointments Over Time -->
        <div class="chart">
            <h3>Appointments Over Time</h3>
            <canvas id="lineChart"></canvas>
        </div>

        <!-- Bar Chart for Appointments by Barber -->
        <div class="chart">
            <h3>Appointments by Barber</h3>
            <canvas id="barChart"></canvas>
        </div>
    </div>
</div>

    <!-- Script -->
    <script src="/dashboard.js"></script>

</body>
</html>
