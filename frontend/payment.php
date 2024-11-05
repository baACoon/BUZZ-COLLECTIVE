<?php
$target_dir = "uploads/";  // Folder to store uploaded images

// Check if form was submitted and file is uploaded
if (isset($_POST["submit"]) && isset($_FILES["receipt"]) && $_FILES["receipt"]["error"] == 0) {

    $target_file = $target_dir . basename($_FILES["receipt"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["receipt"]["tmp_name"]);
    if ($check === false) {
        // Don't echo anything here, instead store the error message in a variable
        $error = "File is not an image.";
    }

    // Check if the file already exists
    if (file_exists($target_file)) {
        $error = "Sorry, file already exists.";
    }

    // Check file size (limit to 5MB)
    if ($_FILES["receipt"]["size"] > 5000000) {
        $error = "Sorry, your file is too large.";
    }

    // Allow certain file formats (JPEG, PNG, JPG, GIF)
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Try to move the uploaded file to the target folder
    if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file)) {
        // Save the file information in the database
        $conn = new mysqli("localhost", "root", "", "barbershop");  // Make sure credentials are correct

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $image_name = basename($_FILES["receipt"]["name"]);
        $appointment_id = intval($_POST["appointment_id"]);
        $sql = "INSERT INTO appointments (receipt, receipt_path) VALUES ('$image_name', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to receipt.php after successful upload
            header("Location: receipt.php");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        $error = "Sorry, there was an error uploading your file.";
    }

    // If there's an error, display it
    if (isset($error)) {
        echo $error;
    }

} else {
    if (isset($_POST["submit"])) {
        // Check for specific file upload error
        if (isset($_FILES["receipt"]["error"])) {
            echo "Error during file upload: " . $_FILES["receipt"]["error"];
        } else {
            echo "No file was uploaded or there was an error with the upload.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/payment.css">
    <link rel="stylesheet" href="../frontend/design/terms.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Buzz & Collective - Payment</title>
</head>
<body>
    <div class="confirmation-form">
        <h2>Buzz & Collective Confirmation</h2>
        <p>MAIN BRANCH</p>
    </div>

    <p class="payment-opt">PAYMENT OPTION</p>

    <div class="payment-section">
        <div class="payment-container" id="fullPayment">
            <h1>400</h1>
            <p>PHP</p>
            <h3>Full Payment</h3>
            <h5>(Service + Appointment Fee)</h5>
            <h5>Refund available</h5>
        </div>

        <div class="payment-container" id="appointmentFee">
            <h1>150</h1>
            <p>PHP</p>
            <h3>Appointment Fee</h3>
        </div>
    </div>

    <!-- Terms and Conditions Section -->
    <div class="terms-container">
        <label>
            <input type="checkbox" id="termsCheckbox">
            I agree to the <a href="" id="termslink">terms and conditions</a>.
        </label>
    </div>
    <div id="myModal" class="modal" style="display:none;">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Terms and Conditions for Appointment Scheduling</h2>
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
            <button class="agree">I agree</button>
        </div>
    </div>
    </div>

    <div class="mop">
        <p style="color: white;">MODE OF PAYMENT</p>
        <div class="mop-container">
            <div class="mop-gcash">
                <!-- GCash button will be disabled initially -->
                <button id="gcashButton" class="disabled" disabled>
                    <img src="../frontend/design/image/GCash_logo.svg.png" alt="GCash Logo">
                </button>
            </div>
        </div>
    </div>

    <!-- Custom popup for GCash -->
    <div class="custom-popup" id="gcashPopup">
        <i class='bx bx-x' id="closePopup"></i> <!-- Add this line for the close button -->
        <h2>UPLOAD SCREENSHOT</h2>
        <div class="gcash-container">
            <div class="gcash-text">
                <p>SEND TO</p>
                <h3>0960 520 5411</h3>
            </div>
            <img src="../frontend/design/image/QRGacsh.jpg" alt="GCASH QR Code">
        </div>
        <div class="receipt-upload">
            <!-- <h4>UPLOAD GCASH RECEIPT</h4> -->
            <form id="receiptForm" method="POST" enctype="multipart/form-data">
                <label class="file-label">
                    <input type="file" name="receipt" accept="image/*" required onchange="updateFileName(this)">
                    <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">  <!-- Replace with the actual ID -->
                    <span id="file-label-text">UPLOAD RECEIPT</span>
                </label>
                <button type="submit" name="submit"class="submit-button">SUBMIT</button>
            </form>
        </div>
    </div>

    <script>
        // Disable GCash button on page load
        document.addEventListener('DOMContentLoaded', function() {
            var gcashButton = document.getElementById('gcashButton');
            gcashButton.disabled = true; // Make sure it's disabled by default
        });

        // Toggle payment option
        document.getElementById('fullPayment').addEventListener('click', function() {
            toggleActive('fullPayment');
        });

        document.getElementById('appointmentFee').addEventListener('click', function() {
            toggleActive('appointmentFee');
        });

        function toggleActive(containerId) {
            var containers = document.querySelectorAll('.payment-container');
            containers.forEach(container => {
                container.classList.remove('active');
                container.style.color = ''; // Reset color
            });
            
            var activeContainer = document.getElementById(containerId);
            activeContainer.classList.add('active');
            activeContainer.style.color = 'black'; // Change text color to black
        }

        // GCash popup logic
        var gcashButton = document.getElementById('gcashButton');
        var gcashPopup = document.getElementById('gcashPopup');
        var closePopup = document.getElementById('closePopup');

        gcashButton.addEventListener('click', function() {
            gcashPopup.style.display = 'block';
        });

        closePopup.addEventListener('click', function() {
            gcashPopup.style.display = 'none';
        });

       // File input label update
        function updateFileName(input) {
            var fileName = input.files[0].name;
            document.getElementById('file-label-text').textContent = fileName;
        }

        // Receipt form submit
        document.getElementById('receiptForm').addEventListener('submit', function(e) {
            // The form will be submitted normally, and PHP will handle the redirect
        });
        // Enable GCash button when terms are agreed
        var termsCheckbox = document.getElementById('termsCheckbox');
        termsCheckbox.addEventListener('change', function() {
            var gcashButton = document.getElementById('gcashButton');
            if (termsCheckbox.checked) {
                gcashButton.classList.remove('disabled');
                gcashButton.disabled = false;
            } else {
                gcashButton.classList.add('disabled');
                gcashButton.disabled = true;
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
        // Get the modal
            var modal = document.getElementById("myModal");

            // Get the link that opens the modal
            var termsLink = document.getElementById("termslink");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            var button = document.getElementsByClassName("agree")[0];

            // When the user clicks the link, open the modal
            termsLink.onclick = function(event) {
                event.preventDefault(); // Prevent default anchor behavior
                modal.style.display = "block"; // Show the modal
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none"; // Hide the modal
            }
            button.onclick = function() {
                termsCheckbox.checked = true;
                modal.style.display = "none"; // Hide the modal
                if (termsCheckbox.checked) {
                    gcashButton.classList.remove('disabled');
                    gcashButton.disabled = false;
                    } else {
                        gcashButton.classList.add('disabled');
                        gcashButton.disabled = true;
                    }
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