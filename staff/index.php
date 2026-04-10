<?php 
require 'header.php'; 
require '../helpers/init_conn_db.php'; 

if(!isset($_SESSION['staffId'])) { header('Location: login.php'); exit(); }

// --- LOGIC: Sync with Admin Keywords ---
if (isset($_POST['update_status_but'])) {
    $fid = $_POST['flight_id'];
    $status = $_POST['status']; 
    $delay = (int)$_POST['delay_mins'];

    if ($status == 'issue' && $delay > 0) {
        $sql = "UPDATE Flight SET departure = DATE_ADD(departure, INTERVAL ? MINUTE), 
                arrivale = DATE_ADD(arrivale, INTERVAL ? MINUTE), status = ? WHERE flight_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'iisi', $delay, $delay, $status, $fid);
    } else {
        $sql = "UPDATE Flight SET status = ? WHERE flight_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'si', $status, $fid);
    }
    mysqli_stmt_execute($stmt);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h5 class="mb-4 text-muted"><i class="fa fa-list"></i> Flight Operations (Sorted: Latest First)</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Flight ID</th>
                                <th>Date</th> <th>Route</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Update</th>
                                <th>Manifest</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // UPDATED LOGIC: Sort by Departure Date and Time DESC (Latest First)
                            // Removed the CURDATE() filter to show all flights in order, as per your "latest first" request
                            $res = mysqli_query($conn, "SELECT * FROM Flight ORDER BY departure DESC");
                            
                            while ($row = mysqli_fetch_assoc($res)) {
                                $fid = $row['flight_id'];
                                $flight_date = date('d-M-Y', strtotime($row['departure']));
                                $flight_time = date('H:i', strtotime($row['departure']));
                                
                                echo "<tr>
                                    <td><b>#$fid</b></td>
                                    <td>$flight_date</td> <td>{$row['source']} to {$row['Destination']}</td>
                                    <td>$flight_time</td>
                                    <td><span class='badge badge-secondary'>{$row['status']}</span></td>
                                    <td>
                                        <form method='POST' class='form-inline'>
                                            <input type='hidden' name='flight_id' value='$fid'>
                                            <select name='status' class='form-control form-control-sm mr-1 stat-sel'>
                                                <option value=''>On-Time</option>
                                                <option value='issue'>Delayed</option>
                                                <option value='dep'>Departed</option>
                                                <option value='arr'>Arrived</option>
                                            </select>
                                            <input type='number' name='delay_mins' class='form-control form-control-sm mr-1 d-input' style='width:60px; display:none;' placeholder='Min'>
                                            <button type='submit' name='update_status_but' class='btn btn-primary btn-sm'>Update</button>
                                        </form>
                                    </td>
                                    <td><button class='btn btn-sm btn-dark' onclick='toggleManifest($fid)'>View List</button></td>
                                </tr>
                                <tr id='row-$fid' style='display:none;' class='bg-light'>
                                    <td colspan='7'> <div class='p-3 shadow-sm bg-white rounded'>
                                            <h6 class='text-primary font-weight-bold'>Passenger List - Flight #$fid ($flight_date)</h6>
                                            <table class='table table-sm table-bordered mt-2'>
                                                <tr class='bg-secondary text-white'><th>Name</th><th>Seat</th><th>Mobile</th></tr>";
                                                
                                                $p_res = mysqli_query($conn, "SELECT p.*, t.seat_no FROM passenger_profile p JOIN ticket t ON p.passenger_id=t.passenger_id WHERE t.flight_id=$fid");
                                                while($p = mysqli_fetch_assoc($p_res)) {
                                                    echo "<tr><td>{$p['f_name']} {$p['l_name']}</td><td>{$p['seat_no']}</td><td>{$p['mobile']}</td></tr>";
                                                }
                                echo "</table></div></td></tr>";
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 bg-dark text-white p-3 sticky-top" style="top: 20px;">
                <h6><i class="fa fa-search"></i> Passenger Search</h6>
                <input type="text" id="s_name" class="form-control form-control-sm mb-2" placeholder="Enter Name...">
                <button onclick="doSearch()" class="btn btn-primary btn-sm btn-block">Search Passenger</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="s_modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Passenger Details & Ticket Info</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="s_result"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
function toggleManifest(id) { $('#row-' + id).toggle(); }

$('.stat-sel').on('change', function() {
    $(this).next('.d-input').toggle(this.value === 'issue');
});

function doSearch() {
    let n = $('#s_name').val();
    if(!n) return;
    $('#s_result').html('<div class="text-center p-3"><i class="fa fa-spinner fa-spin"></i> Searching...</div>');
    $('#s_modal').modal('show');
    $.get('search_logic.php?name=' + encodeURIComponent(n), function(data) {
        $('#s_result').html(data);
    });
}

function viewTicket(pid) {
    $('#s_result').html('<div class="text-center p-3"><i class="fa fa-spinner fa-spin"></i> Fetching Ticket details...</div>');
    $.get('search_logic.php?passenger_id=' + pid, function(data) {
        $('#s_result').html(data);
    });
}
</script>