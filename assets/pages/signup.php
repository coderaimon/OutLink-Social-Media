<body class="body">
    <form class="signup" method="post" action="assets/php/action.php?signup">
        <h3>Sign up</h3>
        <input type="text" value="<?= showformdata('first_name') ?>" name="first_name" placeholder="First name">
        <input type="text" value="<?= showformdata('last_name') ?>" name="last_name" placeholder="Last name">
        <input type="email" value="<?= showformdata('email') ?>" name="email" placeholder="Email">
        <input type="number" value="<?= showformdata('phone') ?>" name="phone" placeholder="Phone">
        <input type="text" value="<?= showformdata('username') ?>" name="username" placeholder="username">
        <input type="password" name="password" placeholder="Password">
        <!-- field errors -->
        <?= showError() ?>
        <button type="submit">Signup</button>
        <small>Already have an account? <a href="?login">login</a></small>
    </form>