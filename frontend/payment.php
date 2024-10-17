<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/payment.css">
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
            I agree to the <a href="#" target="_blank">terms and conditions</a>.
        </label>
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
                    <span id="file-label-text">UPLOAD RECEIPT</span>
                </label>
                <button type="submit" class="submit-button">SUBMIT</button>
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
            e.preventDefault();
            // Simulate file upload success
            alert('Receipt uploaded successfully!');
            gcashPopup.style.display = 'none';
            window.location.href = 'receipt.php'; // Redirect to the receipt page
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
    </script>
</body>
</html>
