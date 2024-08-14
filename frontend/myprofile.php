<?php

session_start();

// Retrieve the user's username from the session
$username = $_SESSION['username'];

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

$username = $_SESSION['username'];

// Fetch the user's email from the database
$email = '';
$sql = "SELECT email FROM users WHERE username = ?";
$stmt = $db->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();
}

// Update the email if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_email = $_POST['Email'];

    // Validate the email format
    if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        // Update the email in the database
        $update_sql = "UPDATE users SET email = ? WHERE username = ?";
        $update_stmt = $db->prepare($update_sql);
        if ($update_stmt) {
            $update_stmt->bind_param("ss", $new_email, $username);

            if ($update_stmt->execute()) {
                $email = $new_email; // Update the email variable to reflect the change
            } else {
                echo "Error updating email.";
            }
            $update_stmt->close();
        }
    } else {
        echo "Invalid email format.";
    }
}

$db->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    
</head>
<body>
                <aside class="sidebar">
                        <div class="profile-container">
                        <div class="back-button"><a href="home.php"><i class="fa-solid fa-arrow-left"></i></a></div>
                        <img src="design/image/default-placeholder.png" alt="Profile Image" class="profile-img" id="profile-img">
                        <div class="customer-name"><h1>@<?php echo htmlspecialchars($username); ?></h1></div>
        
                        </div>
                        <nav>
                            <ul>
                                <li><a href="myprofile.php">My Profile</a></li>
                                <li><a href="#">See History</a></li>
                                <li><a href="#">Change Password</a></li>
                                <li><a href="login.php">Logout</a></li>
                            </ul>
                        </nav>
                </aside>

                <div class="profile">
                    <h1>MY PROFILE</h1>
                    <h5>Manage and protect your account</h5>
                </div>

             
                    <!--customer info  -->
                <div class="customer-info">
                    <form action="update_username.php" method="post">
                        <h4>Username: <span class="client-username"><?php echo htmlspecialchars($username); ?></span></h4> 
                        <h4>Email: <span class="client-email"><?php echo htmlspecialchars($email); ?></span></h4> 
                        <input type="submit" value="Update Email" class="update-button" >
                        
                    </form>
                </div>


                    <!--profile pic button  -->
                <div class="pic-button">
                    <a href="#" id="profile-image-link">Upload Profile Image</a>
                    <input type="file" id="profile-image-input" style="display: none;"> <br>
                    <a id="remove-image-button" class="remove-button">Remove Image</a>
                </div>

                <script>
                    // JavaScript to handle the profile image change and removal
                        document.getElementById('profile-image-link').addEventListener('click', function(e) {
                        e.preventDefault();
                        document.getElementById('profile-image-input').click();
                            });
                    const profileImg = document.getElementById('profile-img');
                    const fileInput = document.getElementById('profile-image-input');
                    const removeImageButton = document.getElementById('remove-image-button');
                    const defaultImage = "design/image/default-placeholder.png"; // Path to the default placeholder image

                    fileInput.addEventListener('change', function() {
                        const file = fileInput.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                profileImg.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    removeImageButton.addEventListener('click', function() {
                        profileImg.src = defaultImage;
                        fileInput.value = ''; // Clear the file input
                    });
                </script>


</body>
</html>