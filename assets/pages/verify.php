<?php
global $user;
?>

<div class="body">
    <form class="verify-em" method="post" action="assets/php/action.php?verify_email">
        <h3>Verify email</h3>
        <span>Enter the 6 digit code sended to <small>(<?= $user['email'] ?>)</small></span>
        <input type="text" name="code" placeholder="######">
        <?php
        if (isset($_GET['sended'])) {
        ?>
            <h5 style="color:green;">We resended your code!</h5>
        <?php
        }

        ?>
        <?= showError() ?>
        <button type="submit">Verify email</button>
        <small><a href="assets/php/action.php?resend_code">Resend code</a><a href="assets/php/action.php?logout">Logout</a></small>
    </form>
</div>