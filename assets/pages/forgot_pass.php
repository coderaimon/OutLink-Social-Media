<?php

if (isset($_SESSION['fp_code']) and !isset($_SESSION['temp_auth'])) {
    $action = 'verifycode';
} elseif (isset($_SESSION['fp_code']) and isset($_SESSION['temp_auth'])) {
    $action = 'cngpass';
} else {
    $action = 'forgot_pass';
}

?>

<body class="body">
    <form class="fp-wrap" method="post" action="assets/php/action.php?<?= $action ?>">

        <?php
        if ($action == 'forgot_pass') {
        ?>
            <div class="fp-email">
                <h2>Reset your password!</h2>
                <input type="email" name="email" placeholder="Enter you email">
                <?= showError() ?>
                <button type="submit">Send code</button>
            </div>
        <?php
        } elseif ($action == 'verifycode') {
        ?>
            <div class="fp-code">
                <h2>Verfy it's you</h2>
                <p>We have sended a email to (<?= $_SESSION['fp_email'] ?>) enter the 5digit code from here.</p>
                <input type="text" name="code" placeholder="#####">
                <?= showError() ?>
                <button>Submit</button>
            </div>
        <?php

        } elseif ($action == 'cngpass') {
        ?>
            <div class="fp-new-pass">
                <h3>Set new password!</h3>
                <input type="text" name="new_pass" placeholder="New password">
                <?= showError() ?>
                <button type="submit">Change password</button>
            </div>
        <?php

        }



        ?>


        <a href="?login"><i class="fas fa-arrow-circle-left"></i> Back to login</a>
    </form>