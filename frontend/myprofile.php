<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/customerdata.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design/profile.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    
</head>
<body>
                <aside class="sidebar">
                        <div class="profile-container">
                        <img src="design/image/default-placeholder.png" alt="Profile Image" class="profile-img" id="profile-img">
                        <div class="customer-name"><?php echo $customerName; ?></div>
                        <input type="file" id="profile-image-input">
                            <button id="remove-image-button">Remove Image</button>
                        </div>
                        <nav>
                            <ul>
                                <li><a href="myprofile.php">My Profile</a></li>
                                <li><a href="#">See History</a></li>
                                <li><a href="#">Change Password</a></li>
                                <li><a href="#">Logout</a></li>
                            </ul>
                        </nav>
                </aside>

                <div class="profile">
                    <h1>MY PROFILE</h1>
                </div>

                <script>
                    // JavaScript to handle the profile image change and removal
                    const profileImg = document.getElementById('profile-img');
                    const fileInput = document.getElementById('profile-image-input');
                    const removeImageButton = document.getElementById('remove-image-button');
                    const defaultImage = "1"; // Path to the default placeholder image

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