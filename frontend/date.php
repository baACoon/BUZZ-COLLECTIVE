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

        $slots[] = $intStart->format("H:iA")."-".$endPeriod->format("H:iA");
    }

    return $slots;

}

?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/landingappointment.css">
    <link rel="stylesheet" href="../frontend/design/time.css">
    <title>Appointment Form</title>
  </head>

  <body>
  <div class="bg-container" >
        <div id="buzz-img">
            <img src="design/image/buzz.png" alt="">
        </div>
        <div id="appointment-form">
             <h2>Buzz & Collective Appointment Form</h2>
        </div>

    <div class="row">
        <div class="receipt">
            <?php echo isset($msg) ? $msg : ""; ?>
        </div>
        
        <div class="appointment-form">
            <form id="appointmentForm.php"action="confirmation.php" method="post">
                
                <!-- The rest of the form remains the same, including First Name, Last Name, Email, Phone Number, and Submit button -->
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone_num">Phone Number:</label>
                    <input type="tel" name="phone_num" class="form-control" required>
                </div>

                <h2 class="select">Select Services</h2>

                <div class="form-group services">
                    <label><input type="radio" name="services[]" value="haircut"> Haircut</label>
                    <label><input type="radio" name="services[]" value="kiddie_haircut"> Kiddie Haircut</label>
                    <label><input type="radio" name="services[]" value="haircut_shave"> Haircut and Shave</label>
                    <label><input type="radio" name="services[]" value="hair_art"> Hair Art</label>
                    <label><input type="radio" name="services[]" value="haircut_perm"> Haircut and Perm</label>
                    <label><input type="radio" name="services[]" value="hair_color"> Hair Color</label>
                    <label><input type="radio" name="services[]" value="hair_color_haircut"> Hair Color and Haircut</label>
                    <label><input type="radio" name="services[]" value="scalp_treatment"> Scalp Treatment</label>
                    <label><input type="radio" name="services[]" value="scalp_treatment_haircut"> Scalp Treatment and Haircut</label>
                    <label><input type="radio" name="services[]" value="shave_sculpting"> Shave and Sculpting</label>
                </div>

                <h2 class="select">Stylist</h2>
                <div class="barber-selection">
                    <div class="barber-header">
                        <span>Barber Selection</span>
                        <label for="available-barber">Available Barber</label>
                        <input type="checkbox" id="available-barber" onclick="filterBarbers()">
                    </div>

                    <div id="babers">
                            <div class="barber-item" data-available="true">
                                <input type="radio" name="barber" value="Andre">
                                <p>Andre</p>
                            </div>

                            <div class="barber-item" data-available="false">
                                <input type="radio" name="barber" value="Lucas" disabled>
                                <p>Lucas <span class="status">Unavailable</span></p>
                            </div>

                            <div class="barber-item" data-available="true">
                                <input type="radio" name="barber" value="Nene">
                                <p>Nene</p>
                            </div>

                            <div class="barber-item" data-available="false">
                                <input type="radio" name="barber" value="Baby" disabled>
                                <p>Baby <span class="status">Unavailable</span></p>
                            </div>

                            <div class="barber-item" data-available="false">
                                <input type="radio" name="barber" value="Andre Jr." disabled>
                                <p>Andre Jr. <span class="status">Unavailable</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="time-selection">
                    <label for="timeslot">Select Time Slot:</label>
                    <select name="timeslot" id="timeslot" class="form-control" required>
                        <option value="">--Select Time Slot--</option>
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
                    </div>
                </div>
    
                <button class="proceed" type="submit" name="submit">Proceed</button>
            </form>
        </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        $(".book").click(function(){
            var timeslot = $(this).attr('data-timeslot');
            $("#slot").html(timeslot);
            $("#timeslot").val(timeslot);
            $("#myModal").modal("show");
        })

        function filterBarbers() {
        const isChecked = document.getElementById('available-barber').checked;
        const barberItems = document.querySelectorAll('.barber-item');

        barberItems.forEach(item => {
            const isAvailable = item.getAttribute('data-available') === "true";
            if (isChecked && !isAvailable) {
                item.style.display = 'none'; // Hide unavailable barbers
            } else {
                item.style.display = 'flex'; // Show all barbers when unchecked
            }
        });
    }

        document.getElementById('appointmentForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission behavior
            
            const firstName = document.getElementById('first_name').value.trim();
            const lastName = document.getElementById('last_name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone_num').value.trim();
            const service = document.querySelector('input[name="service"]:checked');
            const barber = document.getElementById('barber').value.trim();

            if (!firstName || !lastName || !email || !phone || !service || !barber) {
                document.getElementById('validationMessage').style.display = 'block';
            } else {
                document.getElementById('validationMessage').style.display = 'none';
                // Set hidden input values
                document.getElementById('timeslot').value = document.getElementById('timeslot').value;
                document.getElementById('selected-date').value = document.getElementById('selected-date').value;
                // Submit form
                event.currentTarget.submit();
            }
        });

    </script>
</body>

</html>
