<?php
session_start();
setcookie('presence', '', time() - 3600);
setcookie('isAdmin', '', time() - 3600);
unset($_SESSION['userId']);
session_destroy();
header("location:login.php");
