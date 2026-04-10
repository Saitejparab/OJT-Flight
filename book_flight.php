<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); 
require 'helpers/init_conn_db.php';                       
?>   
<link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200&display=swap" rel="stylesheet">
<style>
table { background-color: white; }
@font-face { font-family: 'product sans'; src: url('assets/css/Product Sans Bold.ttf'); }
h1{ font-family :'product sans' !important; color:#424242 ; font-size:40px !important; margin-top:20px; text-align:center; }
body {
  background: #bdc3c7;
  background: -webkit-linear-gradient(to right, #2c3e50, #bdc3c7);
  background: linear-gradient(to right, #2c3e50, #bdc3c7);
}
th { font-size: 22px; }
td { margin-top: 10px !important; font-size: 16px; font-weight: bold; color: #424242; }
.rec-date { background: #17a2b8; color: white; padding: 5px 15px; border-radius: 5px; font-size: 18px; margin-bottom: 10px; display: inline-block; }
</style>

<main>
    <?php 
    if(isset($_GET['search_but'])) { 
        $type = $_GET['type'];
        $dep_city = $_GET['dep_city'];  
        $arr_city = $_GET['arr_city'];     
        $f_class = $_GET['f_class'];
        $passengers = $_GET['passengers'];

        if (isset($_GET['step']) && $_GET['step'] == '2') {
            $query_date = $_GET['ret_date'];
            $title = "SELECT RETURN FLIGHT";
        } else {
            $query_date = $_GET['dep_date'];
            $title = "FLIGHTS FROM: <br> $dep_city to $arr_city";
        }

        if($dep_city === $arr_city){
          header('Location: index.php?error=sameval');
          exit();    
        }
    ?>
      <div class="container-md mt-2">
        <h1 class="display-4 text-center text-light"><?php echo $title; ?></h1>
        
        <?php
        // 1. MAIN SEARCH for the exact date
        $sql = 'SELECT * FROM Flight WHERE source=? AND Destination =? AND DATE(departure)=? ORDER BY Price';
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);                
        mysqli_stmt_bind_param($stmt,'sss',$dep_city,$arr_city,$query_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) == 0) {
            echo "<div class='alert alert-danger text-center shadow'>No direct flights found on <b>".date('d-m-Y', strtotime($query_date))."</b>.</div>";
            
            // RECOMMENDATION LOGIC: Check next 2 days
            $count = 0;
            $max_rec = 6;
            
            for($i=1; $i<=2; $i++) {
                if($count >= $max_rec) break;
                
                $next_date = date('Y-m-d', strtotime($query_date . " + $i days"));
                
                $sql_rec = 'SELECT * FROM Flight WHERE source=? AND Destination =? AND DATE(departure)=? ORDER BY Price';
                $stmt_rec = mysqli_prepare($conn, $sql_rec);
                mysqli_stmt_bind_param($stmt_rec,'sss',$dep_city,$arr_city,$next_date);
                mysqli_stmt_execute($stmt_rec);
                $res_rec = mysqli_stmt_get_result($stmt_rec);

                if(mysqli_num_rows($res_rec) > 0) {
                    echo "<div class='rec-date'>Available on ".date('d-m-Y', strtotime($next_date)).":</div>";
                    echo '<table class="table table-striped table-bordered table-hover shadow mb-4">
                            <thead><tr class="text-center">
                                <th scope="col">Airline</th><th scope="col">Departure</th><th scope="col">Arrival</th>
                                <th scope="col">Status</th><th scope="col">Fare</th><th scope="col">Buy</th>
                            </tr></thead><tbody>';
                    
                    while ($row = mysqli_fetch_assoc($res_rec)) {
                        if($count >= $max_rec) break;
                        
                        $price = (int)$row['Price']*(int)$passengers;
                        if($type === 'round') { $price = $price*2; }
                        if($f_class == 'B') { $price += 0.5*$price; }
                        
                        $status_info = getStatus($row['status']); // Helper for status logic

                        echo "<tr class='text-center'>
                                <td>".$row['airline']."</td>
                                <td>".date('H:i', strtotime($row['departure']))."</td>
                                <td>".date('H:i', strtotime($row['arrivale']))."</td>
                                <td><div class='alert ".$status_info['alert']." text-center mb-0 pt-1 pb-1'>".$status_info['text']."</div></td>
                                <td>Rs. ".$price."</td>
                                <td>".getBuyButton($row, $type, $passengers, $price, $f_class, $_GET)."</td>
                              </tr>";
                        $count++;
                    }
                    echo '</tbody></table>';
                }
            }
            if($count == 0) {
                echo "<h4 class='text-center text-light2'>No alternative flights available for the next 2 days.</h4>";
            }
        } else {
            // SHOW ORIGINAL RESULTS IF FOUND
            echo '<table class="table table-striped table-bordered table-hover shadow">
                    <thead><tr class="text-center">
                        <th scope="col">Airline</th><th scope="col">Departure</th><th scope="col">Arrival</th>
                        <th scope="col">Status</th><th scope="col">Fare</th><th scope="col">Buy</th>
                    </tr></thead><tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                $price = (int)$row['Price']*(int)$passengers;
                if($type === 'round') { $price = $price*2; }
                if($f_class == 'B') { $price += 0.5*$price; }
                $status_info = getStatus($row['status']);
                echo "<tr class='text-center'>
                        <td>".$row['airline']."</td>
                        <td>".date('H:i', strtotime($row['departure']))."</td>
                        <td>".date('H:i', strtotime($row['arrivale']))."</td>
                        <td><div class='alert ".$status_info['alert']." text-center mb-0 pt-1 pb-1'>".$status_info['text']."</div></td>
                        <td>Rs. ".$price."</td>
                        <td>".getBuyButton($row, $type, $passengers, $price, $f_class, $_GET)."</td>
                      </tr>";
            }
            echo '</tbody></table>';
        }
        ?>
      </div>
    <?php } ?>
</main>

<?php 
// --- HELPER FUNCTIONS TO CLEAN UP CODE ---
function getStatus($status_val) {
    if($status_val === '' || $status_val === NULL) return ['text' => "Not yet Departed", 'alert' => 'alert-primary'];
    if($status_val === 'dep') return ['text' => "Departed", 'alert' => 'alert-info'];
    if($status_val === 'issue') return ['text' => "Delayed", 'alert' => 'alert-danger'];
    if($status_val === 'arr') return ['text' => "Arrived", 'alert' => 'alert-success'];
    return ['text' => "Unknown", 'alert' => 'alert-secondary'];
}

function getBuyButton($row, $type, $passengers, $price, $f_class, $get_data) {
    if(!isset($_SESSION['userId'])) return "Login to continue";
    if($row['status'] === 'dep') return "Not Available";
    
    $f_id = $row['flight_id'];
    if ($type === 'one') {
        return "<form action='pass_form.php' method='post'>
                <input name='flight_id' type='hidden' value='$f_id'>
                <input name='type' type='hidden' value='one'>
                <input name='passengers' type='hidden' value='$passengers'>
                <input name='price' type='hidden' value='$price'>
                <input name='class' type='hidden' value='$f_class'>
                <button name='book_but' type='submit' class='btn btn-success'><i class='fa fa-check'></i></button>
                </form>";
    } elseif ($type === 'round' && !isset($get_data['step'])) {
        $ret_date = $get_data['ret_date'];
        $url = "book_flight.php?type=round&step=2&out_id=$f_id&dep_city=".$get_data['arr_city']."&arr_city=".$get_data['dep_city']."&ret_date=$ret_date&passengers=$passengers&f_class=$f_class&search_but=Search";
        return "<a href='$url' class='btn btn-primary'>Select Outbound</a>";
    } else {
        $out_id = $get_data['out_id'];
        return "<form action='pass_form.php' method='post'>
                <input name='flight_id' type='hidden' value='$out_id'>
                <input name='ret_flight_id' type='hidden' value='$f_id'>
                <input name='type' type='hidden' value='round'>
                <input name='passengers' type='hidden' value='$passengers'>
                <input name='price' type='hidden' value='$price'>
                <input name='class' type='hidden' value='$f_class'>
                <button name='book_but' type='submit' class='btn btn-success'>Select Return</button>
                </form>";
    }
}
?>

<footer style="position: relative; margin-top:50px; width: 100%; height: 2.5rem;">
  <em><h5 class="text-light text-center p-0 brand mt-2">Online Flight Booking</h5></em>
  <p class="text-light text-center">&copy; <?php echo date('Y');?> - Developed By Saitej Babu Parab</p>
</footer>
<?php subview('footer.php'); ?>