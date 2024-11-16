<?php include '../backend/adminappointments.php' ?>

<?php
function build_calendar($month, $year) {
    $daysOfWeek = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    $numberDays = date('t',$firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $datetoday = date('Y-m-d');
    
    // Check if a date is selected
    $selectedDate = isset($_GET['date']) ? $_GET['date'] : null;

    $calendar = "<table class='table-bordered'>";
    $calendar .= "<a class='prev_mon' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'><i class='fa-solid fa-angle-left'></i></a>";
    $calendar .= "<a class='curr_mon' href='?month=".date('m')."&year=".date('Y')."'><center><h2>$monthName $year</h2></a>";
    $calendar .= "<a class='next_mon' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'><i class='fa-solid fa-angle-right'></i></a></center><br>";
    $calendar .= "<tr>";

    foreach($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    } 

    $currentDay = 1;
    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) { 
        for($k=0; $k<$dayOfWeek; $k++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

        $today = $date == date('Y-m-d') ? "today" : "";
        $selected = $date == $selectedDate ? "selected" : ""; // Highlight selected date

        if ($date < date('Y-m-d')) {
            $calendar .= "<td class='unavailable'><h4>$currentDay</h4> <button class='unavailable'>N/A</button>";
        } else {
            $calendar .= "<td class='$today $selected'><h4>$currentDay</h4> <a href='?date=$date' class='available'>Book</a>";
        }

        $calendar .= "</td>";
        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) { 
        $remainingDays = 7 - $dayOfWeek;
        for ($l=0; $l<$remainingDays; $l++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    return $calendar;
}

?>
