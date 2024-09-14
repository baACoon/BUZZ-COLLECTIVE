<?php
session_start();

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    die("User not logged in. Please log in first.");
}

$username = $_SESSION['username'];
$profile_image = 'design/image/default-placeholder.png';

// Fetch user profile details
$sql = "SELECT email, name, profile_image FROM users WHERE username = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email, $name, $profile_image_path);
$stmt->fetch();
$stmt->close();

if ($profile_image_path) {
    $profile_image = $profile_image_path;
}

// Handle the change password functionality
$notification = ''; // Initialize notification message

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the new password meets the requirements
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&_])[A-Za-z\d@$!%*#?&_]{6,}$/', $new_password)) {
        $notification = "Password must be at least 6 characters long, and include at least one letter, one number, and one special character (!$@%&_).";
    } elseif ($new_password !== $confirm_password) {
        $notification = "New passwords do not match.";
    } else {
        // Fetch the current hashed password from the database (using md5)
        $sql = "SELECT password FROM users WHERE username = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Verify the current password using md5
        if (md5($current_password) === $hashed_password) {
            // Hash the new password using md5
            $new_hashed_password = md5($new_password);

            // Update the password in the database
            $sql = "UPDATE users SET password = ? WHERE username = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ss", $new_hashed_password, $username);
            $stmt->execute();
            $stmt->close();

            $notification = "Password updated successfully."; // Success message
        } else {
            $notification = "Current password is incorrect."; // Error message
        }
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design/profile.css">
    <link rel="stylesheet" href="design/chngpass.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective | Change Password</title>
    <style>
        /* Add some basic styling for the notification popup */
        .notification-popup {
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .notification-popup.show {
            display: block;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.show {
            display: block;
        }
    </style>
</head>
<body>

    <?php if ($notification) : ?>
        <div id="notification-popup" class="notification-popup show">
            <p><?php echo htmlspecialchars($notification); ?></p>
            <button onclick="closePopup()">OK</button>
        </div>
        <div id="overlay" class="overlay show"></div>
    <?php endif; ?>

    <aside class="sidebar">
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

    <div class="pass-wrapper">
        <div class="profile">
            <h1>CHANGE PASSWORD</h1>
            <p>Your password must be at least 6 characters and should include a combination of numbers, 
                letters, and special characters (!$@%&_). </p>
        </div>

        <form action="changepass.php" method="post" onsubmit="return validatePassword();">
            <label for="current_password">Current Password</label> <br>
            <input type="password" name="current_password" id="current_password" placeholder="Current password" required> <br>
            <label for="new_password">New Password</label> <br>
            <input type="password" name="new_password" id="new_password" placeholder="New password" required> <br>
            <label for="confirm_password">Confirm Password</label> <br>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required> <br>
            <input type="submit" value="Save Changes" name="change_password">
        </form>
    </div>

    <script>
        function validatePassword() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&_])[A-Za-z\d@$!%*#?&_]{6,}$/;

            if (!passwordPattern.test(newPassword)) {
                // If the password doesn't match the pattern, show the popup
                document.getElementById('notification-popup').innerHTML = `
                    <p>Password must be at least 6 characters long, and include at least one letter, one number, and one special character (!$@%&_).</p>
                    <button onclick="closePopup()">OK</button>
                `;
                document.getElementById('notification-popup').classList.add('show');
                document.getElementById('overlay').classList.add('show');
                return false;
            }

            if (newPassword !== confirmPassword) {
                // If the new password and confirm password do not match, show the popup
                document.getElementById('notification-popup').innerHTML = `
                    <p>New passwords do not match.</p>
                    <button onclick="closePopup()">OK</button>
                `;
                document.getElementById('notification-popup').classList.add('show');
                document.getElementById('overlay').classList.add('show');
                return false;
            }

            return true;
        }

        function closePopup() {
            document.getElementById('notification-popup').classList.remove('show');
            document.getElementById('overlay').classList.remove('show');
        }
    </script>
</body>
</html>
