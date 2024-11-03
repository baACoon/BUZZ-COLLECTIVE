<?php
// client/confirmation.php
require_once('../config/database.php');

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$appointment_id = $_GET['id'];
$database = new Database();
$db = $database->getConnection();

// Get appointment and payment details
$query = "SELECT a.*, p.payment_status, p.receipt_path 
          FROM appointments a 
          LEFT JOIN payments p ON a.id = p.appointment_id 
          WHERE a.id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$appointment_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="confirmation-box">
            <h1>Booking Confirmation</h1>
            
            <?php if ($booking['payment_status'] === 'pending'): ?>
            <div class="status-pending">
                Your booking is pending payment verification
            </div>
            <?php endif; ?>

            
            
            <div class="booking-details">
                <h2>Appointment Details</h2>
                <table class="details-table">
                    <tr>
                        <th>Booking Reference:</th>
                        <td>#<?php echo str_pad($booking['id'], 5, '0', STR_PAD_LEFT); ?></td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo htmlspecialchars($booking['name']); ?></td>
                    </tr>
                    <tr>
                        <th>Service:</th>
                        <td><?php echo htmlspecialchars($booking['service']); ?></td>
                    </tr>
                    <tr>
                        <th>Barber:</th>
                        <td><?php echo htmlspecialchars($booking['barber']); ?></td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td><?php echo date('F d, Y', strtotime($booking['appointment_date'])); ?></td>
                    </tr>
                    <tr>
                        <th>Time:</th>
                        <td><?php echo date('h:i A', strtotime($booking['appointment_time'])); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <?php
                            if ($booking['payment_status'] === 'verified') {
                                echo '<span class="status-verified">Payment Verified</span>';
                            } else {
                                echo '<span class="status-pending">Payment Pending Verification</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php if ($booking['receipt_path']): ?>
                        <tr>
                            <th>Receipt:</th>
                            <td>
                                <img src="<?php echo htmlspecialchars($booking['receipt_path']); ?>" 
                                    alt="Payment Receipt" 
                                    style="max-width: 200px;">
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            
            <div class="confirmation-footer">
                <p>Please save this reference number: #<?php echo str_pad($booking['id'], 5, '0', STR_PAD_LEFT); ?></p>
                <p>A confirmation email has been sent to: <?php echo htmlspecialchars($booking['email']); ?></p>
                <a href="index.php" class="btn-home">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>