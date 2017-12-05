<h2>
    <?php echo getLang(getLangCookie(), 'login') ?>
</h2>
<form method="POST" action="login.php">
    <div class="row">
        <div class="col-6 text-right">
           <p> <?php echo getLang(getLangCookie(), 'username') ?>
        </div>
        <div class="col-6">
            <input type="text" name="login">
        </div>
    </div>
    <div class="row">
        <div class="col-6 text-right">
        <p>  <?php echo getLang(getLangCookie(), 'password') ?>
        </div>
        <div class="col-6">
            <input type="password" name="password">
        </div>
    </div>
    <?php if(loginError()): ?>
    <div class="row">
        <div class="col-12 text-center warning-container">
            <p class="warning">
                Błąd logowania ! Spróbuj ponownie.
            </p>
        </div>
    </div>
    <?php endif ?>
    <div class="row">
        <div class="col-12 text-center">
            <input type="submit">
        </div>
    </div>

    
</form>