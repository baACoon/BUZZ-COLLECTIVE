<?php $date = require_once '../frontend/calendar.php';
     $bookings = include '../backend/adminappointments.php';
     if (!is_array($bookings)) {
         $bookings = array(); // ensure $bookings is an array
     }
?>
<?php

$duration = 30;
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
            <img src="public/buzz.png" alt="">
        </div>
        <div id="appointment-form">
             <h2>Buzz & Collective Appointment Form</h2>
        </div>
        <h6>SELECT BRANCH</h6>

        <h1 class="text-center">Choose your Time Availability</h1>
    <hr>

    <div class="row">
        <div class="receipt">
            <?php echo isset($msg) ? $msg : ""; ?>
        </div>
        <div class="appointment-form">
            <form action="" method="post">
                
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
                <div id="stylist">
                    <div class="stylist-item">
                        <img src="design/image/barber5.jpg" alt="Stylist">
                        <p>Adi</p>
                        <input type="radio" name="barber" value="Adi">
                    </div>

                    <div class="stylist-item">
                        <img src="design/image/barber4.jpg" alt="Stylist">
                        <p>Ben</p>
                        <input type="radio" name="barber" value="Ben">
                    </div>

                    <div class="stylist-item">
                        <img src="design/image/Barber 3.jpg" alt="Stylist">
                        <p>Charlie</p>
                        <input type="radio" name="barber" value="Charlie">
                    </div>

                    <div class="stylist-item">
                        <img src="design/image/barber 2.jpg" alt="Stylist">
                        <p>David</p>
                        <input type="radio" name="barber" value="David">
                    </div>

                    <div class="stylist-item">
                        <img src="design/image/Barber1.jpg" alt="Stylist">
                        <p>Edward</p>
                        <input type="radio" name="barber" value="Edward">
                    </div>
                </div>

                
                <div class="form-group">
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
                <div class="form-group pull-right">
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </div>
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
    </script>
</body>

</html>
