<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); 
      require 'helpers/init_conn_db.php';                       
?>  
<style>
/* ... (Keep all your existing styles exactly as they are) ... */
footer { bottom: 0; width: 100%; height: 2.5rem; }
form.logout_form { background: transparent; padding: 10px !important; }
body {
    background:url('assets/images/plane1.jpg') no-repeat 0px 0px;
    background-size: cover;
    font-family: 'Open Sans', sans-serif;
    background-attachment: fixed;
    background-position: center;
}
.resp-tab-content { display: none; }
.resp-tab-content.resp-content-active { display: block !important; }
h1{
    font-family :'product sans' !important;
    color: #ffffff ;
    font-size:45px !important;
    margin-top:40px;
    text-align:center;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}
.main-agileinfo{ margin:50px auto; width:50%; }
.resp-tabs-list {
    list-style: none;
    padding: 15px 0px;
    margin: 0 auto;
    text-align: center;
    background: rgba(78, 103, 114, 0.9);
}
.resp-tab-item {
    font-size: 1.1em;
    font-weight: 500;
    cursor: pointer;
    display: inline-block;
    color:#b1b1b1;
    padding:7px 25px;
    text-transform: uppercase;
}
.resp-tab-active { color:#fff; border-bottom: 3px solid #4caf50; }
form { background:rgba(3, 3, 3, 0.75); padding: 25px; border-radius: 0 0 5px 5px; }
h3 { font-size: 16px; color:rgba(255, 255, 255, 0.9); margin-bottom: 7px; }
.from,.to,.date,.depart,.return,.class,.adults{
    width:48%;
    float:left;
    margin-bottom:20px;
}
.from,.date,.depart,.adults{ margin-right:4%; }
select, input[type="date"] { padding:10px; width:100%; border-radius: 4px; border: 1px solid #ccc; }
input[type="submit"] {
    font-size: 18px; color: #fff; background:#4caf50; border: none;
    width: 100%; padding: 12px; margin-top: 20px; cursor:pointer; border-radius: 4px;
}
.quantity-select {
    display: flex; align-items: center; background: #fff; width: fit-content;
    border-radius: 4px; overflow: hidden;
}
.value-minus, .value-plus {
    padding: 8px 15px; cursor: pointer; background: #e0e0e0; font-weight: bold; user-select: none;
}
.value { padding: 0 20px; font-weight: bold; color: #333; }
.clear { clear: both; }
@media (max-width:1080px){ .main-agileinfo { width: 80%; } }
</style>

<div class="main-agileinfo">
    <h1>FlyHigh Airline Management</h1>
    <div class="sap_tabs">          
        <div id="horizontalTab">
            <ul class="resp-tabs-list">
                <li class="resp-tab-item"><span>One-way Trip</span></li>
                <li class="resp-tab-item"><span>Round Trip</span></li>
            </ul>   
            <div class="resp-tabs-container">
                
                <div class="resp-tab-content">
                    <form action="book_flight.php" method="GET">
                        <input type="hidden" name="type" value="one">
                        <div class="from">
                            <h3>From</h3>
                            <select name="dep_city" required>
                                <option value="" selected disabled>Source City</option>
                                <?php
                                $sql = 'SELECT * FROM Cities';
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Use raw city name to match DB exactly
                                    echo '<option value="'.$row['city'].'">'.$row['city'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="to">
                            <h3>To</h3>
                            <select name="arr_city" required>
                                <option value="" selected disabled>Destination City</option>
                                <?php mysqli_data_seek($result, 0);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="'.$row['city'].'">'.$row['city'].'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                        <div class="date">
                            <h3>Departure Date</h3>
                            <input name="dep_date" type="date" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="class">
                            <h3>Class</h3>
                            <select name="f_class">
                                <option value="E">Economy</option>  
                                <option value="B">Business</option>   
                            </select>
                        </div>
                        <div class="clear"></div>
                        <div class="adults">
                            <h3>Passengers</h3>
                            <div class="quantity-select">                           
                                <div class="entry value-minus">-</div>
                                <div class="entry value"><span>1</span></div>
                                <input type="hidden" name="passengers" class="input_val" value="1">
                                <div class="entry value-plus">+</div>
                            </div>
                        </div>
                        <input type="submit" value="Search Flights" name="search_but">
                    </form>
                </div>

                <div class="resp-tab-content">
                    <form action="book_flight.php" method="GET">
                        <input type="hidden" name="type" value="round">
                        <div class="from">
                            <h3>From</h3>
                            <select name="dep_city" required>
                                <option value="" selected disabled>Source City</option>
                                <?php mysqli_data_seek($result, 0);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="'.$row['city'].'">'.$row['city'].'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="to">
                            <h3>To</h3>
                            <select name="arr_city" required>
                                <option value="" selected disabled>Destination City</option>
                                <?php mysqli_data_seek($result, 0);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="'.$row['city'].'">'.$row['city'].'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                        <div class="depart">
                            <h3>Depart Date</h3>
                            <input name="dep_date" type="date" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="return">
                            <h3>Return Date</h3>
                            <input name="ret_date" type="date" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="clear"></div>
                        <div class="class">
                            <h3>Class</h3>
                            <select name="f_class">
                                <option value="E">Economy</option>  
                                <option value="B">Business</option>   
                            </select>
                        </div>
                        <div class="adults">
                            <h3>Passengers</h3>
                            <div class="quantity-select">                           
                                <div class="entry value-minus">-</div>
                                <div class="entry value"><span>1</span></div>
                                <input type="hidden" name="passengers" class="input_val" value="1">
                                <div class="entry value-plus">+</div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <input type="submit" value="Search Flights" name="search_but">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer style="margin-top: 30px; padding-bottom: 20px;">
    <div class="text-light text-center">
        &copy; <?php echo date('Y')?> - Developed By Saitej Babu Parab (Roll No: 2202444)
    </div>
</footer>   

<?php subview('footer.php'); ?> 

<script src="assets/js/easyResponsiveTabs.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({ type: 'default', width: 'auto', fit: true });
    });     

    $('.value-plus').on('click', function(){
        var divUpd = $(this).parent().find('.value span'), newVal = parseInt(divUpd.text(), 10)+1;
        divUpd.text(newVal);
        $(this).parent().find('.input_val').val(newVal);
    });

    $('.value-minus').on('click', function(){
        var divUpd = $(this).parent().find('.value span'), newVal = parseInt(divUpd.text(), 10)-1;
        if(newVal>=1) {
            divUpd.text(newVal);
            $(this).parent().find('.input_val').val(newVal);
        } 
    });
</script>