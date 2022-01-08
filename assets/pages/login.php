<body class="body">
    <form class="login" method="post" action="assets/php/action.php?login">
        <h3>Log in</h3>
        <div class="log-inp">
            <span><i class="fas fa-user"></i></span>
            <input type="text" value="<?= showformdata('loguser') ?>" name="loguser" placeholder="Username/Email" />
        </div>
        <div class="log-inp">
            <span><i class="fas fa-lock"></i></span>
            <input type="password" name="password" placeholder="Password" />
        </div>
        <!-- error show  -->
        <?= showError() ?>

        <button type="submit">log in</button>
        <small>Don't have an account? <a href="?signup">Sign up</a></small>
        <small>Forgot password? <a href="?forgot_pass&np">reset</a></small>
    </form>
    <span class="cradit">Developer <a href="">Aimon Islam</a></span>