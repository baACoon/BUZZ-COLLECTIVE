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

fetch('https://admin.buzzcollective.gayvar.com/frontend/admin/get_appointment_data.php')
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