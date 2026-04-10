<?php
require '../helpers/init_conn_db.php';

// Check if we are fetching a specific ticket or doing a general search
if(isset($_GET['passenger_id'])) {
    // --- PART 2: FETCH SPECIFIC TICKET DETAILS (Including Flight ID) ---
    $pid = $_GET['passenger_id'];
    
    // Updated SQL to explicitly select flight_id and airline info
    $sql = "SELECT p.*, t.seat_no, t.flight_id, f.source, f.Destination, f.departure, f.airline 
            FROM passenger_profile p 
            JOIN ticket t ON p.passenger_id = t.passenger_id 
            JOIN Flight f ON t.flight_id = f.flight_id
            WHERE p.passenger_id = ?";
            
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $pid);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $r = mysqli_fetch_assoc($res);

    if($r) {
        echo "<div class='p-3 border' style='border-left: 5px solid #007bff !important; background-color: #f8f9fa;'>";
        echo "<h5><i class='fa fa-id-card'></i> Ticket & Flight Details</h5><hr>";
        
        // Added Flight ID here as requested
        echo "<p style='font-size:1.1rem;'><b>Flight ID:</b> <span class='text-primary'>#{$r['flight_id']}</span></p>";
        
        echo "<p><b>Passenger Name:</b> {$r['f_name']} {$r['l_name']}</p>";
        echo "<p><b>Route:</b> {$r['source']} <i class='fa fa-arrow-right px-2'></i> {$r['Destination']}</p>";
        echo "<p><b>Airline:</b> {$r['airline']}</p>";
        echo "<p><b>Departure:</b> ".date('d-M-Y | H:i', strtotime($r['departure']))."</p>";
        echo "<p><b>Seat Number:</b> <span class='badge badge-success' style='font-size:1.1rem;'>{$r['seat_no']}</span></p>";
        echo "<p><b>Contact:</b> {$r['mobile']}</p>";
        
        echo "<hr>";
        // Added a back button to make it easy for staff to return to the search list
        echo "<button onclick='doSearch()' class='btn btn-secondary btn-sm'><i class='fa fa-arrow-left'></i> Back to Results</button>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: Ticket information could not be retrieved.</div>";
    }
    exit();
}

// --- PART 1: GENERAL SEARCH LIST ---
if(isset($_GET['name'])) {
    $name = "%" . $_GET['name'] . "%";
    
    // Selecting f_name, l_name, flight_id, and passenger_id
    $sql = "SELECT p.*, t.flight_id FROM passenger_profile p 
            JOIN ticket t ON p.passenger_id = t.passenger_id 
            WHERE p.f_name LIKE ? OR p.l_name LIKE ?
            ORDER BY p.passenger_id DESC LIMIT 10";
            
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $name, $name);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($res) > 0) {
        echo "<h6>Matching Passengers Found:</h6>";
        echo "<table class='table table-sm table-hover mt-2'>
                <thead class='thead-dark'>
                    <tr>
                        <th>Name</th>
                        <th>Flight ID</th>
                        <th class='text-right'>Action</th>
                    </tr>
                </thead>
                <tbody>";
        while($r = mysqli_fetch_assoc($res)) {
            echo "<tr>
                    <td>{$r['f_name']} {$r['l_name']}</td>
                    <td><span class='badge badge-info'>#{$r['flight_id']}</span></td>
                    <td class='text-right'>
                        <button onclick='viewTicket({$r['passenger_id']})' class='btn btn-primary btn-sm'>
                            <i class='fa fa-eye'></i> View
                        </button>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning'><i class='fa fa-info-circle'></i> No passengers found matching <b>'".$_GET['name']."'</b>.</div>";
    }
}
?>