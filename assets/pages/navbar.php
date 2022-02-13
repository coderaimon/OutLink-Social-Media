<?php global $user; ?>

<nav class="navbar bg-light sticky-top">
    <div class="nav-wrap container">
        <!-- web logo -->
        <a href="?" class="d-flex align-items-center"><img src="assets/img/logo.png" class="logo"></a>
        <!-- search button -->
        <form class="search">
            <input type="search" name="search" placeholder="Find someone..">
            <button type="submit" class="border-none"><i class="fas fa-search"></i></button>
        </form>
        <div class="options">
            <a href="?"><i class="fas fa-home"></i></a>
            <a href="?fr_sug"><i class="fas fa-user-friends"></i></a>
            <a href="?chats">
                <i class="fas fa-comments"></i>
                <?php
                $msg_count = unreadmsg();
                if ($msg_count > 100) {
                    $msg_count = '99+';
                }
                if ($msg_count > 0) {
                ?>
                    <span class="nt-badge"><?= $msg_count ?></span>
                <?php
                }
                ?>
            </a>
            <a data-bs-toggle="modal" data-bs-target="#addpost"><i class="fas fa-plus-square"></i></a>
            <a data-bs-toggle="offcanvas" data-bs-target="#notify" aria-controls="offcanvasRight">
                <i class="fas fa-bell"></i>
                <?php
                $nt_count = getnotifcount($_SESSION['user_id']['id']);
                if ($nt_count > 100) {
                    $nt_count = '99+';
                }
                if ($nt_count > 0) {
                ?>
                    <span class="nt-badge"><?= $nt_count ?></span>
                <?php
                }
                ?>
            </a>
            <div class="dropdown">
                <div class="nav-pp" id="ppmenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="assets/img/pp/<?= $user['profile_pic'] ?>">
                </div>
                <ul class="pp-opt dropdown-menu" aria-labelledby="ppmenu">
                    <a href="?user=<?= $user['username'] ?>">
                        <li><i class="fas fa-user"></i> Profile</li>
                    </a>
                    <a href="?editprofile">
                        <li><i class="fas fa-user-edit"></i> Edit Profile</li>
                    </a>
                    <a href="">
                        <li><i class="fas fa-cog"></i> Setting</li>
                    </a>
                    <a href="?logout">
                        <li><i class="fas fa-sign-out-alt"></i> Logout</li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
</nav>