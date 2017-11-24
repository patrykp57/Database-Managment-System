<h2>
    <?php echo getLang(getLangCookie(), 'login') ?>
</h2>
<form method="POST" action="connect.php">


    <div class="row">
        <div class="col-6 text-right">
            <p>
                <?php echo getLang(getLangCookie(), 'host') ?>
        </div>
        <div class="col-6">
            <input type="text" name="db_host">
        </div>
    </div>


    <div class="row">
        <div class="col-6 text-right">
            <p>
                <?php echo getLang(getLangCookie(), 'username') ?>
        </div>
        <div class="col-6">
            <input type="text" name="db_user">
        </div>
    </div>


    <div class="row">
        <div class="col-6 text-right">
            <p>
                <?php echo getLang(getLangCookie(), 'password') ?>
        </div>
        <div class="col-6">
            <input type="password" name="db_password">
        </div>
    </div>


    <div class="row">
        <div class="col-6 text-right">
            <p>
                <?php echo getLang(getLangCookie(), 'dbname') ?>
        </div>
        <div class="col-6">
            <input type="text" name="db_name">
        </div>
    </div>


    <?php if(isset($_SESSION['error'])): ?>
    <div class="row">
        <div class="col-12 text-center">
            <p class="warning">
                Nie można połączyć się z bazą dnaych, spróbuj ponownie <br/><br/>
            </p>
        </div>
    </div>
    <?php endif?>

    <div class="row">
        <div class="col-12 text-center">
            <input type="submit">
        </div>
    </div>





</form>