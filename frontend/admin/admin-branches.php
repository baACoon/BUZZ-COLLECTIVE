<?php
// Define the path to your JSON file
$branchesFile = 'data/branches.json'; 

$branches = json_decode(file_get_contents($branchesFile), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
}
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
                <!-- Existing branches will be dynamically populated here -->
                <?php foreach ($branches as $branch): ?>
                <div class="branches">
                    <a href="#"><img src="design/image/BUZZ-Black.png" alt="Logo"></a>
                    <div>
                        <h3><?php echo htmlspecialchars($branch['branchName']); ?></h3>
                        <p><?php echo htmlspecialchars($branch['branchLocation']); ?></p>
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
                            <button type="button" onclick="saveBranch()">Save</button>
                            <button type="button" onclick="hideForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Load branches from PHP
            let branches = <?php echo json_encode($branches); ?>;

            function hideBranchDetails() {
                document.querySelector('.branch-details').style.display = 'none';
            }

            function showBranchDetails() {
                document.querySelector('.branch-details').style.display = 'block';
            }

            // Function to display branch details dynamically
            function displayBranchDetails(id) {
                const branch = branches.find(b => b.branchId == id);
                if (branch) {
                    document.getElementById('branch-name').innerText = branch.branchName;
                    document.getElementById('branch-id').innerText = branch.branchId;
                    document.getElementById('branch-location').innerText = branch.branchLocation;

                    // Show the branch details and hide the edit form
                    showBranchDetails();
                    document.getElementById('branchForm').style.display = 'none';

                    // Highlight the selected branch
                    const branchItems = document.querySelectorAll('.branch-item');
                    branchItems.forEach(item => {
                        if (item.innerText === branch.branchName) {
                            item.classList.add('bold'); // Add bold class
                        } else {
                            item.classList.remove('bold'); // Remove bold class
                        }
                    });
                }
            }

            // Open the form to add a new branch
            function showForm() {
                document.getElementById('branchForm').style.display = 'block';
                document.getElementById('branchId').value = '';
                document.getElementById('branchName').value = '';
                document.getElementById('branchLocation').value = '';
            }

            // Hide the form after adding/canceling
            function hideForm() {
                document.getElementById('branchForm').style.display = 'none';
                showBranchDetails();
            }

            // Save a new branch
            function saveBranch() {
                const id = document.getElementById('branchId').value;
                const name = document.getElementById('branchName').value;
                const location = document.getElementById('branchLocation').value;

                // Create a FormData object for the POST request
                const formData = new FormData();
                formData.append('branchId', id);
                formData.append('branchName', name);
                formData.append('branchLocation', location);

                // Fetch request to save the new branch
                fetch('branches.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data) {
                        // Check if branch exists, otherwise add a new one
                        const branch = branches.find(b => b.branchId === id);
                        if (branch) {
                            branch.branchName = name;
                            branch.branchLocation = location;
                        } else {
                            branches.push({ branchId: id, branchName: name, branchLocation: location });
                        }

                        // Rebuild the branch list in the UI
                        rebuildBranchList();
                        hideForm();
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }

            // Function to dynamically rebuild the branch list
            function rebuildBranchList() {
                const branchesList = document.querySelector('.box-container');
                branchesList.innerHTML = '';  // Clear the container

                // Loop through branches and add to the list
                branches.forEach(branch => {
                    const branchDiv = document.createElement('div');
                    branchDiv.classList.add('branch');
                    branchDiv.onclick = () => displayBranchDetails(branch.branchId);

                    const img = document.createElement('img');
                    img.src = 'images/BUZZ-Black.png';
                    img.alt = 'branch-logo';
                    branchDiv.appendChild(img);

                    const h4 = document.createElement('h4');
                    h4.innerText = branch.branchName;
                    branchDiv.appendChild(h4);

                    const p = document.createElement('p');
                    p.innerText = branch.branchLocation;
                    branchDiv.appendChild(p);

                    branchesList.appendChild(branchDiv);
                });

                // Add the "Add Branch" button
                const addBranchDiv = document.createElement('div');
                addBranchDiv.classList.add('branch', 'add-branch');
                addBranchDiv.innerHTML = '<span>+</span>';
                addBranchDiv.onclick = () => showForm();
                branchesList.appendChild(addBranchDiv);
            }

            // Initial call to build the branch list when the page loads
            window.onload = rebuildBranchList;
        </script>

</body>
</html>
