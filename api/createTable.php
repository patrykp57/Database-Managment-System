<?php

   // echo $_POST['post_id'];
   // echo $_POST['insert_id'];
   // echo $_POST['value'];
   if ("POST" == $_SERVER["REQUEST_METHOD"]):
        if (isset($_SERVER["HTTP_ORIGIN"])):
            require_once(realpath(dirname(__FILE__).'/../config.php'));  
            require_once(realpath(dirname(__FILE__).'/../includes/user_database.php')); 
            if (strpos(URL, $_SERVER["HTTP_ORIGIN"]) === 0): 
                session_start();
                $OBJ = new UserDatabase($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_password'], $_SESSION['db_name']);
                $JSON = json_decode($_POST['value'], true);
                $OUTPUT = array();

                foreach($JSON as $key => $value) {
                    if(!empty($value['name']))
                        $OUTPUT[] = $value;

                }
                
                $DATA = $OBJ->createTable($OUTPUT);

                echo $DATA;
            
?>




<?php       endif;
        endif;
    endif;
        
?>