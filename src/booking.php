<?php

require_once("session.php");

require_once("userLogin.php");
$auth_user = new USER();
$getData = new USER();

$user_id = $_SESSION['user_session'];
$user_type = $_SESSION['userType_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id AND user_type=:user_type");
$stmt->execute(array(":user_id"=>$user_id,':user_type'=>$user_type));

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

$date ="";
$from ="";
$to ="";
$dayID ="";

if(isset($_POST['flightID']) && isset($_POST['inputFullName'])){
    $flightID = strip_tags($_POST['flightID']);
    $stmt = $getData->runQuery("SELECT * FROM flights WHERE flightID=:flightID ");
    $stmt->execute(array(":flightID"=>$flightID));
    $data = $stmt->fetch( PDO::FETCH_ASSOC);

    $price = $data['price'];
    $current = $data['current'];
    $destination = $data['destination'];
    $airline = $data['airline'];
    $class = $data['class'];
    $flightNo = $data['flightNo'];

    $cusFullName = strip_tags($_POST['inputFullName']);
    $cusCitizenship = strip_tags($_POST['inputCitizenship']);
    $cusPassportNo = strip_tags($_POST['inputPassportNo']);
    $cusPhoneNo = strip_tags($_POST['inputPhoneNo']);
    $dateOfFlight = strip_tags($_POST['dateOfFlight2']);
    $dateOfFlight = mb_substr($dateOfFlight, 0, 10);

    $user_id = $userRow['user_id'];

    $msg = "FullName = ".$cusFullName.",Citizenship = ".$cusCitizenship.",Passport No = ".$cusPassportNo.",Phone No = ".$cusPhoneNo.",Date of Flight = ".$dateOfFlight.",destination = ".$destination.",Current = ".$current.",Airline = ".$airline.",Class = ".$class.",Flight No = ".$flightNo.",Price = ".$price ;
    
    $sql = "INSERT INTO `booking` (flightID, cusFullName, cusPassportNo, cusCitizenship, cusPhoneNo, user_id,  price, dateOfFlight ) VALUES   (:flightID, :cusFullName, :cusPassportNo, :cusCitizenship, :cusPhoneNo, :user_id, :price, :dateOfFlight )";

    $stmt = $getData->runQuery($sql);
    $stmt->execute(array(":flightID"=>$flightID,
                         ":cusFullName"=>$cusFullName,
                         ":cusPassportNo"=>$cusPassportNo,
                         ":cusCitizenship"=>$cusCitizenship,
                         ":cusPhoneNo"=>$cusPhoneNo,
                         ":price"=>$price,
                         ":user_id"=>$user_id,
                         ":price"=>$price,
                         ":dateOfFlight"=>$dateOfFlight));
    
    echo "<script type='text/javascript'>
                  alert('$msg');
                  alert('DONE');
              </script>";

}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="style.css" type="text/css"  />

        <script src="../lib/js/jquery.min.js" ></script>
        <script src="../lib/js/bootstrap.js" ></script>
        <script src="../lib/jquery-ui-1.11.4/jquery-ui.js"></script>

        <link rel="stylesheet" href="../lib/css/bootstrap.css" >
        <link rel="stylesheet" href="../lib/css/bootstrap-theme.css" >
        <link rel="stylesheet" href="../lib/jquery-ui-1.11.4/jquery-ui.css">
        <link rel="stylesheet" href="../lib/jquery-ui-1.11.4/jquery-ui.structure.css">
        <link rel="stylesheet" href="../lib/jquery-ui-1.11.4/jquery-ui.theme.css">

        <link rel="stylesheet" href="../css/style.css" >
        <title>welcome - <?php print($userRow['user_name']); ?></title>
    </head>

    <body>
        <script type="text/javascript">
         $(function () {
             var date;
             var dayNumber;
             $('#dateOfFlight').datepicker({
                 dateFormat: 'yy-mm-dd',
                 inline: true,
                 onSelect: function(dateText, inst) { 
                     var date = $(this).datepicker('getDate'),
                         dayNumber = date.getUTCDay() + 1;
                 }
             });
             
             $('.form-horizontal checkingForm').on('submit', function (e) {

                 e.preventDefault();

                 $.ajax({
                     type: 'post',
                     // url: 'booking.php',
                     data: $('.form-horizontal checkingForm').serialize(),
                     success: function () {
                         // alert('form was submitted');
                         console.log(data);
                     }
                 });
             });
             $('.form-horizontal bookingData').on('submit', function (e) {

                 e.preventDefault();

                 $.ajax({
                     type: 'post',
                     // url: 'booking.php',
                     data: $('.form-horizontal bookingData').serialize(),
                     success: function () {
                         // alert('form was submitted');
                         console.log(data);

                     }
                 });
             });
             

             $('select').change(function(e){
                 e.preventDefault();
                 // console.log($(this).find(':selected').data('id'));
                 var selectedID = $(this).find(':selected').data('id');
                 $.ajax({
                     type: 'post',
                     // url: 'booking.php',
                     data: {'flightID': selectedID},
                     success: function () {
                         // alert('form was submitted');
                         console.log(selectedID);
                         $( "#flightID" ).val( selectedID);

                     }
                 });

             });


         });
        </script>
        <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-user"></span>&nbsp;Hi <?php echo $userRow['user_name'];?>&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-left">
                <li >
                    <a href="home.php" > Back </a>
                </li>
                <li >
                    <a href="bookedFlightsTable.php" > Show Booked Flights table </a>
                </li>
            </ul>


        </div>

        <div class="clearfix"></div>
    	
        
        <!-- <div class="container-fluid" style="margin-top:80px;"> -->
	
        <div class="container" style="margin-top:0px;">


            <form class="form-horizontal checkingForm" method="POST" id="checkingForm" name="checkingForm"> 
                <!-- Form Name -->
                <h2>Booking Flight Tickets</h2>
                <hr>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="dateOfFlight">Date</label>  
                    <div class="input-group">
                        <div class="col-md-4">
                            <input id="dateOfFlight" name="dateOfFlight" placeholder="Date" class="form-control input-md"   type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4">
                        <input id="inputFlightNo" name="inputFlightNo"  class="form-control input-md"  type="hidden">
                    </div>
                </div>
                
                <div class="form-group" >
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4">
                        <button id="checkAvailableButton" name="checkAvailableButton" class="btn btn-primary" type="submit">Check If Available</button>
                    </div>  
                </div>  
            </form>
            <hr>
            <!-- ==================================================================================================== -->

            <form class="form-horizontal bookingData" method="POST" >
                <div class="form-group">
                    <label class="col-md-4 control-label" for="availableFlights">Available Flights</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <select class="form-control" id="availableFlights">
                                    <?php 

                                    if(isset($_POST['dateOfFlight']) ) {

                                        $date = strip_tags($_POST['dateOfFlight']);
                                        $from = strip_tags($_POST['flightFrom']);
                                        $to = strip_tags($_POST['flightTo']);
                                        $dayID = date('N', strtotime( $date));

                                        $stmt = $getData->runQuery("SELECT * FROM flights WHERE dayID=:dayID ");
                                        $stmt->execute(array(":dayID"=>$dayID));
                                        // $results = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $data = $stmt->fetch( PDO::FETCH_ASSOC);
                                        print '<option></option>';
                                        if ($stmt->rowCount() > 0) {
                                            while($data = $stmt->fetch( PDO::FETCH_ASSOC )){ 
                                                print '<option data-id="'.$data['flightID'].'">'. $data['airline'].'-'.$data['flightNo'].'-'.$data['from'].'-'.$data['to'].'-'.$data['class'].'-'.$data['flightTime'].'-'.$data['price'].'MRY </option>'; 

                                            }
                                        } else {
                                            echo "<script type='text/javascript'>alert('SORRY, THERE IS NO FLIGHTS ON THIS DAY');</script>";
                                        }
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="dateOfFlight2">Date</label>  
                    <div class="input-group">
                        <div class="col-md-4">
                            <input id="dateOfFlight2" name="dateOfFlight2" placeholder="Date" class="form-control input-md"   type="text" 
                                   value="<?php 
                                          if(isset($_POST['dateOfFlight'])) { 
                                              $date = strip_tags($_POST['dateOfFlight']); 
                                              $dayID = date('l', strtotime( $date));
                                              echo $date.",".$dayID;
                                          } 
                                          ?>" >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <!-- <label class="col-md-4 control-label" for="flightID">Flight ID</label>   -->
                    <div class="col-md-4">
                        <input id="flightID" type="hidden" name="flightID" placeholder="" class="form-control input-md" required="" type="text" 
                               value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputPrice">Price</label>  
                    <div class="col-md-4">
                        <input id="inputPrice" name="inputPrice" placeholder="" class="form-control input-md" required="" type="text" 
                               value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputFullName">Full Name</label>  
                    <div class="col-md-4">
                        <input id="inputFullName" name="inputFullName" placeholder="Someone " class="form-control input-md" required="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputCitizenship">Citizenship</label>  
                    <div class="col-md-4">
                        <input id="inputCitizenship" name="inputCitizenship" placeholder=" some country" class="form-control input-md" required="" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputPassportNo">Passport Number</label>  
                    <div class="col-md-4">
                        <input id="inputPassportNo" name="inputPassportNo" placeholder="e.g. 0007797" class="form-control input-md" required="" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputPhoneNo">Phone Number</label>  
                    <div class="col-md-4">
                        <input id="inputPhoneNo" name="inputPhoneNo" placeholder="+60 dd-ddd dddd" class="form-control input-md bfh-phone "data-format="+60 dd-ddd dddd" required="" type="text">

                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="twobutton"></label>
                    <div class="col-md-4">
                        <button id="bookTicket" name="bookTicket" class="btn btn-primary" type="submit" >Book Ticket</button>

                    </div>
                </div>
            </form>

        </div> <!-- /container -->

    </body>
</html>
