<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/terms.css">
    <title>Document</title>
</head>
<body>
<div class="terms-container">
        <label>
            <input type="checkbox" id="termsCheckbox">
            I agree to the <a href="#" id="termslink">terms and conditions</a>.
        </label>
    </div>
    <div id="myModal" class="modal" style="display:none;">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Terms and Conditions for Appointmenr Scheduling</h2>
        </div>
        <div class="modal-body" >
        <p>1. General Appointment Scheduling
            We offer two convenient ways to schedule an appointment with our barbershop: through walk-ins or by booking online via our website.
            Walk-ins: Customers are welcome to visit our shop without a prior appointment; however, walk-ins will be assisted on a first-come, first-served basis, and wait times may vary depending on the number of clients.
            Online Booking: Clients can schedule an appointment directly through our website. Simply fill out the booking form, which allows you to select your preferred date, time, and barber. The appointment is only confirmed after successful payment of the booking fee (details below).</p>

            <p> Barber Availability
            Each barber has a specific weekly schedule, which is updated regularly on our website. Customers can choose their preferred barber when booking online, but the selected time must align with the barber’s availability.
            Appointments can be made up to 2 hours in advance. We do not accept last-minute or on-the-spot bookings unless the chosen barber is available for the requested time.
            Walk-in customers may be assigned the next available barber if they do not have a preference.</p>

            <p>3. Booking Fee and Payment
            A non-refundable booking fee of 150 PHP is required to confirm any appointment.
            Payment must be made through GCash at the time of booking on the website. A screenshot of the successful payment must be uploaded. Appointments are only confirmed after both filling out the booking form and payment have been submitted.
            The booking fee is separate from the service fee for the haircut or other services you select. The booking fee serves to secure your slot with your preferred barber. </p>

            <p>4. Service Fees
            Service fees vary depending on the specific services requested (e.g., haircut, beard trim, styling). These fees are separate from the booking fee and will be charged at the barbershop after the service has been provided. Payment for services can be made in cash or through other payment methods accepted at the shop.</p>

            <p>5. Appointment Changes and Cancellations
            Cancellations are not accepted once the appointment is confirmed. The 150 PHP booking fee is non-refundable regardless of whether the customer shows up for the appointment or not.
            Appointment modifications (such as rescheduling) are allowed up to 2 hours before the appointment time. Once it is within 2 hours of the appointment, no changes will be accepted.
            If you are late to your appointment, we will hold your booking for a maximum of 15 minutes. After this period, your appointment may be forfeited, and walk-in customers may be prioritized.</p>

            <p>6. Walk-ins
            We accept walk-ins; however, walk-in customers will be assisted based on the availability of our barbers.
            Walk-in clients may need to wait if all barbers are busy with appointments. The estimated waiting time will be communicated to you upon arrival.
            We cannot guarantee immediate service for walk-ins, as appointments take priority.</p>

            <p>7. Customer Responsibility
            Customers are expected to arrive on time for their appointments and provide accurate information during the booking process.
            No-shows or late cancellations will result in the loss of the 150 PHP booking fee.
            Customers who repeatedly miss appointments without proper notice may be refused future bookings.</p>

            <p>8. Changes to Terms and Conditions
            We reserve the right to modify these terms and conditions at any time. Any updates will be posted on our website, and customers are responsible for reviewing the terms periodically.
            By booking an appointment through our website, you acknowledge and agree to these terms and conditions.</p>
        </div>
        <div class="modal-footer">
        <h3>I agree</h3>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        // Get the modal
            var modal = document.getElementById("myModal");

            // Get the link that opens the modal
            var termsLink = document.getElementById("termslink");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the link, open the modal
            termsLink.onclick = function(event) {
                event.preventDefault(); // Prevent default anchor behavior
                modal.style.display = "block"; // Show the modal
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none"; // Hide the modal
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none"; // Hide the modal
                }
            }
        });
    </script>
</body>
</html>