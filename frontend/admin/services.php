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
    <h1>SERVICES</h1>
    <h3>Services</h3>
    <div class="services-list">
        <ul id="services-list">
            <?php foreach ($services as $service) : ?>
                <li class="service-item" onclick="displayServiceDetails('<?php echo $service['id']; ?>')"><?php echo $service['name']; ?></li>
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


    <script>
        let services = <?php echo json_encode($services); ?>;

        function displayServiceDetails(id) {
            const service = services.find(s => s.id === id);
            if (service) {
                document.getElementById('service-name').innerText = service.name;
                document.getElementById('service-id').innerText = service.id;
                document.getElementById('service-with').innerText = service.with;
                document.getElementById('service-price-terms').innerText = service.price_terms;
                document.getElementById('service-fee').innerText = service.fee;
            }
        }

        function openAddForm() {
            document.getElementById('edit-form').style.display = 'block';
            document.getElementById('edit-id').value = '';
            document.getElementById('edit-name').value = '';
            document.getElementById('edit-with').value = '';
            document.getElementById('edit-price-terms').value = '';
            document.getElementById('edit-fee').value = '';
        }

        function openEditForm() {
            document.getElementById('edit-form').style.display = 'block';
            const id = document.getElementById('service-id').innerText;
            const service = services.find(s => s.id === id);
            if (service) {
                document.getElementById('edit-id').value = service.id;
                document.getElementById('edit-name').value = service.name;
                document.getElementById('edit-with').value = service.with;
                document.getElementById('edit-price-terms').value = service.price_terms;
                document.getElementById('edit-fee').value = service.fee;
            }
        }

        function closeEditForm() {
            document.getElementById('edit-form').style.display = 'none';
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

        </script>
</body>
</html>