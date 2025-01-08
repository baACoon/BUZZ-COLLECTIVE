<?php
session_start();

// Database connection
$db = mysqli_connect('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

// Check if the user is logged in
$username = $_SESSION['username'];

// Fetch user's email and profile image
$email = '';
$profile_image = 'design/image/default-placeholder.png'; // Default placeholder image path

$profile_sql = "SELECT email, profile_image FROM users WHERE username = ?";
$profile_stmt = $db->prepare($profile_sql);
if ($profile_stmt) {
    $profile_stmt->bind_param("s", $username);
    $profile_stmt->execute();
    $profile_stmt->bind_result($email, $profile_image_path);
    $profile_stmt->fetch();
    $profile_stmt->close();

    if ($profile_image_path) {
        $profile_image = $profile_image_path; // Use the saved image if available
    }
}

// Fetch appointments for the logged-in user
$appointments_sql = "SELECT appointment_id, first_name, last_name, services, date, timeslot, barber 
                     FROM appointments 
                     WHERE email = ?
                     ORDER BY appointment_id DESC";
$appointments_stmt = $db->prepare($appointments_sql);
if ($appointments_stmt) {
    $appointments_stmt->bind_param("s", $email);
    $appointments_stmt->execute();
    $result = $appointments_stmt->get_result();
    $appointments_stmt->close();
} else {
    // Fallback if preparation fails
    $result = $db->query($appointments_sql);
}
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design/history.css">
    <link rel="stylesheet" href="design/profilepopup.css">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective | History</title>

</head>
<body>
     <!-- Navbar for screens below 768px -->
    <div class="mobile-navbar" id="mobile-navbar">
        <div class="mobile-logo">
            <img src="design/image/BUZZ-Black.png" alt="Buzz Collective Logo">
        </div>
        <i class='bx bx-menu' id="menu-icon"></i>
    </div>
    <aside class="sidebar">
        <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Add this line for the close button -->
        <div class="profile-container">
            <div class="back-button"><a href="home.php"><i class="fa-solid fa-arrow-left"></i></a></div>
            <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" class="profile-img" id="profile-img">
            <div class="customer-name"><h1>@<?php echo htmlspecialchars($username); ?></h1></div>
        </div>
        <nav>
            <ul>
                <li><a href="myprofile.php">My Profile</a></li>
                <li><a href="history.php">See History</a></li>
                <li><a href="changepass.php">Change Password</a></li>
                <li><a href="../backend/logout.php">Logout</a></li> <!-- Link to Logout -->
            </ul>
        </nav>
    </aside>

    <div class="history-wrapper">
        <div class="history">
            <h1>HISTORY</h1>
        </div>
        <div class="welcome">
            <p>Welcome, <span class="cstmr-name"><?php echo $_SESSION['username']; ?>!</span></p>
        </div>
        <br>

        <div class="client-history">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Barber</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) {
                        // Output each row of data
                        while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['appointment_id']; ?></td>
                                <td><?php echo $row['services']; ?></td>
                                <td><?php echo date('F j, Y', strtotime($row['date'])); ?></td>
                                <td><?php echo date('g:i a', strtotime($row['timeslot'])); ?></td>
                                <td><?php echo $row['barber']; ?></td>
                            </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6">No records found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

  
 

    
       
    <script src="../frontend/js/history.js"></script>
</body>
</html>