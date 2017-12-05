<?php

   if ("POST" == $_SERVER["REQUEST_METHOD"]):
        if (isset($_SERVER["HTTP_ORIGIN"])):
            require_once(realpath(dirname(__FILE__).'/../config.php'));  
            require_once(realpath(dirname(__FILE__).'/../includes/user_database.php')); 
            if (strpos(URL, $_SERVER["HTTP_ORIGIN"]) === 0): 
                session_start();
                $OBJ = new UserDatabase($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_password'], $_SESSION['db_name']);
                
                $USER_DB = $OBJ->deleteTable($_POST['id']);
                echo $USER_DB;
?>




<?php       endif;
        endif;
    endif;
        
?>