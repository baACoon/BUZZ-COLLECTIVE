<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file is uploaded
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $receipt = $_FILES['receipt'];
        
        // Define the directory to save the uploaded receipts
        $uploadDir = 'uploads/'; // Make sure this directory exists and is writable
        $uploadFile = $uploadDir . basename($receipt['name']);
        
        // Move the uploaded file to the designated directory
        if (move_uploaded_file($receipt['tmp_name'], $uploadFile)) {
            echo "Receipt uploaded successfully!";

            // Here, you could save the receipt information (like reference number) in the database for admin verification
            // For example, use $_POST['total_payment'] for verification or link it to the user's session data.
        } else {
            echo "There was an error uploading your receipt.";
        }
    } else {
        echo "No receipt uploaded or there was an upload error.";
    }
} else {
    echo "Invalid request.";
}
?>
