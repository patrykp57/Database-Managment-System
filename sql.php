<?php 
    require_once(realpath(dirname(__FILE__).'/config.php'));  
    
    session_start();

    if($_SESSION['dbconnect']) {

        require_once(realpath(dirname(__FILE__).'/includes/user_database.php')); 

        $OBJ = new UserDatabase($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_password'], $_SESSION['db_name']);
        $USER_DB = $OBJ->returnConnection();
        $TABLES_LIST = $OBJ->returnTables();
    }  else {
        header('Location: '.URL);
    }

?>


<?php include(realpath(dirname(__FILE__).'/views/user/_header.php'));?>

<div class="container">
    <div class="row">
        <div class="col-2">
            <?php foreach($TABLES_LIST as $key=>$value): ?>
            <div class="table-item" data-id="<?php echo $value ?>">
                <p>
                    <?php echo $value?>
                </p>
            </div>
            <?php endforeach?>
        </div>
        <div class="col-10">
            <div class="table-content" id="table-content">
                Kliknij na wybrany rekord, żeby zobaczyć zawartość.
            </div>
        </div>
    </div>
</div>
<?php include(realpath(dirname(__FILE__).'/views/user/_footer.php'));?>