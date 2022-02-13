<?php
require_once 'assets/php/function.php';

if (isset($_SESSION['Auth'])) {
    $user = getuser($_SESSION['user_id']['id']);
    $posts = followerpost();
    $fsug = filfollowers();
    $frsug = frfilfol();
    if (isset($_GET['search'])) {
        $searchr = searchfr($_GET['search']);
    }
}

$pc = count($_GET);

if (isset($_SESSION['Auth']) && $user['ac_status'] == 1 && !$pc) {
    getPage("header", ['page_title' => 'OutLink | Newsfeed']);
    getPage('navbar');
    getPage('newsfeed');
} elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 0 && !$pc) {
    getPage("header", ['page_title' => 'Verify your email']);
    getPage('verify');
} elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 2 && !$pc) {
    getPage("header", ['page_title' => 'You are banned!']);
    getPage('ban');
} elseif (isset($_SESSION['Auth']) && isset($_GET['user']) && $user['ac_status'] == 1) {
    $profile = getuserprofile($_GET['user']);
    if (!$profile) {
        header("location:?");
    } else {
        $user_post = userPosts($profile['id']);
        $profile['follower'] = follower($profile['id']);
        $profile['following'] = following($profile['id']);
        getPage("header", ['page_title' => $profile['first_name'] . ' ' . $profile['last_name']]);
        getPage('navbar');
        getPage('profile');
        // for update notification status 
        if (isset($_GET['vnt'])) {
            vitnot($_GET['vnt']);
        }
    }
} elseif (isset($_SESSION['Auth']) && isset($_GET['chats']) && $user['ac_status'] == 1) {
    if (isset($_GET['cum'])) {
        $us_profile = getuser($_GET['cum']);
        getPage("header", ['page_title' => $us_profile['first_name'] . ' ' . $us_profile['last_name']]);
    }else{
        getPage("header", ['page_title' => 'Messeges']);
    }
    getPage('chat');
} elseif (isset($_SESSION['Auth']) && isset($_GET['editprofile']) && $user['ac_status'] == 1) {
    getPage("header", ['page_title' => 'Update Profile']);
    getPage('navbar');
    getPage('edit_profile');
} elseif (isset($_SESSION['Auth']) && isset($_GET['fr_sug']) || isset($_GET['search']) && $user['ac_status'] == 1) {
    getPage("header", ['page_title' => 'Find new friends']);
    getPage('navbar');
    getPage('fr_sug');
} elseif (isset($_GET['signup'])) {
    getPage("header", ['page_title' => 'OutLink | Sign up']);
    getPage("signup");
} elseif (isset($_GET['login'])) {
    getPage("header", ['page_title' => 'OutLink | Log in']);
    getPage('login');
} elseif (isset($_GET['forgot_pass'])) {
    getPage("header", ['page_title' => 'Reset your password']);
    getPage('forgot_pass');
} else {
    if (isset($_SESSION['Auth']) && $user['ac_status'] == 1) {
        getPage("header", ['page_title' => 'OutLink | Newsfeed']);
        getPage('navbar');
        getPage('newsfeed');
    } elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 0) {
        getPage("header", ['page_title' => 'Verify your email']);
        getPage('verify');
    } elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 2) {
        getPage("header", ['page_title' => 'You are banned!']);
        getPage('ban');
    } else {
        getPage("header", ['page_title' => 'OutLink | Log in']);
        getPage('login');
    }
}


// get updated
if (isset($_SESSION['Auth'])) {
    $up_msg = getAllmsg();
    foreach ($up_msg as $um) {
        if ($um['messege'][0]['read_status'] != 1) {
            $_SESSION['uppage'] = false;
        } else {
            $_SESSION['uppage'] = true;
        }
    }

    if (isset($_SESSION['uppage']) && !$_SESSION['uppage']) {
        echo '<script>setInterval(() => {
                window.location.reload();
              }, 90000);</script>';
    }
}







getPage("footer");
unset($_SESSION['error']);
unset($_SESSION['formdata']);
// log out from social media 
if (isset($_GET['logout'])) {
    session_destroy();
    echo "<script>location.reload()</script>";
    header("location:./");
}
