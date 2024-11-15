<?php
// Load services data
$services = json_decode(file_get_contents('data/services.json'), true);

// Function to save services data
function saveServices($services) {
    file_put_contents('data/services.json', json_encode($services, JSON_PRETTY_PRINT));
}

// Handle form submission for adding/editing services
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $with = $_POST['with'];
    $price_terms = $_POST['price_terms'];
    $fee = $_POST['fee'];

    // Check if the service already exists
    $serviceIndex = array_search($id, array_column($services, 'id'));

    if ($serviceIndex !== false) {
        // Update existing service
        $services[$serviceIndex] = compact('id', 'name', 'with', 'price_terms', 'fee');
    } else {
        // Add new service
        $services[] = compact('id', 'name', 'with', 'price_terms', 'fee');
    }

    // Save updated services data
    saveServices($services);

    // Return a success response
    echo json_encode(['success' => true]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective - Services</title>
    <link rel="stylesheet" href="Designs/services.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="scripts.js"></script>
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
                <li><a href="clientprofile.php">Client Profile</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </nav>
    </aside>
    <div class="services-header">
        <h1>SERVICES</h1>
    </div>
    
    <div class="content"> 
        <div class="services-list">
            <h3>Services</h3>
            <ul id="services-list">
                <?php foreach ($services as $service) : ?>
                    <li class="service-item" onclick="displayServiceDetails('<?php echo $service['id']; ?>')"><?php echo $service['name']; ?></li>
                    <br>
                <?php endforeach; ?>
            </ul>
            <button class="add-new-service" onclick="openAddForm()">+ Add New Service</button>
        </div>
        
        <div class="subheading">
            <div class="service-details-container">
            <div class="service-details">
                <h4><strong>Information</strong></h4>
                <p><strong>Service Name:</strong> <span  id="service-name"></span>  </p>
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
                    <input type="text" id="edit-id" name="id" placeholder="ID" readonly>
                    <label for="edit-name">Service Name:</label>
                    <input type="text" id="edit-name" name="name" placeholder="Service Name">
                    <label for="edit-with">With:</label>
                    <input type="text" id="edit-with" name="with" placeholder="With">
                    <label for="edit-price-terms">Price Terms:</label>
                    <input type="text" id="edit-price-terms" name="price_terms" placeholder="Price Terms">
                    <label for="edit-fee">Service Fee:</label>
                    <input type="text" id="edit-fee" name="fee" placeholder="Service Fee">
                    <button type="button" class="cancel-btn" onclick="closeEditForm()">Cancel</button>
                    <button type="button" class="save-btn" onclick="saveService()">Save</button>
                </form>
            </div>
        </div>
        </div>
        
    </div>
   
    <script>
        let services = <?php echo json_encode($services); ?>;

        function hideServiceDetails(){
            document.querySelector('.service-details').style.display = 'none';
        }

        function showServiceDetails() {
            document.querySelector('.service-details').style.display = 'block';
        }

        function displayServiceDetails(id) {
            console.log("Clicked ID: ", id); // Log clicked ID
            const service = services.find(s => s.id == id);
            console.log("Found Service: ", service); // Log found service
            if (service) {
                document.getElementById('service-name').innerText = service.name;
                document.getElementById('service-id').innerText = service.id;
                document.getElementById('service-with').innerText = service.with;
                document.getElementById('service-price-terms').innerText = service.price_terms;
                document.getElementById('service-fee').innerText = service.fee;

                // Show the service details and hide the edit form
                showServiceDetails();
                document.getElementById('edit-form').style.display = 'none';

                // Make the service details visible and centered on smaller screens
                const serviceDetails = document.querySelector('.service-details');
                if (window.innerWidth <= 768) {
                    serviceDetails.style.display = 'block';
                }

                // Add bold styling to the selected service item
                const serviceItems = document.querySelectorAll('.service-item');
                serviceItems.forEach(item => {
                    if (item.innerText === service.name) {
                        item.classList.add('bold'); // Add bold class
                    } else {
                        item.classList.remove('bold'); // Remove bold class
                    }
                });
            }
        }

        // Hide service details when clicking outside of it on smaller screens
        document.addEventListener('click', (event) => {
            const serviceDetails = document.querySelector('.service-details');
            if (window.innerWidth <= 768 && serviceDetails.style.display === 'block') {
                if (!serviceDetails.contains(event.target) && !event.target.closest('.service-item')) {
                    serviceDetails.style.display = 'none';
                }
            }
        });

        function openAddForm() {
            const editForm = document.getElementById('edit-form');
            editForm.style.display = 'block';
            document.getElementById('edit-id').value = '';
            document.getElementById('edit-name').value = '';
            document.getElementById('edit-with').value = '';
            document.getElementById('edit-price-terms').value = '';
            document.getElementById('edit-fee').value = '';
            document.querySelector('#edit-form h2').innerText = 'Add Service';

            hideServiceDetails(); // Hide details while form is open

            // Center form on smaller screens
            if (window.innerWidth <= 768) {
                document.body.classList.add('form-open');
            }
        }
        function openEditForm() {
            const editForm = document.getElementById('edit-form');
            editForm.style.display = 'block';

            const id = document.getElementById('service-id').innerText;
            const service = services.find(s => s.id === id);
            if (service) {
                document.getElementById('edit-id').value = service.id;
                document.getElementById('edit-name').value = service.name;
                document.getElementById('edit-with').value = service.with;
                document.getElementById('edit-price-terms').value = service.price_terms;
                document.getElementById('edit-fee').value = service.fee;
                document.querySelector('#edit-form h2').innerText = 'Edit Service';

                hideServiceDetails(); // Hide details while form is open

                // Center form on smaller screens
                if (window.innerWidth <= 768) {
                    document.body.classList.add('form-open');
                }
            }
        }
        function closeForm() {
            document.getElementById('edit-form').style.display = 'none';
            document.body.classList.remove('form-open'); // Restore visibility
            showServiceDetails(); // Optionally show details when form is closed
        }

        function saveService() {
            const id = document.getElementById('edit-id').value;
            const name = document.getElementById('edit-name').value;
            const withs = document.getElementById('edit-with').value;
            const price_terms = document.getElementById('edit-price-terms').value;
            const fee = document.getElementById('edit-fee').value;

            // Create a FormData object to send the data as a POST request
            const formData = new FormData();
            formData.append('id', id);
            formData.append('name', name);
            formData.append('with', withs);
            formData.append('price_terms', price_terms);
            formData.append('fee', fee);

            // Make an AJAX request to save the data
            fetch('services.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // you can change it to .json() if you're sending a JSON response from PHP
            .then(data => {
                if (data) {
                    // Success: Update the services list after saving
                    const service = services.find(s => s.id === id);
                    if (service) {
                        service.name = name;
                        service.with = withs;
                        service.price_terms = price_terms;
                        service.fee = fee;
                    } else {
                        services.push({ id, name, withs, price_terms, fee });
                    }

                    // Update the services list in the UI
                    const servicesList = document.getElementById('services-list');
                    servicesList.innerHTML = '';
                    services.forEach(service => {
                        const li = document.createElement('li');
                        li.classList.add('service-item');
                        li.innerText = service.name;
                        li.onclick = () => displayServiceDetails(service.id);
                        servicesList.appendChild(li);
                        servicesList.appendChild(document.createElement('br'));
                    });

                    closeEditForm();
                } else {
                    alert('An error occurred. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }


        function deleteService() {
            const id = document.getElementById('service-id').innerText;
            services = services.filter(s => s.id !== id);

            // Update the services list
            const servicesList = document.getElementById('services-list');
            servicesList.innerHTML = '';
            services.forEach(service => {
                const li = document.createElement('li');
                li.innerText = service.name;
                li.onclick = () => displayServiceDetails(service.id);
                servicesList.appendChild(li);
                servicesList.appendChild(document.createElement('br'));
            });

            // Clear the service details
            document.getElementById('service-name').innerText = 'Service Name';
            document.getElementById('service-id').innerText = '';
            document.getElementById('service-with').innerText = '';
            document.getElementById('service-price-terms').innerText = '';
            document.getElementById('service-fee').innerText = '';
        }

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

            // Function to toggle visibility of service details on small screens
            function toggleServiceDetails() {
                const serviceDetails = document.querySelector('.service-details');
                if (window.innerWidth < 768) {
                    serviceDetails.style.display = 'none'; // Hide initially on small screens
                }

                // Show details when a service item is clicked
                const serviceItems = document.querySelectorAll('.service-item');
                serviceItems.forEach(item => {
                    item.addEventListener('click', () => {
                        serviceDetails.style.display = 'block';
                    });
                });
            }

            // Call toggleServiceDetails on load and resize
            window.addEventListener('load', toggleServiceDetails);
            window.addEventListener('resize', toggleServiceDetails);

        </script>
</body>
</html>