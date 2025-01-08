<?php
// Define the path to your JSON file
$branchesFile = 'data/branches.json'; 

$branches = json_decode(file_get_contents($branchesFile), true);

// Handle branch addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['branchId'])) {
    $branchId = $_POST['branchId'];
    $branchName = $_POST['branchName'];
    $branchLocation = $_POST['branchLocation'];

    $newBranch = [
        'branchId' => $branchId,
        'branchName' => $branchName,
        'branchLocation' => $branchLocation,
    ];

    // Check if branch already exists
    foreach ($branches as $branch) {
        if ($branch['branchId'] == $branchId) {
            echo 'Branch ID already exists!';
            exit();
        }
    }

    $branches[] = $newBranch;

    // Save branches array back to JSON file
    file_put_contents($branchesFile, json_encode($branches, JSON_PRETTY_PRINT));

    // Redirect or return a success message
    echo 'Branch added successfully!';
    header('Location: admin-branches.php');
    exit();
}

// Handle branch deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteBranchId'])) {
    $deleteBranchId = $_POST['deleteBranchId'];

    // Filter out the branch to be deleted
    $branches = array_filter($branches, function($branch) use ($deleteBranchId) {
        return $branch['branchId'] != $deleteBranchId;
    });

    // Save the updated branches array back to JSON file
    file_put_contents($branchesFile, json_encode($branches, JSON_PRETTY_PRINT));

    // Redirect or return a success message
    header('Location: admin-branches.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective - Branches</title>
    <link rel="icon" type="image/x-icon" href="../design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="/Designs/adminbranches.css">
    <base href="https://admin.buzzcollective.gayvar.com/Buzz-collective/frontend/admin/">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="script.js" defer></script>
</head>
<body>
       <!-- Navbar for screens below 768px 
       <div class="mobile-navbar" id="mobile-navbar">
        <div class="mobile-logo">
            <img src="/images/BUZZ-Black.png" alt="Buzz Collective Logo">
        </div>-->
        <i class='bx bx-menu' id="menu-icon"></i>
    </div>

    <aside class="sidebar" id="sidebar">
    <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Close button -->
    <div class="logo">
        <a href="/admin-home.php">
            <img src="/images/BUZZ-White.png" alt="Buzz Collective Logo">
        </a>
    </div>
    <nav>
        <ul class="links">
            <li><a href="/dashboard.php">Dashboard</a></li>
            <li><a href="/admin-appointment.php">Appointment Bookings</a></li>
            <li><a href="/admin-barber.php">Barbers' Schedule</a></li>
            <li class="/services"><a href="services.php">Services</a><span class="notification-dot"></span></li>
            <li class="/about-us"><a href="admin-aboutus.php">About Us</a></li>
            <li><a href="/news.php">News</a></li>
            <li><a href="/admin-branches.php">Branches</a></li>
            <li><a href="/settings.php">Settings</a></li>
        </ul>
    </nav>
</aside>

    <div class="branches-content">
        <h1>BRANCHES</h1>
        <div class="box-container">
            <!-- Existing branches will be dynamically populated here -->
            <?php foreach ($branches as $branch): ?>
                <div class="branch">
                    <a href="#"><img src="/images/BUZZ-Black.png" alt="Logo"></a>
                    <div class="branch-content">
                        <h3><?php echo htmlspecialchars($branch['branchName']); ?></h3>
                        <p><?php echo htmlspecialchars($branch['branchLocation']); ?></p>
                    </div>
                    <!-- Delete button -->
                    <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete this branch?');" class="delete-button-container">
                        <input type="hidden" name="deleteBranchId" value="<?php echo $branch['branchId']; ?>">
                        <button type="submit" class="delete-button">DELETE</button>
                    </form>
                </div>

            <?php endforeach; ?>

            <!-- Add Branch Button -->
            <div class="branch add-branch" id="addBranch" onclick="showForm()">
                <span>+</span>
            </div>

            <!-- Form for adding new branch -->
            <div class="branch form-container" id="branchForm" style="display:none;">
                <h4>Add New Branch</h4>
                <form method="post" action="">
                    <label for="branchId">Branch ID:</label>
                    <input type="text" id="branchId" name="branchId" required>

                    <label for="branchName">Branch Name:</label>
                    <input type="text" id="branchName" name="branchName" required>

                    <label for="branchLocation">Branch Location:</label>
                    <input type="text" id="branchLocation" name="branchLocation" required>

                    <div class="form-buttons">
                        <button type="submit">Save</button>
                        <button type="button" onclick="hideForm()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // menu icon
        document.addEventListener('DOMContentLoaded', function() {
            const menuIcon = document.getElementById('menu-icon');
            const sidebar = document.querySelector('.sidebar');
            const closeSidebar = document.getElementById('close-sidebar');

            // Add click event to the menu icon
            menuIcon.addEventListener('click', function() {
                sidebar.classList.toggle('open'); // Toggle the 'open' class on the sidebar
                closeSidebar.style.display = sidebar.classList.contains('open') ? 'block' : 'none'; // Show/hide close button
            });

            // Add click event to the close button
            closeSidebar.addEventListener('click', function() {
                sidebar.classList.remove('open'); // Remove the 'open' class on the sidebar
                closeSidebar.style.display = 'none'; // Hide close button
            });
        });
        function showForm() {
            document.getElementById('branchForm').style.display = 'block';
            document.getElementById('branchId').value = '';
            document.getElementById('branchName').value = '';
            document.getElementById('branchLocation').value = '';
        }

        function hideForm() {
            document.getElementById('branchForm').style.display = 'none';
        }
    </script>
</body>
</html>
