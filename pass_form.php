<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); 
      require 'helpers/init_conn_db.php';                       
?>  
<link rel="stylesheet" href="assets/css/form.css">
<style>
    .main-col { padding: 30px; background-color: whitesmoke; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); margin-top: 50px; }
    .pass-form { background-color: white; border: 2px dashed #607d8b; padding: 20px; margin-top: 30px; border-radius: 8px; }
    body { background: #bdc3c7; background: linear-gradient(to right, #2c3e50, #bdc3c7); font-family: 'Open Sans', sans-serif; }
    @font-face { font-family: 'product sans'; src: url('assets/css/Product Sans Bold.ttf'); }
    h1 { font-size: 42px !important; margin-bottom: 20px; font-family :'product sans' !important; font-weight: bolder; }
    input { border :0px !important; border-bottom: 2px solid #424242 !important; color :#424242 !important; font-weight: bold !important; margin-bottom: 10px; width: 100%; }
    
    .seat-map { display: grid; grid-template-columns: repeat(3, 40px) 20px repeat(3, 40px); gap: 8px; justify-content: center; background: #fff; padding: 20px; border-radius: 15px; }
    .seat-item { width: 40px; height: 40px; background: #fdfdfd; border: 2px solid #34495e; border-radius: 5px; text-align: center; line-height: 36px; font-size: 11px; font-weight: bold; cursor: pointer; transition: 0.2s; }
    .seat-item.booked { background: #e74c3c; color: white; cursor: not-allowed; border: none; }
    .seat-item.selected { background: #2ecc71; color: white; border: none; transform: scale(1.1); }
    .aisle { background: transparent; }
</style>

<?php
    if(isset($_SESSION['userId']) && isset($_POST['book_but'])) {   
        $flight_id = $_POST['flight_id'];
        $passengers = (int)$_POST['passengers']; 
        $price = $_POST['price'];
        $class = $_POST['class'];
        $type = $_POST['type'];
        $ret_flight_id = $_POST['ret_flight_id'] ?? ''; 
?>    
<main>
    <div class="container mb-5">
        <div class="col-md-12 main-col">
            <h1 class="text-center text-secondary">FLYHIGH PASSENGER DETAILS</h1>  
            <form action="includes/pass_detail.inc.php" method="POST" id="bookingForm">

                <input type="hidden" name="type" value="<?php echo $type; ?>">   
                <input type="hidden" name="class" value="<?php echo $class; ?>">   
                <input type="hidden" name="passengers" value="<?php echo $passengers; ?>">   
                <input type="hidden" name="price" value="<?php echo $price; ?>">   
                <input type="hidden" name="flight_id" value="<?php echo $flight_id; ?>"> 
                <input type="hidden" name="ret_flight_id" value="<?php echo $ret_flight_id; ?>"> 
                <input type="hidden" name="sel_seats" id="sel_seats">

                <?php for($i=1; $i <= $passengers; $i++) { ?>
                    <div class="pass-form">  
                        <h4 class="text-info">Passenger #<?php echo $i; ?></h4>
                        <div class="form-row">
                            <div class="col-md-4"><label>Firstname</label><input type="text" name="firstname[]" required></div>
                            <div class="col-md-4"><label>Middlename</label><input type="text" name="midname[]" required></div>
                            <div class="col-md-4"><label>Lastname</label><input type="text" name="lastname[]" required></div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-md-6"><label>Contact No</label><input type="number" name="mobile[]" required></div>
                            <div class="col-md-6"><label>Date of Birth</label><input name="date[]" type="date" required></div>
                        </div>
                    </div>
                <?php } ?>

                <div class="pass-form mt-4">
                    <h3 class="text-center">SELECT YOUR <?php echo ($class == 'B') ? 'BUSINESS' : 'ECONOMY'; ?> SEATS</h3>
                    <p class="text-center">Note: Selected seats will be used for both legs in Round Trips.</p>
                    <div class="text-center mb-3">
                        <span class="badge badge-info p-2">Total Selected: <span id="count">0</span> / <?php echo $passengers; ?></span>
                        <div id="seat_list" class="mt-2 font-weight-bold text-success"></div>
                    </div>

                    <div class="seat-map shadow-sm">
                        <?php 
                        $cols = ['A','B','C','D','E','F'];
                        
                        // 1. Get booked seats for Outbound flight
                        $booked_out = mysqli_query($conn, "SELECT seat_no FROM ticket WHERE flight_id = '$flight_id'");
                        $booked_arr = [];
                        while($b = mysqli_fetch_assoc($booked_out)) { $booked_arr[] = $b['seat_no']; }

                        // 2. NEW: Get booked seats for Return flight (if round trip) to prevent collision
                        if($type === 'round' && !empty($ret_flight_id)) {
                            $booked_ret = mysqli_query($conn, "SELECT seat_no FROM ticket WHERE flight_id = '$ret_flight_id'");
                            while($br = mysqli_fetch_assoc($booked_ret)) { $booked_arr[] = $br['seat_no']; }
                        }

                        $start = ($class == 'B') ? 1 : 6;
                        $end = ($class == 'B') ? 5 : 30;

                        for($r = $start; $r <= $end; $r++) {
                            foreach($cols as $idx => $lt) {
                                if($idx == 3) echo "<div class='aisle'></div>";
                                $s_id = $r . $lt;
                                // A seat is 'booked' if it exists in outbound OR return array
                                $is_booked = in_array($s_id, $booked_arr) ? 'booked' : '';
                                $click = ($is_booked == '') ? "onclick='toggleSeat(\"$s_id\", this)'" : "";
                                echo "<div class='seat-item $is_booked' $click>$s_id</div>";
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="col text-center">
                    <button name="pass_but" type="submit" class="btn btn-success mt-5 shadow">
                        <i class="fa fa-arrow-right"></i> Proceed to Payment  
                    </button>
                </div>         
            </form>               
        </div>
    </div>
</main>

<script>
let selectedSeats = [];
const maxSeats = <?php echo $passengers; ?>;

function toggleSeat(seatId, element) {
    if (element.classList.contains('selected')) {
        element.classList.remove('selected');
        selectedSeats = selectedSeats.filter(s => s !== seatId);
    } else {
        if (selectedSeats.length < maxSeats) {
            element.classList.add('selected');
            selectedSeats.push(seatId);
        } else {
            alert("You can only select " + maxSeats + " seats.");
        }
    }
    document.getElementById('sel_seats').value = selectedSeats.join(',');
    document.getElementById('count').innerText = selectedSeats.length;
    document.getElementById('seat_list').innerText = "Seats: " + selectedSeats.join(', ');
}

document.getElementById('bookingForm').onsubmit = function() {
    if (selectedSeats.length < maxSeats) {
        alert("Please pick " + maxSeats + " seats before paying!");
        return false;
    }
    return true;
};
</script>

<?php 
    } else {
        echo "<div class='container mt-5 alert alert-danger text-center'>Invalid Access.</div>";
    }
    subview('footer.php'); 
?>