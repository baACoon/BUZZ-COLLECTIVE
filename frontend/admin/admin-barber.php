<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/admindash.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Designs/adminbarber.css">
    <title>Barber Schedule</title>
</head>
<body>


        
        <div class="sidebar">
                <h2>BUZZ Collective</h2>
                <nav>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li><a href="#">Barber Schedule</a></li>
                        <li><a href="">News and Events</a></li>
                        <li><a href="">About us</a></li>
                        <li><a href="#">Appointment Bookings</a></li>
                        <li><a href="#">Settins</a></li>
                        <li><a href="#">Reports and Analytics</a></li>
                        <li><a href="admin-home.php">Logout</a></li>
                    </ul>
                </nav>
        </div>
<div class="container">
        <h1>Barbers' Availability (Apr 22 - 28, 2024)</h1>
        <div id="schedule">
            <table>
                <tr>
                    <th>Barber</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($barbers as $barber): ?>
                    <tr>
                        <td><img src="avatar.png" alt="<?php echo $barbers['name']; ?>"><?php echo $barbers['name']; ?></td>
                        <?php foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day): ?>
                            <td>
                                <input type="checkbox" <?php echo $barbers[$day] ? 'checked' : ''; ?> data-id="<?php echo $barber['id']; ?>" data-day="<?php echo $day; ?>">
                            </td>
                        <?php endforeach; ?>
                        <td><button class="save" data-id="<?php echo $barbers['id']; ?>">Save</button></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <script>
        document.querySelectorAll('.save').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const availability = {};
                document.querySelectorAll(`input[data-id="${id}"]`).forEach(input => {
                    availability[input.getAttribute('data-day')] = input.checked ? 1 : 0;
                });

                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id, availability })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    alert('Error updating availability');
                    console.error('Error:', error);
                });
            });
        });

    </script>
</body>
</html>
