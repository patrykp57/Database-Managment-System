<?php
        require_once(realpath(dirname(__FILE__).'/../config.php'));  
        require_once(realpath(dirname(__FILE__).'/../includes/user_database.php')); 
       
        session_start();
       
        $OBJ = new UserDatabase($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_password'], $_SESSION['db_name']);
        $USER_DB = $OBJ->returnConnection();

        $result = $OBJ->returnRecords($_GET['id']);
        $columns = $OBJ->returnColumns($_GET['id']);
        



?>


<div class="table-show">
        <table border="1">
        <tr>
            <?php foreach($columns as $key => $value): ?>
                <td><?php echo $key.'. '.$value ?></td>
            <?php endforeach ?>
        </tr>


        <?php  foreach($result as $key => $value):?>     
        
        <tr>
              <?php foreach($value as $key2 => $value2): ?>
               
                        <td data-id="<?php echo $key2 ?>"><input value="<?php echo $value2 ?>" name="<?php echo $value2 ?>" style="width: 100%"  class="input"/></td>
                
                <?php endforeach?>
                </tr>
        <?php endforeach ?>
        
        </table>

</div>




