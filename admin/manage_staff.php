<?php 
include_once 'header.php';
// Security: Only Admin can access
if(!isset($_SESSION['adminId'])) { header('Location: ../login.php'); exit(); }

require '../helpers/init_conn_db.php';
 

// --- 1. HANDLE ADD STAFF LOGIC ---
if (isset($_POST['add_staff_but'])) {
    $uname = $_POST['staff_uname'];
    $email = $_POST['staff_email'];
    $pass  = $_POST['staff_pwd']; // For demo, we'll store as plain or hash
    $role  = 'staff';

    // Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$uname' OR email='$email'");
    if(mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username or Email already exists!');</script>";
    } else {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $uname, $email, $pass, $role);
        mysqli_stmt_execute($stmt);
        echo "<script>alert('Staff Account Created Successfully!');</script>";
    }
}

// --- 2. HANDLE DELETE STAFF LOGIC ---
if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    mysqli_query($conn, "DELETE FROM users WHERE user_id=$id AND role='staff'");
    echo "<script>window.location.href='manage_staff.php';</script>";
}
?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-dark text-light rounded">
                    <h5 class="card-title"><i class="fa fa-user-plus"></i> Register Staff</h5>
                    <hr border="1" color="white">
                    <form method="POST">
                        <div class="form-group">
                            <label class="small">Username</label>
                            <input type="text" name="staff_uname" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label class="small">Email ID</label>
                            <input type="email" name="staff_email" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label class="small">Initial Password</label>
                            <input type="password" name="staff_pwd" class="form-control form-control-sm" required>
                        </div>
                        <button type="submit" name="add_staff_but" class="btn btn-primary btn-sm btn-block mt-3">Create Staff Account</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="text-secondary"><i class="fa fa-vcard"></i> Existing Staff Members</h5>
                    <table class="table table-hover mt-3">
                        <thead class="thead-light">
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($conn, "SELECT * FROM users WHERE role='staff'");
                            if(mysqli_num_rows($res) == 0) {
                                echo "<tr><td colspan='4' class='text-center text-muted'>No staff members registered yet.</td></tr>";
                            }
                            while($row = mysqli_fetch_assoc($res)) {
                                echo "<tr>
                                    <td><strong>{$row['username']}</strong></td>
                                    <td>{$row['email']}</td>
                                    <td><span class='badge badge-warning'>Staff</span></td>
                                    <td>
                                        <a href='manage_staff.php?del_id={$row['user_id']}' 
                                           onclick='return confirm(\"Are you sure?\")' 
                                           class='btn btn-outline-danger btn-sm'>Remove</a>
                                    </td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include_once 'footer.php'; ?>