
<?php
// Database connection
$db = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');
if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Fetch existing barber details from the database
$barbers = [];
$query = "SELECT * FROM barbers ORDER BY name";
$result = $db->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $barbers[] = $row;
    }
} else {
    echo "Error fetching barbers: " . $db->error;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        // Add a new barber
        $title = $_POST['title'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $position = $_POST['position'];
        $experience = $_POST['experience'];
        $image = '';

        // Handle image upload
        if (isset($_FILES['backgroundImage']) && $_FILES['backgroundImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'design/image/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $image = $uploadDir . basename($_FILES['backgroundImage']['name']);
            move_uploaded_file($_FILES['backgroundImage']['tmp_name'], $image);
        }

        $stmt = $db->prepare("INSERT INTO barbers (name, age, work, experience, position, image) VALUES (?, ?, '', ?, ?, ?)");
        $stmt->bind_param("sisss", $name, $age, $experience, $position, $image);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'edit') {
        // Edit an existing barber
        $id = $_POST['id'];
        $title = $_POST['title'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $position = $_POST['position'];
        $experience = $_POST['experience'];

        $image = $_POST['currentImage'];
        if (isset($_FILES['backgroundImage']) && $_FILES['backgroundImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'design/image/';
            $image = $uploadDir . basename($_FILES['backgroundImage']['name']);
            move_uploaded_file($_FILES['backgroundImage']['tmp_name'], $image);
        }

        $stmt = $db->prepare("UPDATE barbers SET name = ?, age = ?, work = '', experience = ?, position = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sisssi", $name, $age, $experience, $position, $image, $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete') {
        // Delete a barber
        $id = $_POST['id'];
        $stmt = $db->prepare("DELETE FROM barbers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    // Refresh page to reflect changes
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../design/image/buzznCollectives.jpg">
    <title>Buzz & Collective - About Us</title>
    <link rel="stylesheet" href="Designs/aboutus.css?v=901">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
    <body>
    <div class="mobile-navbar" id="mobile-navbar">
            <div class="mobile-logo">
                <img src="images/BUZZ-Black.png" alt="Buzz Collective Logo">
            </div>
            <i class='bx bx-menu' id="menu-icon"></i>
        </div>
        
        <aside class="sidebar" id="sidebar">
            <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Add this line for the close button -->
            <div class="logo">
                <a href="../admin/admin-home.php">
                    <img src="images/BUZZ-White.png" alt="Buzz Collective Logo">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="admin-appointment.php">Appointment Bookings</a></li>
                    <li><a href="admin-barber.php">Barbers' Schedule</a></li>
                    <li><a href="services.php">Services</a><span class="notification-dot"></span></li>
                    <li class="has-submenu">
                        <a href="admin-aboutus.php" class="parent-menu">About Us</a>
                        <ul class="submenu">
                            <li><a href="aboutus.php">Barbers</a></li>
                                <li><a href="aboutushiring.php">Hiring</a></li>
                            </ul>
                    </li>
                    <li><a href="news.php">News</a></li>
                    <li><a href="admin-branches.php">Branches</a></li>
                    <li><a href="settings.php">Settings</a></li>
                </ul>
            </nav>
        </aside>


        <div class="aboutus-content">
            <h1>ABOUT US <span class="barberspan">BARBERS</span></h1>
            <div class="aboutus-container" id="aboutUsContainer">
                <?php if (!empty($barbers)): ?>
                    <?php foreach ($barbers as $barber): ?>
                        <div class="barber-container">
                            <div class="item-background" style="background-image: url('<?= htmlspecialchars($barber['image']) ?>');"></div>
                            <div class="barber">
                                <h2><?= htmlspecialchars($barber['position']) ?></h2>
                                <h3><?= htmlspecialchars($barber['name']) ?></h3>
                                <p>Age: <?= htmlspecialchars($barber['age']) ?></p>
                                <p>Position: <?= htmlspecialchars($barber['position']) ?></p>
                                <p>Experience: <?= htmlspecialchars($barber['experience']) ?></p>
                                <div class="button-container">
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this barber?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($barber['id']) ?>">
                                        <button type="submit" class="delete-button">DELETE</button>
                                    </form>
                                    <button class="edit-button" onclick="editBarber('<?= htmlspecialchars(json_encode($barber)) ?>')">EDIT</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="barber add-barber" id="addBarber" onclick="showForm()">
                        <span>+</span>
                    </div>
                <?php else: ?>
                    <p>No barbers available.</p>
                <?php endif; ?>
            </div>
            <div class="barber aboutus-form" id="aboutUsForm" style="display: none;">
                <h2>ADD/EDIT BARBER</h2>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="barberId">
                    <input type="hidden" name="action" id="barberAction" value="add">
                    <input type="hidden" name="currentImage" id="currentImage">

                    <label for="backgroundImage">Background Image</label>
                    <input type="file" id="backgroundImage" name="backgroundImage" accept="image/*"><br>

                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required><br>

                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required><br>

                    <label for="age">Age</label>
                    <input type="text" id="age" name="age" required><br>

                    <label for="position">Position</label>
                    <input type="text" id="position" name="position" required><br>

                    <label for="experience">Experience</label>
                    <textarea id="experience" name="experience" required></textarea><br>
                    
                    <div class="form-buttons">
                        <button type="submit">SAVE</button>
                        <button type="button" onclick="hideForm()">CANCEL</button>
                    </div>
                </form>
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
        // Handle Add/Edit functionality
        document.getElementById('addButton').onclick = () => {
            document.getElementById('barberAction').value = 'add';
            document.getElementById('aboutUsForm').style.display = 'block';
        };

        document.getElementById('cancelButton').onclick = () => {
            document.getElementById('aboutUsForm').style.display = 'none';
        };
        function showForm() {
            document.getElementById('aboutUsForm').style.display = 'block';
            document.getElementById('barberAction').value = 'add';
            document.getElementById('barberId').value = '';
            document.getElementById('title').value = '';
            document.getElementById('name').value = '';
            document.getElementById('age').value = '';
            document.getElementById('position').value = '';
            document.getElementById('experience').value = '';
            document.getElementById('currentImage').value = '';
        }

        function hideForm() {
            document.getElementById('aboutUsForm').style.display = 'none';
        }

        function editBarber(barberJson) {
            const barber = JSON.parse(barberJson);
            document.getElementById('aboutUsForm').style.display = 'block';
            document.getElementById('barberAction').value = 'edit';
            document.getElementById('barberId').value = barber.id;
            document.getElementById('title').value = barber.position;
            document.getElementById('name').value = barber.name;
            document.getElementById('age').value = barber.age;
            document.getElementById('position').value = barber.position;
            document.getElementById('experience').value = barber.experience;
            document.getElementById('currentImage').value = barber.image;
        }

           // Get the parent menu and submenu
            const parentMenu = document.querySelector('.parent-menu');
            const submenu = document.querySelector('.submenu');

            // Initially hide the submenu
            submenu.style.display = 'none';

            // Add click event listener
            parentMenu.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent the default link action

                // Toggle the visibility of the submenu
                if (submenu.style.display === 'none') {
                    submenu.style.display = 'block';
                } else {
                    submenu.style.display = 'none';
                }
    </script>
</body>
</html>
