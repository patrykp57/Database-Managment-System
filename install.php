<?php 

    require_once('config.php');
   


    function createUserTable($DB) {
            $query = "CREATE TABLE IF NOT EXISTS app_users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                login VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL
                )";

        if ($DB->query($query) === TRUE) {
            echo "Utworzono tabele z userami pomyślnie!";
            echo "<br/>";
        } else {
            echo "Błąd tworzenia tabeli: " . $DB->error;
            echo "<br/>";
        }
    }

    function createConfigTable($DB) {
        $query = "CREATE TABLE IF NOT EXISTS app_config (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            site_name VARCHAR(255) NOT NULL,
            default_style VARCHAR(255) NOT NULL
            )";

        if ($DB->query($query) === TRUE) {
            echo "Utworzono tabele z konfiguracja pomyślnie!";
            echo "<br/>";
        } else {
            echo "Błąd tworzenia tabeli: " . $DB->error;
            echo "<br/>";
        }
    }

    function insertFirstConfig($DB) {
        $query = "INSERT INTO app_config (id, site_name, default_style)
        VALUES (1, 'Aplikacja do zarzadzania baza danych - Patryk Panek' , 'style.css')";



        if ($DB->query($query) === TRUE) {
            echo "Utworzono użytkownika pomyślnie";
            echo "<br/>";
        } else {
            echo "Błąd tworzenia użytkownika: " . $DB->error;
            echo "<br/>";
        }         
    }

    function insertFirstUser($DB) {
            $options = [
                'cost' => 11,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $pwd = password_hash('password', PASSWORD_BCRYPT, $options);

            $query = "INSERT INTO app_users (id, login, password)
            VALUES (1, 'admin', '".$pwd."' )";

        if ($DB->query($query) === TRUE) {
            echo "Utworzono użytkownika pomyślnie";
            echo "<br/>";
        } else {
            echo "Błąd tworzenia użytkownika: " . $DB->error;
            echo "<br/>";
        }         
    }

    createUserTable($DB);
    createConfigTable($DB);
    insertFirstConfig($DB);
    insertFirstUser($DB);

?>