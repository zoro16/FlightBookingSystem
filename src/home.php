<?php

require_once("session.php");

require_once("userLogin.php");
$auth_user = new USER();

$user_id = $_SESSION['user_session'];
$user_type = $_SESSION['userType_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id AND user_type=:user_type");
$stmt->execute(array(":user_id"=>$user_id,':user_type'=>$user_type));

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
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
                </div><!--/.nav-collapse -->
            </div>
        </nav>


        <div class="clearfix"></div>

        <div class="container-fluid" style="margin-top:80px;">
            <?php
            if($userRow['user_type'] == "administrator") {
                echo '<div class="container">
                          <div class="menu-options">
                              <h2>Main Page</h2>
                              <hr > <!-- line break -->
                              <a href="addFlights.php"> <button class="btn btn-lg btn-primary btn-block" type="button">Add Flights</button> </a>
                              <a href="booking.php"> <button class="btn btn-lg btn-primary btn-block" type="button">Book Flight Tickets</button> </a>
                              <a href="adminCommissionReport.php"> <button class="btn btn-lg btn-primary btn-block" type="button">Commissions Report</button> </a>
                          </div>
                      </div> <!-- /container -->';

            } else {
                echo '<div class="container">
                          <div class="menu-options">
                              <h2>Main Page</h2>
                              <hr > <!-- line break -->
                              <a href="addFlights.php"> <button class="btn btn-lg btn-primary btn-block" type="button">Add Flights</button> </a>
                              <a href="booking.php"> <button class="btn btn-lg btn-primary btn-block" type="button">Book Flight Tickets</button> </a>
                              <a href="empCommissionReport.php"> <button class="btn btn-lg btn-primary btn-block" type="button">Calculate Commissions</button> </a>
                          </div>

                      </div> <!-- /container -->';
            }

            ?>

        </div>


    </body>
</html>
