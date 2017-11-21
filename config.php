<?php

    require_once(__DIR__.'/includes/database.php');
    // DB CONFIG
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'app');


    // SITE CONFIG
    define('SITE_NAME', 'Strona testowa');
    define('URL', 'http://localhost');
    define('DEFAULT_STYLE', 'style.css');


    // SET CONNECTION
    $DB = new Database();
    $DB->setConection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $DB = $DB->returnConnection();
?>