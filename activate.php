<?php

require './inc/functions.php';

if (isset($_GET['email']) && isset($_GET['activation_code']) && isset($_GET['expiration_time'])) {
    if (time() > $_GET['expiration_time']) {
        delete_user_by_email($_GET['email']);
        header('location:login.php?link_expired');
        exit;
    }
    $user = find_unverified_user($_GET['activation_code'], $_GET['email']);
    if ($user && activate_user($user['id'])) {
        header('location:login.php');
        exit;
    } else {
        header('location:login.php?already_verified');
        exit;
    }
} else {
    header('location:login.php?invalid_link');
    exit;
}
