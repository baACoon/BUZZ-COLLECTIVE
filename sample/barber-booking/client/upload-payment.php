<?php
require_once('../config/database.php');

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$appointment_id = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Payment</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Upload Payment Receipt</h1>
        
        <div class="payment-instructions">
            <h3>Payment Instructions:</h3>
            <p>Please send your payment to:</p>
            <p>GCash Number: 09XX-XXX-XXXX</p>
            <p>After sending payment, please upload your receipt below.</p>
        </div>

        <form id="paymentForm" action="process-payment.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
            <div class="form-group">
                <label>Upload Receipt:</label>
                <input type="file" name="receipt" accept="image/*" required>
            </div>
            <button type="submit">Submit Payment</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#paymentForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'process-payment.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    response = JSON.parse(response);
                    if(response.success) {
                        window.location.href = 'confirmation.php?id=' + <?php echo $appointment_id; ?>;
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

    </script>
</body>
</html>