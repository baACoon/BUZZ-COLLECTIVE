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

    <div class="history">
        <h1>HISTORY</h1>
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



    </script>
</body>
</html>