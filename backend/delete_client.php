<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ids = isset($_POST['ids']) ? $_POST['ids'] : [];

    if (!empty($ids)) {
        $idString = implode(',', array_map('intval', $ids));

        // Database connection
        $db = mysqli_connect('localhost', 'root', '', 'barbershop');

        if (!$db) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $sql = "DELETE FROM users WHERE id IN ($idString)";
        if (mysqli_query($db, $sql)) {
            echo "Clients deleted successfully.";
        } else {
            echo "Failed to delete clients: " . mysqli_error($db); // Add mysqli_error for more details
        }

        mysqli_close($db);
    } else {
        echo "No client IDs received.";
    }
} else {
    echo "Invalid request method.";
}
?>
