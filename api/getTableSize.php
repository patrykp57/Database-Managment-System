<?php 
        if ("POST" == $_SERVER["REQUEST_METHOD"]):
                if (isset($_SERVER["HTTP_ORIGIN"])):
                   require_once(realpath(dirname(__FILE__).'/../config.php'));  
                   require_once(realpath(dirname(__FILE__).'/../includes/user_database.php')); 
                   if (strpos(URL, $_SERVER["HTTP_ORIGIN"]) === 0): 
                                session_start();
                                $OBJ = new UserDatabase($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_password'], $_SESSION['db_name']);
                                $USER_DB = $OBJ->returnConnection();
                                $size = $OBJ->returnSize($_POST['id']);
                                
                                $start = 1;
?>
    <div class="pagination">


        <?php for($i = 0; $i < $size; $i++): ?>
            <?php if($i % 30 == 0 && $size > 30): ?>     
            <a href="#page=<?php echo $start?>" data-id="<?php echo $_POST['id'] ?>" data-value="<?php echo $start ?>" class="pagination-item <?php if($start == 1): ?>page-active<?php endif?>"><?php echo $start?></a> 
                <?php $start++ ?>
            <?php endif?>                        
        <?php endfor; ?>


        <?php if($size <= 30): ?>
            <a href="#page=<?php echo $start?>" data-id="<?php echo $_POST['id'] ?>" data-value="<?php echo $start ?>" class="pagination-item page-active"><?php echo $start?></a> 
        <?php endif ?>  


    </div>
<?php      
                        endif;
                endif;
        endif;     
?>