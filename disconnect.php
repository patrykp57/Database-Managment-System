<?php
    require_once(realpath(dirname(__FILE__).'/config.php'));  

    session_start();
    session_unset();
    session_destroy();
    session_write_close();

    Header("Location: ".URL);
?>