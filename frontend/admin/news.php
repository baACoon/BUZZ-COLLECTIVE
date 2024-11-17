<?php
$newsFile = 'data/news.json'; // Path to the JSON file

// Ensure the JSON file exists
if (!file_exists($newsFile)) {
    file_put_contents($newsFile, json_encode([])); // Create an empty JSON array if the file doesn't exist
}

// Get existing news from the JSON file
$news = json_decode(file_get_contents($newsFile), true) ?? [];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            // Get the data from the form submission
            $title = $_POST['title'] ?? '';
            $subtitle = $_POST['subtitle'] ?? '';
            $description = $_POST['description'] ?? '';

            // Handle the uploaded poster file
            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Ensure upload directory exists
                }
                $posterPath = $uploadDir . basename($_FILES['poster']['name']);
                if (move_uploaded_file($_FILES['poster']['tmp_name'], $posterPath)) {
                    // File uploaded successfully
                } else {
                    $posterPath = ''; // If failed, set an empty path
                }
            } else {
                $posterPath = ''; // No file uploaded or an error occurred
            }

            // Add the new news item
            $news[] = [
                'id' => uniqid(), // Unique ID for the news item
                'title' => $title,
                'subtitle' => $subtitle,
                'description' => $description,
                'poster' => $posterPath,
            ];
        } elseif ($action === 'delete' && isset($_POST['id'])) {
            // Delete the news item
            $id = $_POST['id'];
            $news = array_filter($news, function ($item) use ($id) {
                return $item['id'] !== $id;
            });
            $news = array_values($news); // Re-index the array after deletion
        } elseif ($action === 'edit' && isset($_POST['id'])) {
            // Edit the news item
            $id = $_POST['id'];
            foreach ($news as &$item) {
                if ($item['id'] === $id) {
                    $item['title'] = $_POST['title'] ?? $item['title'];
                    $item['subtitle'] = $_POST['subtitle'] ?? $item['subtitle'];
                    $item['description'] = $_POST['description'] ?? $item['description'];

                    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
                        $posterPath = 'uploads/' . basename($_FILES['poster']['name']);
                        move_uploaded_file($_FILES['poster']['tmp_name'], $posterPath);
                        $item['poster'] = $posterPath;
                    }
                }
            }
        }

        // Save back to the JSON file
        file_put_contents($newsFile, json_encode($news, JSON_PRETTY_PRINT));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective - News</title>
    
    <link rel="stylesheet" href="Designs/news.css">
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
    <aside class="sidebar">
        <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Add this line for the close button -->
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
                        <img src="<?= htmlspecialchars($item['poster']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                        <h2><?= htmlspecialchars($item['title']) ?></h2>
                        <h3><?= htmlspecialchars($item['subtitle']) ?></h3>
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
