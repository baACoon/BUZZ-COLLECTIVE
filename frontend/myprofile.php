<?php
session_start();

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Fetch the user's email, name, and profile image from the database
$email = '';
$name = ''; // Initialize name
$profile_image = 'design/image/default-placeholder.png'; // Default placeholder image path

$sql = "SELECT email, name, profile_image FROM users WHERE username = ?";
$stmt = $db->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($email, $name, $profile_image_path);
    $stmt->fetch();
    $stmt->close();

    if ($profile_image_path) {
        $profile_image = $profile_image_path; // Use the saved image if available
    }
}

// Handle the profile image upload and name/email updates
$notification = ''; // Initialize notification message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);  // Create directory if it doesn't exist
        }

        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $notification = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (5MB max)
        if ($_FILES["profile_image"]["size"] > 5000000) {
            $notification = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $notification = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $notification = $notification ?: "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                // Update the database with the new file path
                $sql = "UPDATE users SET profile_image = ? WHERE username = ?";
                $stmt = $db->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("ss", $target_file, $username);
                    $stmt->execute();
                    $stmt->close();
                    $notification = "The image has been uploaded.";
                } else {
                    $notification = "Error preparing SQL statement.";
                }

                // Update the $profile_image variable to display the new image
                $profile_image = $target_file;
            } else {
                $notification = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Handle image removal
    elseif (isset($_POST['remove_image'])) {
        $sql = "UPDATE users SET profile_image = NULL WHERE username = ?";
        $stmt = $db->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
            $notification = "Profile image removed successfully.";
        }

        // Optionally, delete the old image file from the server
        if ($profile_image && $profile_image !== 'design/image/default-placeholder.png' && file_exists($profile_image)) {
            unlink($profile_image);
        }

        // Set the profile image back to the default
        $profile_image = 'design/image/default-placeholder.png';
    }

    // Handle the email update
    elseif (isset($_POST['update_email'])) {
        $new_email = $_POST['email'];
        if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $sql = "UPDATE users SET email = ? WHERE username = ?";
            $stmt = $db->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ss", $new_email, $username);
                $stmt->execute();
                $stmt->close();
                $email = $new_email; // Update email variable for display
                $notification = "Email updated successfully.";
            } else {
                $notification = "Error preparing SQL statement.";
            }
        } else {
            $notification = "Invalid email format.";
        }
    }

    // Handle the name update
    elseif (isset($_POST['update_name'])) {
        $new_name = trim($_POST['name']);
        if (!empty($new_name)) {
            $sql = "UPDATE users SET name = ? WHERE username = ?";
            $stmt = $db->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ss", $new_name, $username);
                $stmt->execute();
                $stmt->close();
                $name = $new_name; // Update name variable for display
                $notification = "Name updated successfully.";
            } else {
                $notification = "Error preparing SQL statement.";
            }
        } else {
            $notification = "Name cannot be empty.";
        }
    }

    // Handle name removal
    elseif (isset($_POST['remove_name'])) {
        $sql = "UPDATE users SET name = NULL WHERE username = ?";
        $stmt = $db->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
            $name = ''; // Reset name variable for display
            $notification = "Name removed successfully.";
        } else {
            $notification = "Error preparing SQL statement.";
        }
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design/profile.css">
    <link rel="stylesheet" href="design/emailpopup.css"> 
    <link rel="stylesheet" href="design/profilepopup.css">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective | My Profile</title>

</head>
<body>
    <?php if ($notification) : ?>
        <div id="notification-popup" class="notification-popup">
            <p><?php echo htmlspecialchars($notification); ?></p>
            <button onclick="closePopup()">OK</button>
        </div>
        <div id="overlay" class="overlay show"></div>
    <?php endif; ?>

    <!-- Navbar for screens below 768px -->
    <div class="mobile-navbar" id="mobile-navbar">
        <div class="mobile-logo">
            <img src="design/image/BUZZ-Black.png" alt="Buzz Collective Logo">
        </div>
        <i class='bx bx-menu' id="menu-icon"></i>
    </div>

    <aside class="sidebar" id="sidebar">
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

    <div class="profile-wrapper">
        <div class="profile">
            <h1>MY PROFILE</h1>
            <h5>Manage and protect your account</h5>
        </div>

        <!--customer info -->
        <div class="customer-info">
            <h4>Username: <span class="client-username"><?php echo htmlspecialchars($username); ?></span></h4>
            
            <div class="email-container">
                <h4>Email: <span class="client-email"><?php echo htmlspecialchars($email); ?> </span></h4>
                <a href="#" class="change-btn">change</a>
            </div>


            <!--EMAIL POPUP -->
                <div id="email-modal" class="email-modal">
                    <div class="email-modal-content">
                        <span class="close-modal">&times;</span>
                        <h2>Update Email</h2>
                        <form action="myprofile.php" method="post">
                            <label for="email">New Email:</label>
                            <input type="email" name="email" id="email" placeholder="Enter new email" required>
                            <input type="submit" name="update_email" value="Update Email" class="update-email-button">
                        </form>
                    </div>
                </div>
            <div id="overlay" class="overlay"></div>
            
            <div class="custname">
                <form action="myprofile.php" method="post">
                    <h4>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="name-input" placeholder="Enter your name"></h4>
                    <button type="submit" name="update_name" class="save-name-button">Save Name</button>
                    <button type="submit" name="remove_name" class="remove-name-button">Remove Name</button>
                </form>
            </div>

            <form action="myprofile.php" method="post" enctype="multipart/form-data" id="profile-image-form">
                <label for="profile-image-input" class="upload-button">Upload Profile Image</label>
                <input type="file" name="profile_image" id="profile-image-input" style="display: none;">
                <br>
                <button type="submit" name="remove_image" class="remove-image-button">Remove Image</button>
            </form>
        </div>
    </div>

    <script src="../frontend/js/myprofile.js"></script>
</body>
</html>