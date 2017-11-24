<?php
    require_once(realpath(dirname(__FILE__).'/config.php'));  

    require_once(__DIR__.'/includes/database.php');


    if(!empty($_POST['db_host']) && !empty($_POST['db_user']) && !empty($_POST['db_name'])):
        $dbUser = new Database();
        $dbUser->setConection($_POST['db_host'], $_POST['db_user'], $_POST['db_password'], $_POST['db_name']);
        $dbUser = $dbUser->returnConnection();
            if(!empty($dbUser)):
                 session_start();
                 unset($_SESSION['error']);
                 $_SESSION['dbconnect'] = true;
                 $_SESSION['db_host'] = $_POST['db_host'];
                 $_SESSION['db_user'] = $_POST['db_user'];
                 $_SESSION['db_password'] = $_POST['db_password'];
                 $_SESSION['db_name'] = $_POST['db_name'];
                 header("Location: ".URL."/dashboard.php");
            else:
                session_start();
                unset($_SESSION['dbconnect']);
                $_SESSION['error'] = true;
                header("Location: ".URL);
            endif;
    else:
        header("Location: ".URL);
    endif;



?>