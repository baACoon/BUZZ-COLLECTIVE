<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Admin View</title>
    <link rel="stylesheet" href="Designs/adminappointment.css">
</head>
<body>
    <div class="main-content">
        <h1>Appointments</h1>
        
        <div class="appointments-table-container">
            <h2>Appointments List</h2>
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>ID</th>
                        <th>Booking Data</th>
                        <th>Services</th>
                        <th>Booking Date & Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php include('backend.php'); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
