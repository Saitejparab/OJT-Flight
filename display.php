<?php require 'helpers/init_conn_db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Live Flight Status | FlyHigh</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body { background-color: #0b0e11; color: white; font-family: 'Courier New', Courier, monospace; }
        .fids-header { background: #1a1d21; padding: 20px; border-bottom: 4px solid #f39c12; }
        .table { color: #ecf0f1; font-size: 1.2rem; }
        .table thead { color: #f39c12; text-transform: uppercase; }
        .status-dep { color: #3498db; font-weight: bold; }
        .status-arr { color: #2ecc71; font-weight: bold; }
        .status-issue { color: #e74c3c; font-weight: bold; blink; }
        @keyframes blink { 0% { opacity: 1; } 50% { opacity: 0; } 100% { opacity: 1; } }
        .blink { animation: blink 1s infinite; }
    </style>
</head>
<body>

<div class="fids-header d-flex justify-content-between align-items-center">
    <h1><i class="fa fa-plane"></i> LIVE FLIGHT BOARD</h1>
    <h3 id="live-clock"></h3>
</div>

<div class="container-fluid mt-4">
    <table class="table table-borderless">
        <thead>
            <tr>
                <th>Flight</th>
                <th>Airline</th>
                <th>Origin/Destination</th>
                <th>Scheduled</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody id="flight-data">
            </tbody>
    </table>
</div>

<script>
// 1. Update the Clock
setInterval(() => {
    document.getElementById('live-clock').innerText = new Date().toLocaleTimeString();
}, 1000);

// 2. Async Fetch Data
function refreshBoard() {
    fetch('fetch_status.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('flight-data').innerHTML = data;
    });
}

// Initial load + Refresh every 10 seconds
refreshBoard();
setInterval(refreshBoard, 10000); 
</script>
</body>
</html>