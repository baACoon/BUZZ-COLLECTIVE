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
    <link rel="stylesheet" href="Designs/services.css">
    <script src="scripts.js" defer></script>
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
                 
    <div class="content">
        <h1>SERVICE</h1>
        <h3>Services</h3>
        <div class="services-list">
            <ul>
                <?php foreach ($services as $service) : ?>
                    <li onclick="displayServiceDetails('<?php echo $service['id']; ?>')"><?php echo $service['name']; ?></li>
                    <br>
                <?php endforeach; ?>
            </ul>
            <button class="add-new-service" onclick="openAddForm()">+ Add New Service</button>
        </div>
        <div class="subheading">
            <h3>Information</h3>
        </div>
        <div class="service-details">
                <h3 id="service-name">Service Name</h3>
                <p><strong>ID:</strong> <span id="service-id"></span></p>
                <p><strong>With:</strong> <span id="service-with"></span></p>
                <p><strong>Price Terms:</strong> <span id="service-price-terms"></span></p>
                <p><strong>Service Fee:</strong> <span id="service-fee"></span></p>
                <button id="edit-button" onclick="openEditForm()">Edit</button>
                <button id="delete-button" onclick="deleteService()">Delete</button>
            </div>
        
        <div class="edit-form" id="edit-form" style="display:none;">
            <h2>Edit Service</h2>
            <form id="edit-service-form">
                <label for="edit-id">ID:</label>
                <input type="text" id="edit-id" name="id" readonly>
                <label for="edit-name">Service Name:</label>
                <input type="text" id="edit-name" name="name">
                <label for="edit-with">With:</label>
                <input type="text" id="edit-with" name="with">
                <label for="edit-price-terms">Price Terms:</label>
                <input type="text" id="edit-price-terms" name="price_terms">
                <label for="edit-fee">Service Fee:</label>
                <input type="text" id="edit-fee" name="fee">
                <button type="button" onclick="closeEditForm()">Cancel</button>
                <button type="button" onclick="saveService()">Save</button>
            </form>
        </div>
    </div>
</body>
</html>
