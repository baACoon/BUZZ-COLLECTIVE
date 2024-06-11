<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Buzz & Collective</title>
    <link rel="stylesheet" href="Designs/adminappointment.css">
</head>
<body>
    <div class="main-content">
        <h1>Appointments</h1>
        
        <div class="appointment-form">
            <h2>Add New Appointment</h2>
            <form action="backend.php" method="post">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required><br>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone_num" required><br>

                <label for="service">Service:</label>
                <input type="text" id="service" name="services" required><br>

                <label for="stylist">Stylist:</label>
                <input type="text" id="stylist" name="barber" required><br>

                <label for="date">Date:</label>
                <input type="text" id="date" name="appointment_date" required><br>

                <label for="time">Time:</label>
                <input type="text" id="time" name="appointment_time" required><br>

                <label for="status">Status:</label>
                <input type="text" id="status" name="status" required><br>

                <input type="submit" name="submit" value="Add Appointment">
            </form>
        </div>
    </div>
</body>
</html>
