<?php require_once '../frontend/calendar.php'; ?>
<?php require_once '../backend/adminappointments.php'; ?>
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
    
    <style>
        /* Styling for Time Selection */
        .time-selection {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
        }

        .time-selection label {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .time-selection select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #fff;
            color: #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .time-selection .submit-btn {
            background-color: #cccccc;
            color: #666;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
            transition: background-color 0.3s ease;
        }

        .time-selection .submit-btn.active {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .time-selection .submit-btn:hover.active {
            background-color: #0056b3;
        }

        .time-selection .submit-btn.unavailable {
            background-color: #cccccc;
            color: #666;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="bg-container">
        <div id="buzz-img">
            <img src="design/image/buzz.png" alt="">
        </div>
        <div id="appointment-form">
             <h2>Buzz & Collective Appointment Form</h2>
        </div>
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
                <form action="appointmentform.php" method="POST">
                    <label for="appointment-time">Select Time</label>
                    <select name="appointment-time" id="appointment-time">
                        <?php
                        // Start and end times
                        $start_time = strtotime("08:00 AM");
                        $end_time = strtotime("08:00 PM");

                        // Loop through each time slot (1 hour increment)
                        for ($time = $start_time; $time < $end_time; $time = strtotime('+1 hour', $time)) {
                            $start = date("g:i A", $time);
                            $end = date("g:i A", strtotime('+1 hour', $time));
                            echo "<option value='{$start} - {$end}'>{$start} - {$end}</option>";
                        }
                        ?>
                    </select>

                    <input type="hidden" name="selected-date" value="<?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>">

    
                    <button type="submit" class="submit-btn">Proceed</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timeSelect = document.getElementById('appointment-time');
            const submitBtn = document.querySelector('.submit-btn');

            // Mock data for unavailable times (e.g., from server) 
            const unavailableTimes = [
                '10:00 AM - 11:00 AM',
                '02:00 PM - 03:00 PM'
            ];

            function isTimeAvailable(time) {
                return !unavailableTimes.includes(time);
            }

            timeSelect.addEventListener('change', function() {
                const selectedTime = timeSelect.value;
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
        });
    </script>
</body>
</html>
