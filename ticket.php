<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<style>
/* Keeping your original styles */
body {
    background:url('assets/images/plane2.jpg') no-repeat 0px 0px;
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
}
@font-face {
  font-family: 'product sans';
  src: url('assets/css/Product Sans Bold.ttf');
}
h2.brand { font-size: 27px !important; }
.vl { border-left: 6px solid #424242; height: 400px; }
p.head { text-transform: uppercase; font-family: arial; font-size: 17px; margin-bottom: 10px; color: grey; }
p.txt { text-transform: uppercase; font-family: arial; font-size: 25px; font-weight: bolder; }
.out {
    border-top-left-radius: 25px;
    border-bottom-left-radius: 25px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  
    background-color: white;
    padding-left: 25px;
    padding-right: 0px;
    padding-top: 20px;
}
h2 { font-weight: lighter !important; font-size: 35px !important; margin-bottom: 20px; font-family :'product sans' !important; font-weight: bolder; }
h1 { font-weight: lighter !important; font-size: 45px !important; margin-bottom: 20px; font-family :'product sans' !important; font-weight: bolder; }

/* NEW: List View Styling */
.ticket-row {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    transition: 0.3s;
}
.ticket-row:hover { transform: scale(1.01); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
.modal-lg { max-width: 90% !important; }
</style>

<main>
  <?php if(isset($_SESSION['userId'])) {   
    require 'helpers/init_conn_db.php';   
    
    // Cancellation logic stays exactly as you had it
    if(isset($_POST['cancel_but'])) {
        $ticket_id = $_POST['ticket_id'];
        $sql = 'SELECT * FROM Ticket WHERE ticket_id=?';
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)) {
            mysqli_stmt_bind_param($stmt,'i',$ticket_id);            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {   
              $sql_pas = 'DELETE FROM Passenger_profile WHERE passenger_id=?';
              $stmt_pas = mysqli_stmt_init($conn);
              if(mysqli_stmt_prepare($stmt_pas,$sql_pas)) {
                  mysqli_stmt_bind_param($stmt_pas,'i',$row['passenger_id']);            
                  mysqli_stmt_execute($stmt_pas);
                  $sql_t = 'DELETE FROM Ticket WHERE ticket_id=?';
                  $stmt_t = mysqli_stmt_init($conn);
                  if(mysqli_stmt_prepare($stmt_t,$sql_t)) {
                      mysqli_stmt_bind_param($stmt_t,'i',$row['ticket_id']);            
                      mysqli_stmt_execute($stmt_t);
                  }                  
              }              
            }
        }        
    }
    ?>

    <div class="container mb-5"> 
        <h1 class="text-center text-light mt-4 mb-4">MY BOOKINGS</h1>

        <?php 
        // CHANGED: Added ORDER BY ticket_id DESC to show newer ones first
        $sql = 'SELECT * FROM Ticket WHERE user_id=? ORDER BY ticket_id DESC';
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)) {
            mysqli_stmt_bind_param($stmt,'i',$_SESSION['userId']);            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($result)) {   
                $sql_p = 'SELECT * FROM Passenger_profile WHERE passenger_id=?';
                $stmt_p = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt_p,$sql_p);
                mysqli_stmt_bind_param($stmt_p,'i',$row['passenger_id']);            
                mysqli_stmt_execute($stmt_p);
                $row_p = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_p));

                $sql_f = 'SELECT * FROM Flight WHERE flight_id=?';
                $stmt_f = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt_f,$sql_f);
                mysqli_stmt_bind_param($stmt_f,'i',$row['flight_id']);            
                mysqli_stmt_execute($stmt_f);
                $row_f = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_f));

                if($row_f) {
                    $date_time_dep = $row_f['departure'];
                    $date_dep = substr($date_time_dep,0,10);
                    $time_dep = substr($date_time_dep,10,6) ;    
                    $date_time_arr = $row_f['arrivale'];
                    $date_arr = substr($date_time_arr,0,10);
                    $time_arr = substr($date_time_arr,10,6) ; 
                    $class_txt = ($row['class'] === 'E') ? 'ECONOMY' : 'BUSINESS';
                    ?>

                    <div class="ticket-row row align-items-center">
                        <div class="col-md-2 text-center">
                            <h5 class="mb-0"><?php echo $row_f['airline']; ?></h5>
                            <small class="text-muted"><?php echo $class_txt; ?></small>
                        </div>
                        <div class="col-md-3 text-center">
                            <span class="h5"><?php echo $row_f['source']; ?></span>
                            <br><i class="fa fa-arrow-right text-info"></i><br>
                            <span class="h5"><?php echo $row_f['Destination']; ?></span>
                        </div>
                        <div class="col-md-3 text-center">
                            <p class="mb-0"><strong>DEP:</strong> <?php echo $date_dep; ?> (<?php echo $time_dep; ?>)</p>
                            <p class="mb-0"><strong>ARR:</strong> <?php echo $date_arr; ?> (<?php echo $time_arr; ?>)</p>
                        </div>
                        <div class="col-md-2 text-center">
                            <p class="mb-0">Seat: <strong><?php echo $row['seat_no']; ?></strong></p>
                            <p class="mb-0">Rs. <?php echo $row['cost']; ?></p>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal<?php echo $row['ticket_id']; ?>">
                                <i class="fa fa-expand"></i> OPEN TICKET
                            </button>
                        </div>
                    </div>

                    <div class="modal fade" id="modal<?php echo $row['ticket_id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content" style="background: transparent; border: none;">
                                <div class="modal-body p-0">
                                    <div class="row m-0">
                                        <div class="col-md-9 out p-4">
                                            <div class="row">
                                                <div class="col"><h2 class="text-secondary mb-0 brand">Online Flight Booking</h2></div>
                                                <div class="col"><h2 class="mb-0"><?php echo $class_txt; ?> CLASS</h2></div>
                                            </div>
                                            <hr>
                                            <div class="row mb-3">
                                                <div class="col-4"><p class="head">Airline</p><p class="txt"><?php echo $row_f['airline']; ?></p></div>
                                                <div class="col-4"><p class="head">from</p><p class="txt"><?php echo $row_f['source']; ?></p></div>
                                                <div class="col-4"><p class="head">to</p><p class="txt"><?php echo $row_f['Destination']; ?></p></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-8"><p class="head">Passenger</p><p class="h5 text-uppercase"><?php echo $row_p['f_name'].' '.$row_p['m_name'].' '.$row_p['l_name']; ?></p></div>
                                                <div class="col-4"><p class="head">board time</p><p class="txt">12:45</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3"><p class="head">departure</p><p class="txt mb-1"><?php echo $date_dep; ?></p><p class="h1 font-weight-bold"><?php echo $time_dep; ?></p></div>
                                                <div class="col-3"><p class="head">arrival</p><p class="txt mb-1"><?php echo $date_arr; ?></p><p class="h1 font-weight-bold"><?php echo $time_arr; ?></p></div>
                                                <div class="col-3"><p class="head">gate</p><p class="txt">A22</p></div>
                                                <div class="col-3"><p class="head">seat</p><p class="txt"><?php echo $row['seat_no']; ?></p></div>
                                            </div>
                                            
                                            <div class="row mt-4">
                                                <div class="col-6">
                                                    <form action="ticket.php" method="post">
                                                        <input type="hidden" name="ticket_id" value="<?php echo $row['ticket_id']; ?>">
                                                        <button name="cancel_but" class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Cancel Ticket</button>
                                                    </form>
                                                </div>
                                                <div class="col-6">
                                                    <form action="e_ticket.php" method="post" target="_blank">
                                                        <input type="hidden" name="ticket_id" value="<?php echo $row['ticket_id']; ?>">
                                                        <button name="print_but" class="btn btn-primary btn-block"><i class="fa fa-print"></i> Print Ticket</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 p-4 text-center" style="background-color:#376b8d; border-top-right-radius: 25px; border-bottom-right-radius: 25px;">
                                            <h2 class="text-light brand">FlyHigh</h2>
                                            <img src="assets/images/airtic.png" class="img-fluid my-3" style="max-height: 150px;">
                                            <p class="text-light small mt-3">Thank you for choosing us. Please be at the gate on time.</p>
                                            <button type="button" class="btn btn-outline-light btn-sm mt-4" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
  <?php } ?>
</main>
<?php subview('footer.php'); ?>