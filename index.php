<?php
require_once 'assets/php/function.php';


if (isset($_SESSION['Auth'])){
    $user = getuser($_SESSION['user_id']['id']);
}

if (isset($_SESSION['Auth']) && $user['ac_status'] == 1) {
    getPage("header", ['page_title' => 'OutLink | Newsfeed']);
    getPage('newsfeed');

} elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 0) {
    getPage("header", ['page_title' => 'Verify your email']);
    getPage('verify');

} elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 2) {
    getPage("header", ['page_title' => 'You are banned!']);
    getPage('ban');

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
    getPage("header", ['page_title' => 'OutLink | Log in']);
    getPage('login');

}




getPage("footer");
unset($_SESSION['error']);
unset($_SESSION['formdata']);
