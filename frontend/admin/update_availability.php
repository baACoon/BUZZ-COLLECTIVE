<?php
header('Content-Type: application/json');
$mysqli = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

if($mysqli->connect_error){
    die('Connection failed'. $mysqli->connect_error);
}

$success = true; // Initialize success variable

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $availability = $_POST['availability'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    foreach ($availability as $barber => $dates){
        foreach ($dates as $date => $is_available){
            $is_available = $is_available == 1 ? 1 : 0;
            $stmt = $mysqli->prepare("INSERT INTO barber_availability (barber_name, date, is_available) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE is_available=?");
            $stmt->bind_param("ssii", $barber, $date, $is_available, $is_available);
            if (!$stmt->execute()) {
                $success = false;
                $error_message = 'SQL execute failed: ' . $stmt->error;
                break;
            }
            $stmt->close();
        }
        if(!$success){
            break;
        }
    }
    if($success){
        echo json_encode(['success' => true]);
    }else{
        echo json_encode(['success' => false, 'message' => $error_message]);
    }
    exit();
}

$mysqli->close();
header("Location: admin-barber.php?start_date=$startDate&end_date=$endDate");
exit();
?>
