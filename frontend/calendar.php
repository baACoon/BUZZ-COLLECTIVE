<?php include 'C:/xampp/htdocs/Project/BUZZ-COLLECTIVE/backend/adminappointments.php' ?>

<?php

function build_calendar($month, $year) {
    /*$mysqli = new mysqli('localhost', 'root', '', 'barbershop');
    $stmt = $mysqli->prepare("select * from bookings where MONTH(date) = ? AND YEAR(date) = ?");
    $stmt->bind_param('ss', $month, $year);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['date'];
            }
            
            $stmt->close();
        }
    }*/
    
    
     // Create array containing abbreviations of days of week.
     $daysOfWeek = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');

     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
     $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
     $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
     $dayOfWeek = $dateComponents['wday'];

     // Create the table tag opener and day headers
     
    $datetoday = date('Y-m-d');
    
    
    $calendar = "<table class='table-bordered'>";
    /*$calendar .= "<center><h2>$monthName $year</h2>";*/
    $calendar .= "<a class='prev_mon' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'><i class='fa-solid fa-angle-left'></i></a>";
    $calendar .= " <a class='curr_mon' href='?month=".date('m')."&year=".date('Y')."'><center><h2>$monthName $year</h2></a> ";                                
    $calendar .= "<a class='next_mon' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'><i class='fa-solid fa-angle-right'></i></a></center><br>";

    
      $calendar .= "<tr>";

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
          $calendar .= "<th  class='header'>$day</th>";
     } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

     $currentDay = 1;

     $calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

     if ($dayOfWeek > 0) { 
         for($k=0;$k<$dayOfWeek;$k++){
                $calendar .= "<td  class='empty'></td>"; 

         }
     }
     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
  
     while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

          if ($dayOfWeek == 7) {

               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";

          }
          
          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
          $date = "$year-$month-$currentDayRel";
          
            $dayname = strtolower(date('l', strtotime($date)));
            $eventNum = 0;
            $today = $date==date('Y-m-d')? "today" : "";
         if($date<date('Y-m-d')){
             $calendar.="<td><h4>$currentDay</h4> <button class='unavailable'>N/A</button>";
         }else{
            //$calendar.="<td class='$today'><h4>$currentDay</h4> <button class='available' onclick='openModal(\"$date\")'>Book</button>";
             $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='date.php?date=".$date."' class='available'>Book</a>";
             /*$calendar .= "<td class='$today'>
                            <h4>$currentDay</h4>
                            <button type='button' class='btn btn-primary book-date' data-date='".$date."'>
                                Select Date
                            </button>
                        </td>";*/
            }

          $calendar .="</td>";
          // Increment counters
 
          $currentDay++;
          $dayOfWeek++;

     }
     
     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
                $calendar .= "<td class='empty'></td>"; 

         }

     }
     
     $calendar .= "</tr>";

     $calendar .= "</table>";

     echo $calendar;

}
?>
