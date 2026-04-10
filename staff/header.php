<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Portal | FlyHigh</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .navbar-staff { background-color: #2c3e50; border-bottom: 3px solid #3498db; }
        .nav-link { color: white !important; font-weight: 500; }
        .nav-link:hover { color: #3498db !important; }
        body { background-color: #f4f7f6; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-staff mb-4">
  <a class="navbar-brand text-white" href="index.php"><i class="fa fa-id-badge"></i> STAFF PORTAL</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
      <li class="nav-item">
          <a class="nav-link text-warning" href="../includes/logout.inc.php">
              <i class="fa fa-sign-out"></i> Logout (<?php echo $_SESSION['staffUname']; ?>)
          </a>
      </li>
    </ul>
  </div>
</nav>