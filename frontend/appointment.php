<?php require_once '../frontend/calendar.php';
      require_once '../backend/adminappointments.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../frontend/design/landingappointment.css">
    <link rel="stylesheet" href="../frontend/design/appointment.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Date</title>

</head>
<body>
    <div class="bg-container" >
        <div id="buzz-img">
            <img src="design/image/buzz.png" alt="">
        </div>
        <div id="appointment-form">
             <h2>Buzz & Collective Appointment Form</h2>
        </div>
        <h6>SELECT BRANCH</h6>
        <div class="row">
            <div class="coloumnn">
                <?php
                     $dateComponents = getdate();
                     if(isset($_GET['month']) && isset($_GET['year'])){
                         $month = $_GET['month']; 			     
                         $year = $_GET['year'];
                     }else{
                         $month = $dateComponents['mon']; 			     
                         $year = $dateComponents['year'];
                     }
                    echo build_calendar($month,$year);
                ?>
            </div>
        </div>
    </div>
    
</body>

</html>

