<?php 
        if ("POST" == $_SERVER["REQUEST_METHOD"]):
                if (isset($_SERVER["HTTP_ORIGIN"])):
                   require_once(realpath(dirname(__FILE__).'/../config.php'));  
                   require_once(realpath(dirname(__FILE__).'/../includes/user_database.php')); 
                   if (strpos(URL, $_SERVER["HTTP_ORIGIN"]) === 0): 
                                session_start();
                                $OBJ = new UserDatabase($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_password'], $_SESSION['db_name']);
                                $USER_DB = $OBJ->returnConnection();
                                $columns = $OBJ->returnColumns($_POST['id']);
                                $result = $OBJ->returnRecordsFromRange($_POST['id'], $_POST['start']);                               
?>


<div class="table-show">
        <table class="table-records">
                <thead>
                        <tr>
                                <?php foreach($columns as $key => $value): ?>
                                <td>
                                        <?php echo $value ?>
                                </td>
                                <?php endforeach ?>
                        </tr>
                </thead>
        
                        <tr data-value='<?php echo json_encode($columns)?>'>
                             <?php $inputNumber = sizeof($result[0]) ?>
                             <?php if($inputNumber > 0): ?>
                                <div id="addRecord">
                                <?php for($i = 0; $i < $inputNumber; $i++):?>
                                        <td> <input name="<?php echo $i ?>" class="addRecordInputs" /></td>
                                <?php endfor ?>
                                        <td><button id="addRecordButton">+</button></td>
                                </div>
                             <?php endif?>
                        </tr>
                        <?php  foreach($result as $key => $value):?>
                        <tr data-id="<?php echo $key ?>" data-value='<?php echo json_encode($result[$key])?>'>
                                <?php foreach($value as $key2 => $value2): ?>
                                <td data-id="<?php echo $key2 ?>">
                                        <input value="<?php echo strip_tags($value2) ?>" name="<?php echo strip_tags($value2) ?>" style="width: 100%" class="input" />
                                </td>
                                <?php endforeach?>
                                <td class="delete-cell">
                                       <button class="delete-button">X</button>
                                </td>
                        </tr>
                        <?php endforeach ?>
                </tbody>
        </table>
  </div>
<?php      
                        endif;
                endif;
        endif;     
?>