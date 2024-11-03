<?php
// client/process-payment.php
require_once('../config/database.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    try {
        if (!isset($_POST['appointment_id']) || !isset($_FILES['receipt'])) {
            throw new Exception('Missing required fields');
        }

        $appointment_id = $_POST['appointment_id'];
        $file = $_FILES['receipt'];

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowed_types)) {
            throw new Exception('Invalid file type. Only JPG, JPEG, and PNG files are allowed.');
        }

        // Create uploads directory if it doesn't exist
        $upload_dir = 'uploads/receipts/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'receipt_' . $appointment_id . '_' . time() . '.' . $extension;
        $filepath = $upload_dir . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new Exception('Failed to upload file');
        }

        // Check if payment record exists
        $check_query = "SELECT id FROM payments WHERE appointment_id = ?";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->execute([$appointment_id]);

        if ($check_stmt->rowCount() > 0) {
            // Update existing payment record
            $update_query = "UPDATE payments 
                           SET receipt_path = ?, 
                               payment_status = 'pending', 
                               updated_at = NOW() 
                           WHERE appointment_id = ?";
            $update_stmt = $db->prepare($update_query);
            $update_stmt->execute([$filepath, $appointment_id]);
        } else {
            // Insert new payment record
            $insert_query = "INSERT INTO payments 
                           (appointment_id, receipt_path, payment_status, created_at, updated_at) 
                           VALUES (?, ?, 'pending', NOW(), NOW())";
            $insert_stmt = $db->prepare($insert_query);
            $insert_stmt->execute([$appointment_id, $filepath]);
        }

        // Redirect to confirmation page
        header("Location: confirmation.php?id=" . $appointment_id);
        exit();

    } catch (Exception $e) {
        // Redirect to an error page or display error message (optional)
        echo "Error: " . $e->getMessage();
    }
} else {
    header('Location: index.php');
    exit();
}

?>