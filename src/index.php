<?php
session_start();
require_once("userLogin.php");
$login = new USER();

if($login->is_loggedin()!="") {
    $login->redirect('home.php');
}

if(isset($_POST['btn-login'])) {
    $uname = strip_tags($_POST['inputUsername']);
    $utype = strip_tags($_POST['usersType']);
    $upass = strip_tags($_POST['inputPassword']);

    if($login->doLogin($uname,$utype,$upass)) {
        $login->redirect('home.php'); //admin main page
    } else {
        $error = "Wrong Details !";
    }   


}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="../lib/js/jquery.min.js" ></script>
        <link rel="stylesheet" href="../lib/css/bootstrap.css" >
        <link rel="stylesheet" href="../lib/css/bootstrap-theme.css" >

        <link rel="stylesheet" href="../Style/style.css" >

        <title>Login Page</title>


    </head>

    <body>

        <div class="container">

            <form class="form-login" method="post" id="login-form">
                <h2 class="form-login-heading">Please sign in</h2>
                <hr > <!-- line break -->

                <select class="form-control" name="usersType"  id="usersType">
                    <option ></option>
                    <option >administrator</option>
                    <option >employee</option>
                </select>

                <label for="inputEmail" class="sr-only">Username</label>
                <input type="text" name="inputUsername" id="inputUsername" class="form-control" placeholder="" required >
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="" required>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-login">Login in</button>
            </form>

        </div> <!-- /container -->

    </body>
</html>
