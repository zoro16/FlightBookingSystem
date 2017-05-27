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

if(isset($_POST['inputFlightTime'])){
    $price = strip_tags($_POST['inputPrice']);
    $current = strip_tags($_POST['inputFrom']);
    $destination =strip_tags($_POST['inputTo']);
    $airline = strip_tags($_POST['inputAirline']);
    $class = strip_tags($_POST['inputClass']); //
    $flightNo = strip_tags($_POST['inputFlightNo']);
    $flightTime = strip_tags($_POST['inputFlightTime']);

    $dateOfFlight = strip_tags($_POST['dateOfFlight']);
    $dateOfFlight = mb_substr($dateOfFlight, 0, 10);
    $dateOfFlight = date_create($dateOfFlight);
    $dayID = date_format($dateOfFlight,"N");


    $sql = "INSERT INTO `flights` (airline, flightNo, current, destination, class, dayID,  price, flightTime ) VALUES   (:airline, :flightNo, :current, :destination, :class, :dayID,  :price, :flightTime )";

    $stmt = $getData->runQuery($sql);
    $stmt->execute(array(":airline"=>$airline,":flightNo"=>$flightNo,":current"=>$current,":destination"=>$destination,":class"=>$class,":price"=>$price,":dayID"=>$dayID,":flightTime"=>$flightTime));
    
    echo "<script type='text/javascript'>
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
                 dateFormat: 'yy-mm-dd,D',
                 inline: true,
                 onSelect: function(dateText, inst) { 
                     var date = $(this).datepicker('getDate'),
                         dayNumber = date.getUTCDay() + 1;
                 }
             });
             
             $('.form-horizontal addFlight').on('submit', function (e) {

                 e.preventDefault();

                 $.ajax({
                     type: 'post',
                     // url: 'booking.php',
                     data: $('.form-horizontal addFlight').serialize(),
                     success: function () {
                         // alert('form was submitted');
                         console.log(data);
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
                    <a href="booking.php" > Back </a>
                </li>
                <li >
                    <a href="flightsTable.php" > Show Flights table  </a>
                </li>
            </ul>

        </div>

        <div class="clearfix"></div>
        
        
        <!-- <div class="container-fluid" style="margin-top:80px;"> -->
        
        <div class="container" style="margin-top:0px;">
            <form class="form-horizontal addFlight" method="POST" >
                <h2>Add Flight </h2>
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
                    <label class="col-md-4 control-label" for="inputAirline">Airline</label>  
                    <div class="col-md-4">
                        <input id="inputAirline"  name="inputAirline" placeholder="Qatar Airline" class="form-control input-md" required="" type="text" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputClass">Flight Class</label>  
                    <div class="col-md-4">
                        <input id="inputClass"  name="inputClass" placeholder="Business" class="form-control input-md" required="" type="text" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputFlightNo">Flight Number</label>  
                    <div class="col-md-4">
                        <input id="inputFlightNo"  name="inputFlightNo" placeholder="QA01221" class="form-control input-md" required="" type="text" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputFrom">From</label>  
                    <div class="col-md-4">
                        <input id="inputFrom" name="inputFrom" placeholder="" class="form-control input-md" required="" type="text" 
                               value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputTo">To</label>  
                    <div class="col-md-4">
                        <input id="inputTo" name="inputTo" placeholder="" class="form-control input-md" required="" type="text" 
                               value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputPrice">Price</label>  
                    <div class="col-md-4">
                        <input id="inputPrice" name="inputPrice" placeholder="" class="form-control input-md" required="" type="text" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="inputFlightTime">Flight Time</label>  
                    <div class="col-md-4">
                        <input id="inputFlightTime" name="inputFlightTime" placeholder="11:00pm" class="form-control input-md" required="" type="text" value="">
                    </div>
                </div>
                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="singlebutton"></label>
                    <div class="col-md-4">
                        <button id="addTicket" name="addTicket" class="btn btn-primary" type="submit" >Add Ticket</button>
                    </div>
                </div>
            </form>
        </div> <!-- /container -->

    </body>
</html>
