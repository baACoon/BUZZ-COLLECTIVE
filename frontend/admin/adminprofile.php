<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="Designs/admin-profile.css">
</head>
<body>
    <div class="profile-container">
        <h1>Admin Profile</h1>

        <!-- Display Admin Details -->
        <div class="admin-details">
            <p><strong>Username:</strong> AdminUsername</p>
            <p><strong>Email:</strong> admin@example.com</p>
        </div>

        <!-- Change Password -->
        <div class="change-password">
            <h2>Change Password</h2>
            <form method="post" action="#">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" placeholder="Enter current password" required>
                
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" placeholder="Enter new password" required>
                
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required>
                
                <button type="submit" name="change_password">Change Password</button>
            </form>
        </div>

       
