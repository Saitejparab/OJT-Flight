<?php
session_start();

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['pay_but']) && isset($_SESSION['userId'])) {
    require '../helpers/init_conn_db.php';  
    require '../vendor/autoload.php'; 

    $user_id = $_SESSION['userId'];
    $flight_id = $_SESSION['flight_id'];
    $ret_flight_id = $_SESSION['ret_flight_id'] ?? null; 
    $price = $_SESSION['price'];
    $passengers = $_SESSION['passengers'];
    $type = $_SESSION['type'];
    $class = $_SESSION['class'];
    $card_no = $_POST['cc-number'];
    $expiry = $_POST['cc-exp'];  

    // 1. INSERT INTO PAYMENT TABLE
    $sql_pay = 'INSERT INTO payment (user_id, expire_date, amount, flight_id, card_no) VALUES (?,?,?,?,?)';            
    $stmt_pay = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt_pay, $sql_pay)) {
        header('Location: ../payment.php?error=sqlerror');
        exit();            
    } else {
        mysqli_stmt_bind_param($stmt_pay, 'isiis', $user_id, $expiry, $price, $flight_id, $card_no);          
        mysqli_stmt_execute($stmt_pay);       
        
        $flag = false;
        $ticket_details = ""; 

        // 2. FETCH PASSENGERS
        $stmt_pass = mysqli_prepare($conn, "SELECT * FROM passenger_profile WHERE user_id = ? AND flight_id = ? ORDER BY passenger_id DESC LIMIT ?");
        mysqli_stmt_bind_param($stmt_pass, "iii", $user_id, $flight_id, $passengers);
        mysqli_stmt_execute($stmt_pass);
        $res_pass = mysqli_stmt_get_result($stmt_pass);
        
        $passenger_data = [];
        while ($p = mysqli_fetch_assoc($res_pass)) { $passenger_data[] = $p; }

        // --- UPDATED HELPER FUNCTION: Uses Manual Seat Selection ---
        function book_leg($f_id, $p_rows, $leg_type, $u_id, $leg_price, $f_class, $conn) {
            $log = "<strong>$leg_type Flight:</strong><br>";
            
            // Get the manually picked seats from the session
            $picked_seats = $_SESSION['selected_seats_array'];

            foreach ($p_rows as $index => $pass_row) {
                $p_id = $pass_row['passenger_id'];
                
                // Use the seat corresponding to the passenger index
                $new_seat = $picked_seats[$index];

                // Update flight capacity only
                $res_f = mysqli_query($conn, "SELECT * FROM flight WHERE flight_id=$f_id");
                $row = mysqli_fetch_assoc($res_f);
                
                if($f_class === 'B') {
                    $seats_left = (int)$row['bus_seats'] - 1;
                    $upd_sql = "UPDATE flight SET last_bus_seat=?, bus_seats=? WHERE flight_id=?";
                } else {
                    $seats_left = (int)$row['Seats'] - 1;
                    $upd_sql = "UPDATE flight SET last_seat=?, Seats=? WHERE flight_id=?";
                }
                
                $upd_stmt = mysqli_prepare($conn, $upd_sql);
                mysqli_stmt_bind_param($upd_stmt, 'sii', $new_seat, $seats_left, $f_id);
                mysqli_stmt_execute($upd_stmt);

                // Insert Ticket with the specific $new_seat from the grid
                $sql_t = 'INSERT INTO ticket (passenger_id, flight_id, seat_no, cost, class, user_id) VALUES (?,?,?,?,?,?)';
                $stmt_t = mysqli_prepare($conn, $sql_t);
                mysqli_stmt_bind_param($stmt_t, 'iisisi', $p_id, $f_id, $new_seat, $leg_price, $f_class, $u_id);
                mysqli_stmt_execute($stmt_t);
                
                $log .= "Passenger: ".$pass_row['f_name']." | Seat: ".$new_seat."<br>";
            }
            return $log;
        }

        // 3. PROCESS THE BOOKING
        $per_leg_price = ($type === 'round') ? ($price / 2) : $price;

        $ticket_details .= book_leg($flight_id, $passenger_data, "Outbound", $user_id, $per_leg_price, $class, $conn);
        $flag = true;

        if($type === 'round' && $ret_flight_id) {
            $ticket_details .= "<br>" . book_leg($ret_flight_id, $passenger_data, "Return", $user_id, $per_leg_price, $class, $conn);
        }

        // 4. EMAIL LOGIC
        if($flag) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'saeetej@gmail.com'; 
                $mail->Password = 'gbyauhrbhqunmqt'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                $mail->Port = 587;
                $mail->setFrom('saeetej@gmail.com', 'FlyHigh Airlines');
                $mail->addAddress('saeetej.af@gmail.com'); 
                $mail->isHTML(true);
                $mail->Subject = 'FlyHigh Booking Confirmation';
                $mail->Body = "<h3>Booking Successful!</h3><p>Total: INR $price</p>$ticket_details";
                // $mail->send(); 
                $_SESSION['mail_status'] = "success";
            } catch (Exception $e) { $_SESSION['mail_status'] = "Offline"; }

            // Clear session variables including the new seats array
            unset($_SESSION['flight_id'], $_SESSION['ret_flight_id'], $_SESSION['passengers'], $_SESSION['price'], $_SESSION['class'], $_SESSION['type'], $_SESSION['ret_date'], $_SESSION['selected_seats_array']);
            
            header('Location: ../pay_success.php');
            exit();
        } else {
            header('Location: ../payment.php?error=sqlerror');
            exit();
        }
    }
} else {
    header('Location: ../payment.php');
    exit();
}