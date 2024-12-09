<?php
$mysqli = new mysqli('localhost', 'root', '', 'barbershop');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$response = ['success' => false, 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Handle add action
    if ($action === 'add') {
        $barberName = $_POST['barber_name'] ?? '';
        if (!empty($barberName)) {
            $stmt = $mysqli->prepare("INSERT INTO barbers (name) VALUES (?)");
            $stmt->bind_param('s', $barberName);
            $response['success'] = $stmt->execute();
            $stmt->close();
        }
    } 
    // Handle the update action
    elseif ($action === 'update') {
        foreach ($_POST['original_names'] as $index => $originalName) {
            $newName = $_POST['barber_names'][$index] ?? $originalName;
            $stmt = $mysqli->prepare("UPDATE barbers SET name = ? WHERE name = ?");
            $stmt->bind_param('ss', $newName, $originalName);
            $response['success'] = $stmt->execute();
            $stmt->close();
        }
    } 
    // Handle the delete action
    elseif ($action === 'delete') {
        $barberName = $_POST['barber_name'] ?? '';
        if (!empty($barberName)) {
            $stmt = $mysqli->prepare("DELETE FROM barbers WHERE name = ?");
            $stmt->bind_param('s', $barberName);
            $response['success'] = $stmt->execute();
            $stmt->close();
        }
    }
}

echo json_encode($response);
?>
