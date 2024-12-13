<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ids = isset($_POST['ids']) ? $_POST['ids'] : [];

    if (!empty($ids)) {
        $idString = implode(',', array_map('intval', $ids));

        // Database connection
        $db = mysqli_connect('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

        if (!$db) {
            echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
            exit;
        }

        $sql = "DELETE FROM users WHERE id IN ($idString)";
        if (mysqli_query($db, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Clients deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete clients: ' . mysqli_error($db)]);
        }

        mysqli_close($db);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No client IDs received.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
