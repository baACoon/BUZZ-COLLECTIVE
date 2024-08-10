<?php
// Load services data
$services = json_decode(file_get_contents('data/services.json'), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective - Services</title>
    <link rel="stylesheet" href="Designs/adminbranches.css">
    <script src="script.js" defer></script>
    <script src="branches.js"></script>
</head>
<body>

        <aside class="sidebar">
                <div class="logo">
                    <img src="images/BUZZ-White.png" alt="Buzz Collective Logo">
                </div>
                <nav>
                    <ul>
                        <li><a href="admin-appointment.php">Appointment Bookings</a></li>
                        <li><a href="admin-barber.php">Barbers' Schedule</a></li>
                        <li><a href="services.php">Services</a><span class="notification-dot"></span></li>
                        <li><a href="admin-aboutus.php">About Us</a></li>
                        <li><a href="news.php">News</a></li>
                        <li><a href="admin-branches.php">Branches</a></li>
                        <li><a href="clientprofile.php">Client Profile</a></li>
                        <li><a href="settings.php">Settings</a></li>
                    </ul>
                </nav>
        </aside>

        <div class="branches-content">
            <h1>BRANCHES</h1>
            <div class="box-container">
                <div class="branch">
                    <img src="images/BUZZ-Black.png" alt="branch-logo">
                    <h4>Main Branch</h4>
                    <p>89 Nueno Avenue, Imus Cavite</p>
                    <p>Cavite, Philippines</p>
                </div>
                <div class="branch">
                    <img src="images/BUZZ-Black.png" alt="branch-logo">
                    <h4>Salitran Branch</h4>
                    <p>RVV-88 Commercial Center, Jose Abad Santos Avenue, Salitran 2, Dasmarinas City, Cavite</p>
                    <p>Cavite, Philippines</p>
                </div>
                <!-- Add Branch Button -->
                <div class="branch add-branch" id="addBranch" onclick="showForm()">
                    <span>+</span>
                </div>
                
                <!-- Form for adding new branch -->
                <div class="branch form-container" id="branchForm">
                    <h4>Add New Branch</h4>
                    <form>
                        <label for="branchId">Branch ID:</label>
                        <input type="text" id="branchId" name="branchId" required>

                        <label for="branchName">Branch Name:</label>
                        <input type="text" id="branchName" name="branchName" required>

                        <label for="branchLocation">Branch Location:</label>
                        <input type="text" id="branchLocation" name="branchLocation" required>

                        <div class="form-buttons">
                            <button type="button" onclick="saveBranch()">Save</button>
                            <button type="button" onclick="hideForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>






</body>
</html>
