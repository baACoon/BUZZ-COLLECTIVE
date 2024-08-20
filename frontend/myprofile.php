<?php
session_start();

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

// Check if the user is logged in
$username = $_SESSION['username'];

// Fetch the user's email and profile image from the database
$email = '';
$profile_image = 'design/image/default-placeholder.png'; // Default placeholder image path

$sql = "SELECT email, profile_image FROM users WHERE username = ?";
$stmt = $db->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($email, $profile_image_path);
    $stmt->fetch();
    $stmt->close();

    if ($profile_image_path) {
        $profile_image = $profile_image_path; // Use the saved image if available
    }
}

// Handle the profile image upload
$notification = ''; // Initialize notification message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                    $notification = "The file " . htmlspecialchars(basename($_FILES["profile_image"]["name"])) . " has been uploaded.";
                } else {
                    $notification = "Error preparing SQL statement.";
                }

                // Update the $profile_image variable to display the new image
                $profile_image = $target_file;
            } else {
                $notification = "Sorry, there was an error uploading your file.";
            }
        }
    } elseif (isset($_POST['remove_image'])) {
        // Handle the image removal
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
    } elseif (isset($_POST['update_email'])) {
        // Handle the email update
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
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design/profile.css">
    <link rel="stylesheet" href="design/profilepopup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    
</head>
<body>
    <?php if ($notification) : ?>
        <div id="notification-popup" class="notification-popup">
            <p><?php echo htmlspecialchars($notification); ?></p>
            <button onclick="closePopup()">OK</button>
        </div>
        <div id="overlay" class="overlay"></div>
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
                <li><a href="#">Change Password</a></li>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <div class="profile">
        <h1>MY PROFILE</h1>
        <h5>Manage and protect your account</h5>
    </div>

    <div class="customer-info">
        <form action="myprofile.php" method="post" enctype="multipart/form-data">
            <h4>Username: <span class="client-username"><?php echo htmlspecialchars($username); ?></span></h4>
            <div class="email-container"><h4>Email: <span class="client-email"><?php echo htmlspecialchars($email); ?> </span></h4><a href="" class="change-btn">change</a></div>
            <input type="email" name="email" placeholder="New Email (optional)">
            <input type="submit" name="update_email" value="Update Email" class="update-button"><br>
            <label for="profile-image-input" class="upload-button">Upload Profile Image</label>
            <input type="file" name="profile_image" id="profile-image-input" style="display: none;">
            <br>
            <button type="submit" name="remove_image" id="remove-image-button" class="remove-button">Remove Image</button>
            <button type="submit" name="save_image" id="save-image-button" class="save-button">Save Image</button>
        </form>
    </div>

    <script>
        // JavaScript to handle the profile image input
        const fileInput = document.getElementById('profile-image-input');
        const profileImg = document.getElementById('profile-img');
        const defaultImage = "design/image/default-placeholder.png";

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('remove-image-button').addEventListener('click', function() {
            // Update the profile image to default on click
            profileImg.src = defaultImage;
        });

        function closePopup() {
            document.getElementById('notification-popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }


    </script>
</body>
</html>
