<!-- admin/dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

require_once('../config/database.php');
$database = new Database();
$db = $database->getConnection();

// Get appointments with payments
$query = "
    SELECT 
        a.*, 
        p.receipt_path,
        p.payment_status
    FROM 
        appointments a
    LEFT JOIN 
        payments p ON a.id = p.appointment_id
    ORDER BY 
        a.appointment_date DESC, 
        a.appointment_time DESC
";

$stmt = $db->prepare($query);
$stmt->execute();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Appointments Dashboard</h1>
        <a href="logout.php" class="logout-btn">Logout</a>

        <table class="appointments-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Service</th>
                    <th>Barber</th>
                    <th>Date & Time</th>
                    <th>Payment Status</th>
                    <th>Receipt</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <?php echo htmlspecialchars($row['phone_number']); ?><br>
                            <?php echo htmlspecialchars($row['email']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['service']); ?></td>
                        <td><?php echo htmlspecialchars($row['barber']); ?></td>
                        <td>
                            <?php 
                            echo date('M d, Y', strtotime($row['appointment_date'])) . '<br>';
                            echo date('h:i A', strtotime($row['appointment_time']));
                            ?>
                        </td>
                        <td><?php echo $row['payment_status'] ?? 'No payment'; ?></td>
                        <td>
                            <?php if ($row['receipt_path']) { ?>
                                <a href="#" onclick="viewReceipt('..client/uploads/receipts/<?php echo $row['receipt_path']; ?>')">
                                    View Receipt
                                </a>
                            <?php } else { ?>
                                No receipt
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($row['payment_status'] === 'pending') { ?>
                                <button onclick="verifyPayment(<?php echo $row['id']; ?>)">
                                    Verify Payment
                                </button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="receiptImage" src="" alt="Receipt">
        </div>
    </div>

    <script>
        // Modal functionality
        function viewReceipt(path) {
            const modal = document.getElementById('receiptModal');
            const img = document.getElementById('receiptImage');
            img.src = path;
            modal.style.display = "block";
        }

        // Verify payment
        function verifyPayment(appointmentId) {
            if (confirm('Verify this payment?')) {
                fetch('verify-payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ appointment_id: appointmentId })
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
        }

        // Close modal
        document.querySelector('.close').onclick = function() {
            document.getElementById('receiptModal').style.display = "none";
        }
    </script>
</body>
</html>