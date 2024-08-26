<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective - News</title>
    <link rel="stylesheet" href="Designs/news.css">
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
        
    <div class="news-content">
        <div class="news-header">
            <h1>NEWS</h1>
            <button class="news-button" id="addButton">ADD</button>
        </div>
            
        <div class="news" id="newsContainer">
            <img src="images/news1.jpg" alt="News 1" id="newsImg1" data-title="News 1" data-subtitle="Subtitle 1" data-description="Description 1">
            <img src="images/news2.jpg" alt="News 2" id="newsImg2" data-title="News 2" data-subtitle="Subtitle 2" data-description="Description 2">
        </div>
            
        <!-- Form to add news -->
        <div class="news-form" id="newsForm">
            <h2>ADD NEWS</h2>
            <form id="newsSubmissionForm" onsubmit="addNews(event)">
                <label for="poster">Poster</label>
                <input type="file" id="poster" name="poster" accept="image/*" required><br>

                <label for="title">Title</label>
                <input type="text" id="title" name="title" required><br>

                <label for="subtitle">Subtitle</label>
                <input type="text" id="subtitle" name="subtitle" required><br>

                <label for="description">Description</label>
                <input type="text" id="description" name="description" required><br>
                    
                <button type="submit">SAVE</button>
                <button type="button" id="cancelButton">Cancel</button>
            </form>
        </div>

        <!-- Form for editing news -->
        <div class="news-form" id="editNewsForm" style="display: none;">
            <h2>EDIT NEWS</h2>
            <form id="editNewsSubmissionForm" onsubmit="saveNews(event)">
                <label for="editPoster">Poster</label>
                <input type="file" id="editPoster" name="editPoster" accept="image/*"><br>

                <label for="editTitle">Title</label>
                <input type="text" id="editTitle" name="editTitle" required><br>

                <label for="editSubtitle">Subtitle</label>
                <input type="text" id="editSubtitle" name="editSubtitle" required><br>

                <label for="editDescription">Description</label>
                <input type="text" id="editDescription" name="editDescription" required><br>

                <button type="submit">SAVE</button>
                <button type="button" id="deleteButton">DELETE</button>
                <button type="button" id="cancelEditButton">Cancel</button>
            </form>
        </div>
    </div>
        
    <script src="news.js"></script>
</body>
</html>
