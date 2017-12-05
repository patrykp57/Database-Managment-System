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
        <div id="info">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" id="add-table-form">
            <label>Dodaj kolejny typ</label><button class="add-input">+</button>
                <input type="submit" id="add-table-submit">
                <BR/>
                <BR/>
                <BR/>
                <label>
                    Podaj nazwę tabeli do utworzenia: 
                </label>
                <input type="text" name="tableName" />
                <BR/>
                <BR/>
                <BR/>
                <h3>Typy</h3>
                <div class="type">
                    <label>Nazwa</label><input type="text" name="recordName[0]" />
                    <select name="recordType[0]">
                        <option value="char(255)">CHAR</option>
                        <option value="varchar(255)">VARCHAR</option>
                        <option value="int(255)">INT</option>
                        <option value="double">DOUBLE</option>
                    </select>
                    <br/>
                </div>

                 
            </form>   
        </div>
    </div>
</div>
<?php include(realpath(dirname(__FILE__).'/views/user/_footer.php'));?>