<?php require_once '../frontend/calendar.php'; ?>
<?php require_once '../backend/adminappointments.php'; ?>

<?php $date = require_once '../frontend/calendar.php';
     $bookings = include '../backend/adminappointments.php';
     if (!is_array($bookings)) {
         $bookings = array(); // ensure $bookings is an array
     }
?>
<?php

$duration = 60;
$cleanup = 0;
$start = "09:00";
$end = "21:00";

function timeslots($duration, $cleanup, $start, $end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();

    for ($intStart = $start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }

        $slots[] = $intStart->format("h:i A")."-".$endPeriod->format("h:i A");
    }

    return $slots;

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/landingappointment.css">
    <link rel="stylesheet" href="../frontend/design/appointment.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Date and Time</title>
</head>
<body>
    <div class="bg-container">
        <div id="buzz-img">
            <img src="design/image/buzz.png" alt="">
        </div>
        <div id="appointment-form">
             <h2>Buzz & Collective Appointment Form</h2> <br>
             <p>Main Branch</p>
        </div>
        <form action="appointmentform.php"id="appointmentForm" method="GET">
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
        
        <!-- Time Selection Form -->
        <div class="row">
            <div class="time-selection">
                    <label for="timeslot">Select Time</label>
                    <select name="timeslot" id="timeslot">
                    <?php 
                            $timeslots = timeslots($duration, $cleanup, $start, $end);
                            foreach($timeslots as $ts) {
                                // If the timeslot is booked, disable the option
                                if (in_array($ts, $bookings)) {
                                    echo '<option value="'.$ts.'" disabled>'.$ts.' (Booked)</option>';
                                } else {
                                    echo '<option value="'.$ts.'">'.$ts.'</option>';
                                }
                            }
                        ?>
                    </select>

                    <input type="hidden" name="selected-date" value="<?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>">
                   <!--<input type="submit" id="selected-timeslot" name="selected-timeslot">-->

    
                    <button type="submit" id="selected-timeslot"class="submit-btn" name="selected-timeslot">Proceed</button>
                
            </div>
        </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timeSelect = document.getElementById('timeslot');
            const submitBtn = document.querySelector('.submit-btn');
            const unavailableTimes = ['10:00 AM - 11:00 AM', '02:00 PM - 03:00 PM']; // Mock data

            function isTimeAvailable(time) {
                return !unavailableTimes.includes(time);
            }

            // Event listener for changing time slot
            document.getElementById('timeslot').addEventListener('change', function (event) {
                const selectedTime = this.value;
                document.getElementById('selected-timeslot').value = selectedTime;
                if (selectedTime && isTimeAvailable(selectedTime)) {
                    submitBtn.classList.add('active');
                    submitBtn.classList.remove('unavailable');
                    submitBtn.disabled = false;
                } else {
                    submitBtn.classList.remove('active');
                    submitBtn.classList.add('unavailable');
                    submitBtn.disabled = true;
                }
            });

            document.addEventListener('DOMContentLoaded', function () {
                const dateCells = document.querySelectorAll('td');

                dateCells.forEach(cell => {
                    cell.addEventListener('click', function () {
                        // Remove 'selected' class from all cells
                        dateCells.forEach(c => c.classList.remove('selected'));

                        // Add 'selected' class to the clicked cell
                        if (!this.classList.contains('unavailable')) {
                            this.classList.add('selected');
                        }
                    });
                });
            });

        });

    </script>
</body>
</html>
