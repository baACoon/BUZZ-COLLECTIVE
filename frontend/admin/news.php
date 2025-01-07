<?php
// Database connection
$mysqli = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

if (!isset($_SESSION['username'])) {
    header('Location: admin_log.php');
    exit();
}

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            // Add news
            $title = $_POST['title'] ?? '';
            $subtitle = $_POST['subtitle'] ?? '';
            $description = $_POST['description'] ?? '';
            $posterPath = '';
        
            // Handle uploaded poster
            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fullPosterPath = $uploadDir . basename($_FILES['poster']['name']);
                if (move_uploaded_file($_FILES['poster']['tmp_name'], $fullPosterPath)) {
                    $posterPath = 'admin/uploads/' . basename($_FILES['poster']['name']); // Relative path for the database
                }
            }
        
            // Insert into database
            $stmt = $mysqli->prepare("INSERT INTO news (title, subtitle, description, poster) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $title, $subtitle, $description, $posterPath);
            $stmt->execute();
            $stmt->close();
        } elseif ($action === 'delete' && isset($_POST['id'])) {
            // Delete news
            $id = $_POST['id'];
            $stmt = $mysqli->prepare("DELETE FROM news WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action === 'edit' && isset($_POST['id'])) {
            // Edit news
            $id = $_POST['id'];
            $title = $_POST['title'] ?? '';
            $subtitle = $_POST['subtitle'] ?? '';
            $description = $_POST['description'] ?? '';
            $posterPath = '';

            // Handle uploaded poster
            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
                $posterPath = 'admin/uploads/' . basename($_FILES['poster']['name']);
                move_uploaded_file($_FILES['poster']['tmp_name'], $posterPath);
            }

            // Update in database
            if (!empty($posterPath)) {
                $stmt = $mysqli->prepare("UPDATE news SET title = ?, subtitle = ?, description = ?, poster = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $title, $subtitle, $description, $posterPath, $id);
            } else {
                $stmt = $mysqli->prepare("UPDATE news SET title = ?, subtitle = ?, description = ? WHERE id = ?");
                $stmt->bind_param("sssi", $title, $subtitle, $description, $id);
            }
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Fetch news from the database
$news = [];
$result = $mysqli->query("SELECT * FROM news ORDER BY id DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $news[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <title>Buzz & Collective - News</title>
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="Designs/news.css?=901">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    
</head>
<body>
    <!-- Navbar for screens below 768px -->
    <div class="mobile-navbar" id="mobile-navbar">
        <div class="mobile-logo">
            <img src="images/BUZZ-Black.png" alt="Buzz Collective Logo">
        </div>
        <i class='bx bx-menu' id="menu-icon"></i>
    </div>

    <aside class="sidebar" id="sidebar">
        <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Close button -->
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
                    <li class="services"><a href="services.php">Services</a><span class="notification-dot"></span></li>
                    <li class="about-us"><a href="admin-aboutus.php">About Us</a></li>
                    <li><a href="news.php">News</a></li>
                    <li><a href="admin-branches.php">Branches</a></li>
                    <li><a href="settings.php">Settings</a></li>
                </ul>
            </nav>
    </aside>


    <div class="news-content">
        <div class="news-header">
            <h1>NEWS</h1>
            <button class="news-button" id="addButton">ADD</button>
        </div>
        
        <div class="news" id="newsContainer">
            <?php if (!empty($news)): ?>
                <?php foreach ($news as $item): ?>
                    <div class="news-item">
                        <img src="<?= file_exists('../uploads/' . $item['poster']) ? '../uploads/' . htmlspecialchars($item['poster']) : '../design/image/default-placeholder.png' ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                        <h2><?= htmlspecialchars($item['title']) ?></h2>
                        <h4><?= htmlspecialchars($item['subtitle']) ?></h4>
                        <p><?= htmlspecialchars($item['description']) ?></p>
                        <form method="POST" action="news.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
                            <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this news item?');">Delete</button>
                        </form>
                        <button class="edit-button" onclick="editNews('<?= htmlspecialchars(json_encode($item)) ?>')">Edit</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No news available.</p>
            <?php endif; ?>
        </div>

        <div class="news-form" id="newsForm" style="display: none;">
            <h2>ADD/EDIT NEWS</h2>
            <form method="post" enctype="multipart/form-data" action="news.php">
                <input type="hidden" name="id" id="newsId">
                <input type="hidden" name="action" id="newsAction" value="add">

                <label for="poster">Poster</label>
                <input type="file" id="poster" name="poster" accept="image/*"><br>

                <label for="title">Title</label>
                <input type="text" id="title" name="title" required><br>

                <label for="subtitle">Subtitle</label>
                <input type="text" id="subtitle" name="subtitle" required><br>

                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea><br>

                <button type="submit">SAVE</button>
                <button type="button" id="cancelButton">Cancel</button>
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
        // Handle Add News button and form visibility
        document.getElementById('addButton').addEventListener('click', () => {
            document.getElementById('newsForm').style.display = 'block';
            document.getElementById('newsAction').value = 'add';
            document.getElementById('newsId').value = '';
            document.getElementById('title').value = '';
            document.getElementById('subtitle').value = '';
            document.getElementById('description').value = '';
        });

        document.getElementById('cancelButton').addEventListener('click', () => {
            document.getElementById('newsForm').style.display = 'none';
        });

        // Delete news
        function deleteNews(id) {
            if (confirm('Are you sure you want to delete this news item?')) {
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'news.php';

                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'delete';

                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                idInput.value = id;

                form.appendChild(actionInput);
                form.appendChild(idInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Handle Edit functionality
        function editNews(newsItem) {
            const item = JSON.parse(newsItem);
            document.getElementById('newsForm').style.display = 'block';
            document.getElementById('newsAction').value = 'edit';
            document.getElementById('newsId').value = item.id;
            document.getElementById('title').value = item.title;
            document.getElementById('subtitle').value = item.subtitle;
            document.getElementById('description').value = item.description;
        }
    </script>
</body>
</html>
