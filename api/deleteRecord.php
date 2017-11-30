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
                $JSON = json_decode($_POST['json'], true);
                $OBJ = new UserDatabase($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_password'], $_SESSION['db_name']);
                
                $USER_DB = $OBJ->deleteRecordFromArray($_POST['post_id'], $JSON);

              
                if($USER_DB):
                    echo "Rekord został usunięty!";
                elseif(!$USER_DB):
                    echo "Błąd aktualizacji rekordu";
                else:
                    echo  $USER_DB;
                endif;
            
?>




<?php       endif;
        endif;
    endif;
        
?>