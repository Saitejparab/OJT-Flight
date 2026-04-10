<?php
session_start();
if(isset($_POST['pass_but']) && isset($_SESSION['userId'])) {
    require '../helpers/init_conn_db.php';  
    
    $flight_id = $_POST['flight_id'];
    $passengers = $_POST['passengers'];
    $type = $_POST['type'];
    $class = $_POST['class'];
    $price = $_POST['price'];
    $ret_date = $_POST['ret_date'] ?? null;
    $ret_flight_id = $_POST['ret_flight_id'] ?? null;

    // NEW: Capture the selected seats string from the grid
    $sel_seats_str = $_POST['sel_seats'] ?? '';
    // Convert string "6A,6B" into an array ['6A', '6B']
    $seats_array = explode(',', $sel_seats_str);

    // 1. Validate Mobile Numbers (Indian 10-digit check)
    foreach($_POST['mobile'] as $mob) {
        if(strlen($mob) !== 10) {
            header('Location: ../pass_form.php?error=moblen');
            exit();            
        }
    }

    // 2. Validate Date of Birth (Full Date Comparison)
    $current_date = date('Y-m-d');
    foreach($_POST['date'] as $dob) {        
        if($dob >= $current_date) {
            header('Location: ../pass_form.php?error=invdate');
            exit();
        }      
    }

    // 3. Get the Last Passenger ID to handle Ticket increments
    $sql_last_id = "SELECT passenger_id FROM Passenger_profile ORDER BY passenger_id DESC LIMIT 1";
    $res_last = mysqli_query($conn, $sql_last_id);
    $row_last = mysqli_fetch_assoc($res_last);
    $last_id = $row_last['passenger_id'] ?? 0;

    // 4. Insert Each Passenger into the Database
    $stmt = mysqli_stmt_init($conn);
    $sql_ins = "INSERT INTO Passenger_profile (user_id, mobile, dob, f_name, m_name, l_name, flight_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    if(!mysqli_stmt_prepare($stmt, $sql_ins)) {
        header('Location: ../pass_form.php?error=sqlerror');
        exit();            
    } else {
        // Loop through all passengers and insert
        for($i=0; $i < count($_POST['firstname']); $i++) {
            mysqli_stmt_bind_param($stmt, 'isssssi', 
                $_SESSION['userId'],
                $_POST['mobile'][$i],
                $_POST['date'][$i],
                $_POST['firstname'][$i],
                $_POST['midname'][$i],
                $_POST['lastname'][$i],
                $flight_id
            );
            mysqli_stmt_execute($stmt);
        }
    }

    // 5. Store data in Session for the Payment/Ticket Page
    $_SESSION['flight_id'] = $flight_id;
    $_SESSION['ret_flight_id'] = $ret_flight_id;
    $_SESSION['class'] = $class;
    $_SESSION['passengers'] = $passengers;
    $_SESSION['price'] = $price;
    $_SESSION['type'] = $type;
    $_SESSION['ret_date'] = $ret_date;
    $_SESSION['last_pass_id'] = $last_id; 
    
    // NEW: Store the manually selected seats array in the session
    $_SESSION['selected_seats_array'] = $seats_array;

    header('Location: ../payment.php');
    exit();

    mysqli_stmt_close($stmt);
    mysqli_close($conn);    

} else {
    header('Location: ../pass_form.php');
    exit();  
}