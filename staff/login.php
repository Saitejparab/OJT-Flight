<?php
session_start();
require '../helpers/init_conn_db.php';

if (isset($_POST['login_but'])) {
    $user = $_POST['user_id'];
    $pass = $_POST['user_pass'];
    $sql = "SELECT * FROM users WHERE (username=? OR email=?) AND role='staff'";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $user, $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)) {
            if($pass == $row['password'] || password_verify($pass, $row['password'])) {
                $_SESSION['staffId'] = $row['user_id'];
                $_SESSION['staffUname'] = $row['username'];
                header("Location: index.php?login=success");
                exit();
            } else { $error = "Invalid Password"; }
        } else { $error = "No Staff Account Found"; }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Portal | FlyHigh</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @font-face { font-family: 'product sans'; src: url('../assets/css/Product Sans Bold.ttf'); }
        body {
            background:url('../assets/images/plane2.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
        }
        .form-out {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  
            background-color: rgba(3, 3, 3, 0.65) !important;
            padding: 40px;
            margin-top: 100px;
            border-radius: 10px;
        }
        input {
            border :0px !important;
            border-bottom: 2px solid #ffffff !important;
            color :#ffffff !important;
            border-radius: 0px !important;
            font-weight: bold !important;
            background-color: transparent !important;  
        }
        label { color : #ffffff !important; font-size: 18px; margin-top: 20px; }
        h1 {
            font-size: 46px !important;
            color: #ffffff !important;
            font-family :'product sans' !important;
            font-weight: bolder;
        }
        .btn-primary { background-color: #007bff; border: none; font-weight: bold; font-size: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 form-out text-center">
            <h1>STAFF LOGIN</h1>
            <?php if(isset($error)) { echo "<script>alert('$error');</script>"; } ?>
            <form method="POST">
                <div class="form-group text-left">
                    <label for="user_id"><i class="fa fa-user mr-2"></i> Username / Email</label>
                    <input type="text" name="user_id" id="user_id" class="form-control" required>
                </div>
                <div class="form-group text-left">
                    <label for="user_pass"><i class="fa fa-lock mr-2"></i> Password</label>
                    <input type="password" name="user_pass" id="user_pass" class="form-control" required>
                </div>
                <button name="login_but" type="submit" class="btn btn-primary btn-block mt-5 p-3">
                    <i class="fa fa-arrow-right mr-2"></i> AUTHORIZE ACCESS
                </button>
            </form>
            <div class="mt-4">
                <a href="../index.php" style="color: #fff; text-decoration: none;">Back to Main Site</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>