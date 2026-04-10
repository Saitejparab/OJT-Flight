<?php
require 'helpers/init_conn_db.php';

$new_password = "12345";
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
$admin_id = 1;

$sql = "UPDATE admin SET admin_pwd=? WHERE admin_id=?";
$stmt = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "si", $hashed_password, $admin_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "Admin password successfully updated to: " . $new_password;
    } else {
        echo "Error updating password.";
    }
}
?>