<?php
session_start();

// Check if the form is submitted
$uploadMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file is uploaded
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $receipt = $_FILES['receipt'];

        // Define the directory to save the uploaded receipts
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($receipt['name']);

        // Move the uploaded file to the designated directory
        if (move_uploaded_file($receipt['tmp_name'], $uploadFile)) {
            $uploadMessage = "Receipt uploaded successfully!";
            // You could add database saving logic here if needed
        } else {
            $uploadMessage = "There was an error uploading your receipt.";
        }
    } else {
        $uploadMessage = "No receipt uploaded or there was an upload error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/uploadreciept.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">
    <title>Buzz & Collective - GCASH Payment</title>
</head>
<body>
    <div class="confirmation-form">
        <h2>Buzz & Collective Confirmation</h2>
        <p>MAIN BRANCH</p>
    </div>

    <div class="gcash-container">
        <p>SEND TO</p>
        <h3>0960 520 5411</h3>
        <img src="../frontend/design/image/QRGacsh.jpg" alt="GCASH QR Code">
    </div>

    <div class="receipt-upload">
        <h4>UPLOAD GCASH RECEIPT</h4>
        <form action="" method="POST" enctype="multipart/form-data">
            <label class="file-label">
                <input type="file" name="receipt" accept="image/*" required onchange="updateFileName(this)">
                <span id="file-label-text">Choose file</span>
            </label>
            <a href="receipt.php">
                <input type="submit" value="Upload Receipt">
            </a>
            
        </form>
        <div class="upload-message">
            <?php if (!empty($uploadMessage)): ?>
                <p><?php echo $uploadMessage; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            var fileName = input.files[0].name;
            document.getElementById('file-label-text').textContent = fileName;
        }
    </script>

</body>
</html>
