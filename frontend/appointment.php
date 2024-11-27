
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
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="../frontend/design/landingappointment.css">
    <link rel="stylesheet" href="../frontend/design/appointment.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Date, Time, and Barber Selection</title>
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
        <form action="appointmentform.php" id="appointmentForm" method="POST">
            <div class="row">
                <div class="coloumnn">
                    <?php
                        $dateComponents = getdate();
                        if (isset($_GET['month']) && isset($_GET['year'])) {
                            $month = $_GET['month'];
                            $year = $_GET['year'];
                        } else {
                            $month = $dateComponents['mon'];
                            $year = $dateComponents['year'];
                        }
                        echo build_calendar($month, $year);
                    ?>
                </div>
            </div>
        
            <!-- Time Selection Form -->
            <div class="row">
                <div class="time-selection">
                    <label for="timeslot">SELECT TIME</label>
                    <select name="timeslot" id="timeslot" style="font-family: 'Montserrat', sans-serif; justify-content: center;" required>
                        <?php 
                            $timeslots = timeslots($duration, $cleanup, $start, $end);
                            foreach ($timeslots as $ts) {
                                if (in_array($ts, $bookings)) {
                                    echo '<option value="'.$ts.'" disabled>'.$ts.' (Booked)</option>';
                                } else {
                                    echo '<option value="'.$ts.'">'.$ts.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Barber Selection -->
            <div class="row">
                <div class="barber-selection">
                    <label for="barber"><h4>SELECT BARBER</h4></label>
                    <div id="barber-container" name="barber-container">
                        <!-- Barbers will be dynamically loaded -->
                        <p class="loading-text">Select a date and time to see available barbers.</p>
                    </div>
                </div>
            </div>

            <!-- Change these hidden fields -->
            <input type="hidden" name="date" id="date" value="<?php echo htmlspecialchars($_GET['date'] ?? ''); ?>">
            <input type="hidden" name="barber" id="barber" value="">
            <input type="hidden" name="timeslot" id="timeslot" value="">

            <button type="submit" class="submit-btn">PROCEED</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timeSelect = document.getElementById('timeslot');
            const barberContainer = document.getElementById('barber-container');
            const dateInput = document.getElementById('date');
            const barberInput = document.getElementById('barber');

            // Update time when selected
            timeSelect.addEventListener('change', function () {
                const selectedTime = this.value;
                document.querySelector('input[name="timeslot"]').value = selectedTime;
                if (dateInput.value && selectedTime) {
                    fetchAvailableBarbers(dateInput.value, selectedTime);
                }
            });

            // Update barber when selected
            barberContainer.addEventListener('change', function(e) {
                if(e.target.type === 'radio' && e.target.name === 'barber') {
                    barberInput.value = e.target.value;
                }
            });

            // Add this to handle date selection
            function handleDateSelection(date) {
                dateInput.value = date;
                // Clear previous selections
                timeSelect.value = '';
                barberContainer.innerHTML = '<p class="loading-text">Select a time to see available barbers.</p>';
            }

            // Existing AJAX function to fetch available barbers
            function fetchAvailableBarbers(date, time) {
                barberContainer.innerHTML = 'Loading available barbers...';

                const xhr = new XMLHttpRequest();
                xhr.open('GET', `barberavailability.php?selected_date=${date}&selected_time=${time}`, true);
                xhr.onload = function () {
                    if (this.status === 200) {
                        const barbers = JSON.parse(this.responseText);
                        if (barbers.length > 0) {
                            barberContainer.innerHTML = barbers.map(barber => `
                                <div class='barber-item'>
                                    <input type='radio' name='barber' value='${barber.barber_name}' required>
                                    <label>${barber.barber_name}</label>
                                </div>
                            `).join('');
                        } else {
                            barberContainer.innerHTML = '<p>No available barbers for the selected date and time.</p>';
                        }
                    }
                };
                xhr.send();
            }
        });
    </script>
</body>
</html>
