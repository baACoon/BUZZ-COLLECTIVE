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
    <title>Buzz & Collective - Services</title>
    <link rel="stylesheet" href="../admin/Designs/adminbranches.css">
    <script src="script.js" defer></script>
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
                <li><a href="services.php">Services</a></li>
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
            <!-- Existing branches will be dynamically populated here -->
            <?php foreach ($branches as $branch): ?>
            <div class="branch">
                <a href="#"><img src="../admin/images/BUZZ-Black.png" alt="Logo"></a>
                <div>
                    <h3><?php echo htmlspecialchars($branch['branchName']); ?></h3>
                    <p><?php echo htmlspecialchars($branch['branchLocation']); ?></p>

                    <!-- Delete button -->
                    <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete this branch?');">
                        <input type="hidden" name="deleteBranchId" value="<?php echo $branch['branchId']; ?>">
                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                </div>
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
