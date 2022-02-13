<?php
require_once "../assets/php/function.php";


if (isset($_SESSION['Auth'])) {
  $user = $_SESSION['user_id'];
  if (count(getadmin($user['id'])) < 1) {
    header("location:../");
  }
}

if (isset($_SESSION['ad_auth'])) {
  getadpage("dash", ['page_title' => 'Admin Dashboard']);
} else {
  getadpage("login", ['page_title' => 'Login as admin']);
}
