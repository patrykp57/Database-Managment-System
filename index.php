<?php
    require_once(realpath(dirname(__FILE__).'/config.php'));    
    require_once(realpath(dirname(__FILE__).'/includes/lib/functions.php'));
    session_start();

    if(isset($_SESSION['dbconnect']))
        if($_SESSION['dbconnect']) 
            header("Location: ".URL."/dashboard.php");
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>PATRYK PANEK</title>

        <link rel="stylesheet" href="assets/css/style.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>
    <body class="home-main">
        <div class="container">
            <div class="row">
                <div class="col-12 home_title text-center">
                    <h1>System do zarządzania bazą danych</h1>
                </div>
            </div>
            <div class="forms_container">
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <div class="login_form">
                            <?php include('./views/main/login.php') ?>
                        </div>
                    </div>
                    <div class="col-3"></div>
                </div>
            </div>
    </body>
</html>