<?php

require_once("session.php");

require_once("userLogin.php");
require_once("dbconfig.php");

$auth_user = new USER();
$getData = new USER();

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
                    <a href="addFlights.php" > Back </a>
                </li>
            </ul>


        </div>

        <div class="clearfix"></div>
    	
        
        <!-- <div class="container-fluid" style="margin-top:80px;"> -->
	
        <div class="container" style="margin-top:0px;">

            <h2>Show Available Flights Table</h2>
            <hr>
            <div class="table-responsive">          
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>flightNo</th>
                            <th>current</th>
                            <th>destination</th>
                            <th>airline</th>
                            <th>class</th>
                            <th>Day</th>
                            <th>Flight Time</th>
                            <th>price</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                        $database = new Database();
                        $db = $database->dbConnection();
                        $conn = $db;

                        $stmt = $conn->query("SELECT * FROM flights ");
                        $stmt->execute();
                        // $results = $stmt->fetch(PDO::FETCH_ASSOC);
                        $data = $stmt->fetch( PDO::FETCH_ASSOC);
                        // var_dump($data) and die();
                        if ($stmt->rowCount() > 0) {
                            while($data = $stmt->fetch( PDO::FETCH_ASSOC )){ 
                                print " <tr> 
                                            <td>". $data['flightID']."</td> 
                                            <td>". $data['flightNo']."</td> 
                                            <td>". $data['current']."</td>
                                            <td>". $data['destination']."</td>
                                            <td>". $data['airline']."</td>
                                            <td>". $data['class']."</td>
                                            <td>". date('l', $data['dayID']) ."</td>
                                            <td>". $data['flightTime']."</td>
                                            <td>". $data['price']."</td>
                                          </tr>";
                            }
                        } else {
                            // echo "<script type='text/javascript'>alert('SORRY, THERE IS NO FLIGHTS ON THIS DAY');</script>";
                        }


                        ?>

                    </tbody>
                </table>
            </div>


        </div> <!-- /container -->


    </body>
</html>
