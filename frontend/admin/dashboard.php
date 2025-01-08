<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/image/buzznCollectives.jpg">
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
                <li><a href="/settings.php">Settings</a></li>
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

    fetch('/../../../backend/get_appointment_data.php')
        .then(response => response.json())
        .then(data => {
            // Update Overview Cards
            const totalAppointments = data.appointments_by_date.reduce((sum, item) => sum + parseInt(item.total_appointments), 0);
            const totalBarbers = data.appointments_by_barber.length;
            const mostActiveBarber = data.appointments_by_barber.reduce((max, barber) => 
                max.barber_appointments > barber.barber_appointments ? max : barber, { barber: 'N/A', barber_appointments: 0 });

            document.getElementById('total-appointments').textContent = totalAppointments;
            document.getElementById('total-barbers').textContent = totalBarbers;
            document.getElementById('most-active-barber').textContent = `${mostActiveBarber.barber} (${mostActiveBarber.barber_appointments})`;

            // Line Chart: Appointments by Date
            const lineChartLabels = data.appointments_by_date.map(item => item.appointment_date);
            const lineChartData = data.appointments_by_date.map(item => item.total_appointments);

            const lineChartCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineChartCtx, {
                type: 'line',
                data: {
                    labels: lineChartLabels,
                    datasets: [{
                        label: 'Total Appointments',
                        data: lineChartData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Bar Chart: Appointments by Barber
            const barChartLabels = data.appointments_by_barber.map(item => item.barber);
            const barChartData = data.appointments_by_barber.map(item => item.barber_appointments);

            const barChartCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barChartCtx, {
                type: 'bar',
                data: {
                    labels: barChartLabels,
                    datasets: [{
                        label: 'Appointments per Barber',
                        data: barChartData,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
</script>

</body>
</html>
