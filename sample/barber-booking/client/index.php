<!-- client/index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Barber Shop Booking</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Book Your Appointment</h1>
        
        <!-- Step 1: Appointment Details -->
        <div id="appointmentForm" class="booking-step">
            <h2>Enter Appointment Details</h2>
            <form id="bookingForm" action="book-appointment.php" method="POST">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" required>
                </div>
                
                <div class="form-group">
                    <label>Phone Number:</label>
                    <input type="tel" name="phone_number" required>
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Service:</label>
                    <select name="service" required>
                        <option value="">Select Service</option>
                        <option value="Haircut">Haircut - ₱150</option>
                        <option value="Shave">Shave - ₱100</option>
                        <option value="Hair Color">Hair Color - ₱500</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Barber:</label>
                    <select name="barber" required>
                        <option value="">Select Barber</option>
                        <option value="John">John</option>
                        <option value="Mike">Mike</option>
                        <option value="Dave">Dave</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Date:</label>
                    <input type="date" name="appointment_date" required>
                </div>
                
                <div class="form-group">
                    <label>Time:</label>
                    <input type="time" name="appointment_time" required>
                </div>
                
                <button type="submit">Book Appointment</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#bookingForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'book-appointment.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if(response.success) {
                            window.location.href = 'upload-payment.php?id=' + response.appointment_id;
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>