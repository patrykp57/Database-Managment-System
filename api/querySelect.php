<?php

   if ("POST" == $_SERVER["REQUEST_METHOD"]):
        if (isset($_SERVER["HTTP_ORIGIN"])):
            require_once(realpath(dirname(__FILE__).'/../config.php'));  
            require_once(realpath(dirname(__FILE__).'/../includes/user_database.php')); 
            if (strpos(URL, $_SERVER["HTTP_ORIGIN"]) === 0): 
                session_start();
              
                $OBJ = new UserDatabase($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_password'], $_SESSION['db_name']);
                
                $USER_DB = $OBJ->querySelect($_POST['value']);

                         
?>

<?php if(is_array($USER_DB) && !empty($USER_DB)): ?>
<div class="table-show">
        <table class="table-records">

                <tbody>
                        <?php  foreach($USER_DB as $key => $value):?>
                        <tr data-id="<?php echo $key ?>">
                                <?php foreach($value as $key2 => $value2): ?>
                                <td data-id="<?php echo $key2 ?>">
                                        <input value="<?php echo strip_tags($value2) ?>" style="width: 100%" class="input"  disabled/>
                                </td>
                                <?php endforeach?>
                        </tr>
                        <?php endforeach ?>
                </tbody>
        </table>
  </div>



<?php else: print_r($USER_DB); ?>
    
<?php endif?>


<?php       endif;
        endif;
    endif;
        
?>