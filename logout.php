<?php
session_start();

setcookie('cashplay_is_login', '', time() - 3600, '/');
setcookie('user_name', '', time() - 3600, '/');
setcookie('phone_number', '', time() - 3600, '/');
setcookie('user_unique', '', time() - 3600, '/');


session_unset();
session_destroy();
ob_start();

header("location:index.php");
ob_end_flush();

//include 'home.php';
exit();
