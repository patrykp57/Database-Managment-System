<?php
    require_once('config.php');

    if(!empty($_SESSION['access']) && !empty($_SESSION['username'])):
        if(checkPermission($_SESSION['access']) == 'user')
            header('Location: /user/index.php');
        elseif(checkPermission($_SESSION['access']) == 'admin')
            header('Location: /admin/index.php');
    endif
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>PATRYK PANEK</title>

        <link rel="stylesheet" type="text/css" href="./assets/css/<?php echo getDefaultStyle(); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>
    <body class="home-main">
        <div class="container">
            <div class="row">
                <div class="col-12 home_title text-center">
                    <h1>System do zarządzania bazą danych</h1>
                </div>
            </div>
            <div class="forms_container">
                <div class="row">
                    <div class="col-6">
                        <div class="login_form">
                            <?php include('./views/login.php') ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="register_form">
                            <?php include('./views/register.php') ?>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>