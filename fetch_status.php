<?php
require 'helpers/init_conn_db.php';

// 1. Get flights between 'Right Now' and '12 Hours from Now'
$sql = "SELECT * FROM Flight 
        WHERE departure BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 12 HOUR) 
        ORDER BY departure ASC";

$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) == 0) {
    echo "<tr><td colspan='6' class='text-center text-muted'>NO UPCOMING FLIGHTS IN THE NEXT 12 HOURS</td></tr>";
}

while($row = mysqli_fetch_assoc($res)) {
    // 2. Determine Status Labels
    $status_text = "ON TIME";
    $class = "";
    
    if($row['status'] == 'dep') { 
        $status_text = "DEPARTED"; 
        $class = "status-dep"; 
    } elseif($row['status'] == 'arr') { 
        $status_text = "ARRIVED"; 
        $class = "status-arr"; 
    } elseif($row['status'] == 'issue') { 
        $status_text = "DELAYED"; 
        $class = "status-issue blink"; 
    }

    // 3. Format Date/Time (Show 'Tomorrow' if the date is different)
    $dep_time = strtotime($row['departure']);
    $time_display = date('H:i', $dep_time);
    
    // If flight is tomorrow, add a small '+1' or 'Tom' tag
    if(date('Y-m-d', $dep_time) != date('Y-m-d')) {
        $time_display .= " <small class='text-warning'>(Tomorrow)</small>";
    }

    echo "<tr>
            <td>#{$row['flight_id']}</td>
            <td>{$row['airline']}</td>
            <td>{$row['source']} <i class='fa fa-arrow-right'></i> {$row['Destination']}</td>
            <td>$time_display</td>
            <td class='$class'>$status_text</td>
            <td>".($row['status'] == 'issue' ? 'Check with Staff' : 'Gate Open')."</td>
          </tr>";
}
?>