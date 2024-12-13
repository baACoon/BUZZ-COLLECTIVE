<?php
$mysqli = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

$selected_branch = isset($_SESSION['selected_branch']) ? $_SESSION['selected_branch'] : null;


if(isset($_GET['date'])){
    $date = $_GET['date'];
    $stmt = $mysqli->prepare("select * from appointments where date = ?");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['timeslot'];
            }
            
            $stmt->close();
        }
    }
}

if(isset($_POST['submit'])){
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $timeslot = $_POST['timeslot'];
    $email = $_POST['email'];
    $phonenum = $_POST['phone_num'];
    $stmt = $mysqli->prepare("select * from appointments where date = ? AND timeslot = ?");
    $stmt->bind_param('ss', $date, $timeslot);
    $services = isset($_POST['services']) ? array_map(function($services){
        return htmlspecialchars($services, ENT_QUOTES, 'UTF-8');
    }, $_POST['services']) :[];
    $services = implode(", ", $services);
    $barber = isset($_POST['barber']) ? htmlspecialchars($_POST['barber'], ENT_QUOTES, 'UTF-8') : '';
   
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            $msg = "<div class='alert alert-danger'>Already Booked</div>";
        }else{
            $stmt = $mysqli->prepare("INSERT INTO appointments (first_name,last_name, email,phone_num,services,barber,date,timeslot) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssssss', $fname,$lname, $email,$phonenum, $services,$barber, $date,$timeslot);
            $stmt->execute();
            $msg = "<div class='alert alert-success'>Booking Successfull</div>";
            $bookings[]=$timeslot;
            $stmt->close();
            $mysqli->close();
        }
    }
    
}


// Ensure the bookings array is returned
?>
