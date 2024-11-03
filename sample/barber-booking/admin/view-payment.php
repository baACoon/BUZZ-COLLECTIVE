<?php
// admin/view-payment.php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

require_once('../config/database.php');

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$payment_id = $_GET['id'];
$database = new Database();
$db = $database->getConnection();

// Get payment details with appointment info
$query = "SELECT p.*, a.name, a.service, a.appointment_date, a.appointment_time 
          FROM payments p 
          JOIN appointments a ON p.appointment_id = a.id 
          WHERE p.id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$payment_id]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$payment) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Payment Receipt</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Payment Receipt Details</h1>
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>

        <div class="payment-details">
            <div class="details-section">
                <h2>Appointment Information</h2>
                <table class="details-table">
                    <tr>
                        <th>Customer Name:</th>
                        <td><?php echo htmlspecialchars($payment['name']); ?></td>
                    </tr>
                    <tr>
                        <th>Service:</th>
                        <td><?php echo htmlspecialchars($payment['service']); ?></td>
                    </tr>
                    <tr>
                        <th>Appointment Date:</th>
                        <td><?php echo date('F d, Y', strtotime($payment['appointment_date'])); ?></td>
                    </tr>
                    <tr>
                        <th>Appointment Time:</th>
                        <td><?php echo date('h:i A', strtotime($payment['appointment_time'])); ?></td>
                    </tr>
                    <tr>
                        <th>Payment Status:</th>
                        <td>
                            <span class="status-<?php echo $payment['payment_status']; ?>">
                                <?php echo ucfirst($payment['payment_status']); ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="receipt-section">
                <h2>Receipt Image</h2>
                <div class="receipt-container">
                    <img src="../uploads/receipts/<?php echo htmlspecialchars($payment['receipt_path']); ?>" 
                         alt="Payment Receipt" 
                         class="receipt-image">
                </div>

                <?php if ($payment['payment_status'] === 'pending'): ?>
                <div class="action-buttons">
                    <button onclick="verifyPayment(<?php echo $payment['id']; ?>)" class="verify-btn">
                        Verify Payment
                    </button>
                    <button onclick="rejectPayment(<?php echo $payment['id']; ?>)" class="reject-btn">
                        Reject Payment
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function verifyPayment(paymentId) {
            if (confirm('Are you sure you want to verify this payment?')) {
                updatePaymentStatus(paymentId, 'verified');
            }
        }

        function rejectPayment(paymentId) {
            if (confirm('Are you sure you want to reject this payment?')) {
                updatePaymentStatus(paymentId, 'rejected');
            }
        }

        function updatePaymentStatus(paymentId, status) {
            fetch('update-payment-status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    payment_id: paymentId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    </script>
</body>
</html>