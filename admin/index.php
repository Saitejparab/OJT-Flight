<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php';?>

<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300&family=Poiret+One&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
<style>
  body {
    background:url('../assets/images/plane3.jpg') no-repeat 0px 0px;
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
  }
  td { font-size: 18px !important; }
  p { font-size: 35px; font-weight: 100; font-family: 'product sans'; }  
  .main-section{ width:100%; margin:0 auto; text-align: center; padding: 0px 5px; }
  .dashbord{ width:23%; display: inline-block; background-color:#34495E; color:#fff; margin-top: 50px; }
  /* ... (Keeping your existing CSS styles) ... */
</style>

<main>
    <?php if(isset($_SESSION['adminId'])) { ?>
      <div class="container">
        <div class="main-section">
          <div class="dashbord">
            <div class="icon-section"><i class="fa fa-users"></i><br>Total Passengers<p><?php include 'psngrcnt.php';?></p></div>
          </div>
          <div class="dashbord dashbord-green">
            <div class="icon-section"><i class="fa fa-money"></i><br>Amount<p>Rs. <?php include 'amtcnt.php';?></p></div>
          </div>
          <div class="dashbord dashbord-red">
            <div class="icon-section"><i class="fa fa-plane"></i><br>Flights<p><?php include 'flightscnt.php';?></p></div>
          </div>
          <div class="dashbord dashbord-blue">
            <div class="icon-section"><i class="fa fa-plane fa-rotate-180"></i><br>Available Airlines<p><?php include 'airlcnt.php';?></p></div>
          </div>
        </div>

      <div class="card mt-4" id="flight">
        <div class="card-body">
          <div class="dropdown" style="float: right;">
            <button class="btn btn-dark dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#flight">Today's Flights</a>
              <a class="dropdown-item" href="#issue">Today's flight issues</a>
              <a class="dropdown-item" href="#dep">Flights departed today</a>
              <a class="dropdown-item" href="#arr">Flights arrived today</a>
            </div>
          </div>        
          <p class="text-secondary">Scheduled / On-Time Today</p>
          <table class="table-sm table table-hover">
            <thead class="thead-dark">
              <tr>
                <th>#</th><th>Arrival</th><th>Departure</th><th>Destination</th><th>Source</th><th>Airlines</th><th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $curr_date = date('Y-m-d');
                $sql = "SELECT * FROM Flight WHERE DATE(departure)=?";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,'s',$curr_date);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  // Only show flights with NO status or explicitly 'On-Time'
                  if($row['status']== '' || $row['status']=='On-Time' || $row['status']=='Boarding') {
                    echo '<tr>
                      <td><a href="pass_list.php?flight_id='.$row['flight_id'].'" style="text-decoration:underline;">'.$row['flight_id'].'</a></td>
                      <td>'.$row['arrivale'].'</td>
                      <td>'.$row['departure'].'</td>
                      <td>'.$row['Destination'].'</td>
                      <td>'.$row['source'].'</td>
                      <td>'.$row['airline'].'</td> 
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                          <div class="dropdown-menu">
                            <form class="px-4 py-3" action="../includes/admin/admin.inc.php" method="post">
                              <input type="hidden" name="flight_id" value='.$row['flight_id'].'>
                              <div class="form-group">
                                <label class="small">Enter time in min.</label>
                                <input type="number" class="form-control" name="issue" placeholder="Eg. 120">
                              </div>  
                              <button type="submit" name="issue_but" class="btn btn-danger btn-sm">Submit issue</button>
                              <div class="dropdown-divider"></div>
                              <button type="submit" name="dep_but" class="btn btn-primary btn-sm">Departed</button>
                            </form>
                          </div>
                        </div>
                      </td>
                    </tr>'; 
                  }
                } 
              ?>
            </tbody>
          </table>        
        </div>
      </div>

      <div class="card mt-4" id="issue">
        <div class="card-body">
          <p class="text-secondary">Today's Flight Issues / Delays</p>
          <table class="table-sm table table-hover">
            <thead class="thead-dark">
              <tr>
                <th>#</th><th>Arrival</th><th>Departure</th><th>Destination</th><th>Source</th><th>Airline</th><th>Status</th><th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  // SYNC: Check for 'issue' OR 'Delayed'
                  if($row['status']=='issue' || $row['status']=='Delayed') {
                    echo '<tr>
                      <td>'.$row['flight_id'].'</td>
                      <td>'.$row['arrivale'].'</td>
                      <td>'.$row['departure'].'</td>
                      <td>'.$row['Destination'].'</td>
                      <td>'.$row['source'].'</td>
                      <td>'.$row['airline'].'</td> 
                      <td><span class="badge badge-danger">'.$row['status'].'</span></td>
                      <td>
                        <form action="../includes/admin/admin.inc.php" method="post">
                          <input type="hidden" name="flight_id" value='.$row['flight_id'].'>  
                          <button type="submit" name="issue_soved_but" class="btn btn-success btn-sm">Solved</button>
                        </form>
                      </td>
                    </tr>'; 
                  }
                } 
              ?>
            </tbody>
          </table>
        </div>
      </div> 

      <div class="card mt-4" id="dep">
        <div class="card-body">
          <p class="text-secondary">Flights Departed Today</p>
          <table class="table-sm table table-hover">
            <thead class="thead-dark">
              <tr>
                <th>#</th><th>Arrival</th><th>Departure</th><th>Destination</th><th>Source</th><th>Airline</th><th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  // SYNC: Check for 'dep' OR 'Departed'
                  if($row['status']=='dep' || $row['status']=='Departed') {
                    echo '<tr>
                      <td>'.$row['flight_id'].'</td>
                      <td>'.$row['arrivale'].'</td>
                      <td>'.$row['departure'].'</td>
                      <td>'.$row['Destination'].'</td>
                      <td>'.$row['source'].'</td>
                      <td>'.$row['airline'].'</td> 
                      <td><span class="badge badge-primary">Departed</span></td>
                    </tr>'; 
                  }
                } 
              ?>
            </tbody>
          </table>
        </div>
      </div>       

      <div class="card mt-4 mb-4" id="arr">
        <div class="card-body">
          <p class="text-secondary">Flights Arrived Today</p>
          <table class="table-sm table table-hover">
            <thead class="thead-dark">
              <tr>
                <th>#</th><th>Arrival</th><th>Departure</th><th>Destination</th><th>Source</th><th>Airline</th><th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  // SYNC: Check for 'arr' OR 'Arrived'
                  if($row['status']=='arr' || $row['status']=='Arrived') {
                    echo '<tr>
                      <td>'.$row['flight_id'].'</td>
                      <td>'.$row['arrivale'].'</td>
                      <td>'.$row['departure'].'</td>
                      <td>'.$row['Destination'].'</td>
                      <td>'.$row['source'].'</td>
                      <td>'.$row['airline'].'</td> 
                      <td><span class="badge badge-success">Arrived</span></td>
                    </tr>'; 
                  }
                } 
              ?>
            </tbody>
          </table>
        </div>
      </div>      
    </div>
    <?php } ?>
</main>
<?php include_once 'footer.php'; ?>