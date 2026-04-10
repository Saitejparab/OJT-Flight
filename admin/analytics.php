<?php include_once 'header.php'; ?>
<?php require '../helpers/init_conn_db.php'; ?>

<link rel="stylesheet" href="../assets/css/form.css">

<?php if(isset($_SESSION['adminId'])) { 

    // --- DYNAMIC PRICING LOGIC ---
    if(isset($_POST['adjust_price'])) {
        $fid = $_POST['flight_id'];
        $action = $_POST['action']; 
        
        // Adjust price by 10%
        if($action == 'up') {
            $sql = "UPDATE Flight SET Price = Price * 1.10 WHERE flight_id = ?";
        } else {
            $sql = "UPDATE Flight SET Price = Price * 0.90 WHERE flight_id = ?";
        }
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $fid);
        mysqli_stmt_execute($stmt);
        echo "<script>alert('Price adjusted by 10% for Flight #$fid'); window.location='analytics.php';</script>";
    }
?>

<style>
    body {
        background: url('../assets/images/plane3.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Open Sans', sans-serif;
    }
    h1 {
        font-size: 50px !important;
        font-family: 'product sans';
        font-weight: bolder;
        color: white;
    }
    .stats-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        padding: 20px;
        transition: 0.3s;
        border-bottom: 5px solid #28a745;
        height: 100%;
    }
    .stats-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
    .stats-card i { font-size: 40px; color: #5c5c5c; }
    .stats-card h3 { font-weight: bold; margin-top: 10px; color: #333; }
    .stats-card p { font-size: 14px; color: #777; text-transform: uppercase; letter-spacing: 1px; }
    
    .data-panel {
        background: rgba(3, 3, 3, 0.75) !important;
        backdrop-filter: blur(10px);
        padding: 30px;
        border-radius: 20px;
        margin-top: 30px;
        color: white;
    }
    .table { color: white !important; }
    .table thead th { border-top: none; color: #28a745; border-bottom: 2px solid #28a745; }
    .progress { height: 10px; border-radius: 5px; background: #444; }
    
    .badge-high { background-color: #e74c3c; } 
    .badge-stable { background-color: #2ecc71; }
    .badge-low { background-color: #f1c40f; color: #333; }
    
    .btn-adj { padding: 2px 8px; font-size: 12px; font-weight: bold; }
</style>

<main>
    <div class="container mt-4 mb-5">
        <h1 class="text-center mb-4 text-uppercase">System Analytics</h1>

        <?php
            // Logic for the 4 Stat Cards
            $rev_res = mysqli_query($conn, "SELECT SUM(cost) as total FROM ticket");
            $total_rev = mysqli_fetch_assoc($rev_res)['total'] ?? 0;

            $tix_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM ticket");
            $total_tix = mysqli_fetch_assoc($tix_res)['cnt'] ?? 0;

            $flight_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM Flight");
            $active_flights = mysqli_fetch_assoc($flight_res)['cnt'] ?? 0;

            $u_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM users WHERE role='user'");
            $users_cnt = mysqli_fetch_assoc($u_res)['cnt'] ?? 0;
        ?>

        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="stats-card" style="border-color: #28a745;">
                    <i class="fa fa-money text-success"></i>
                    <p>Total Revenue</p>
                    <h3>Rs. <?php echo number_format($total_rev); ?></h3>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-card" style="border-color: #007bff;">
                    <i class="fa fa-ticket text-primary"></i>
                    <p>Tickets Issued</p>
                    <h3><?php echo $total_tix; ?></h3>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-card" style="border-color: #f39c12;">
                    <i class="fa fa-globe text-warning"></i>
                    <p>Total Routes</p>
                    <h3><?php echo $active_flights; ?></h3>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-card" style="border-color: #e74c3c;">
                    <i class="fa fa-user-circle text-danger"></i>
                    <p>Active Users</p>
                    <h3><?php echo $users_cnt; ?></h3>
                </div>
            </div>
        </div>

        <div class="data-panel shadow">
            <h4 class="mb-4 text-center"><i class="fa fa-line-chart"></i> Occupancy & Dynamic Pricing Control</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Flight ID</th>
                            <th>Airline</th>
                            <th>Fare (Current)</th>
                            <th>Occupancy %</th>
                            <th>Status</th>
                            <th>Price(increase/Decrease 10%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // ORDER BY (Booked / Seats) DESC ensures highest occupancy is at the top
                        $sql = "SELECT f.*, (SELECT COUNT(*) FROM ticket t WHERE t.flight_id = f.flight_id) as booked_count 
                                FROM Flight f 
                                ORDER BY (booked_count / f.Seats) DESC 
                                LIMIT 10";
                        $res = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($res)) {
                            $percent = ($row['Seats'] > 0) ? ($row['booked_count'] / $row['Seats']) * 100 : 0;
                            $percent = round($percent, 1);
                            
                            if($percent >= 90) {
                                $bar_color = "bg-danger";
                                $status_badge = '<span class="badge badge-high p-2">High Demand</span>';
                            } elseif($percent >= 20) {
                                $bar_color = "bg-success";
                                $status_badge = '<span class="badge badge-stable p-2">Stable</span>';
                            } else {
                                $bar_color = "bg-warning";
                                $status_badge = '<span class="badge badge-low p-2">Low Demand</span>';
                            }
                        ?>
                        <tr>
                            <td><b>#<?php echo $row['flight_id']; ?></b></td>
                            <td><?php echo $row['airline']; ?></td>
                            <td class="text-success font-weight-bold">Rs. <?php echo number_format($row['Price']); ?></td>
                            <td style="width: 200px;">
                                <small><?php echo $percent; ?>%</small>
                                <div class="progress"><div class="progress-bar <?php echo $bar_color; ?>" style="width: <?php echo $percent; ?>%"></div></div>
                            </td>
                            <td><?php echo $status_badge; ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="flight_id" value="<?php echo $row['flight_id']; ?>">
                                    <input type="hidden" name="action" value="up">
                                    <button type="submit" name="adjust_price" class="btn btn-outline-success btn-adj" title="Increase 10%"><i class="fa fa-arrow-up"></i></button>
                                </form>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="flight_id" value="<?php echo $row['flight_id']; ?>">
                                    <input type="hidden" name="action" value="down">
                                    <button type="submit" name="adjust_price" class="btn btn-outline-danger btn-adj" title="Decrease 10%"><i class="fa fa-arrow-down"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="data-panel" style="min-height: 250px;">
                    <h4><i class="fa fa-pie-chart text-success"></i> Class Revenue Split</h4>
                    <hr style="border-color: #444;">
                    <?php
                        $eco_res = mysqli_query($conn, "SELECT SUM(cost) as total FROM ticket WHERE class='E'");
                        $bus_res = mysqli_query($conn, "SELECT SUM(cost) as total FROM ticket WHERE class='B'");
                        $eco_val = mysqli_fetch_assoc($eco_res)['total'] ?? 0;
                        $bus_val = mysqli_fetch_assoc($bus_res)['total'] ?? 0;
                    ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Economy Class Tickets</span>
                        <span class="text-success font-weight-bold">Rs. <?php echo number_format($eco_val); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span>Business Class Tickets</span>
                        <span class="text-success font-weight-bold">Rs. <?php echo number_format($bus_val); ?></span>
                    </div>
                    <p class="small text-muted text-center font-italic">Revenue calculation based on confirmed ticket sales.</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="data-panel" style="min-height: 250px;">
                    <h4><i class="fa fa-trophy text-warning"></i> Best Selling Airline</h4>
                    <hr style="border-color: #444;">
                    <?php
                        $top_air = mysqli_query($conn, "SELECT airline, COUNT(*) as cnt FROM Flight f JOIN ticket t ON f.flight_id = t.flight_id GROUP BY airline ORDER BY cnt DESC LIMIT 1");
                        $top = mysqli_fetch_assoc($top_air);
                    ?>
                    <div class="text-center">
                        <h2 class="text-warning mt-3"><?php echo strtoupper($top['airline'] ?? 'N/A'); ?></h2>
                        <p class="h5"><?php echo $top['cnt'] ?? 0; ?> Confirmed Bookings</p>
                        <p class="mt-3"><i class="fa fa-star fa-3x text-warning"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php } ?>
<?php include_once 'footer.php'; ?>