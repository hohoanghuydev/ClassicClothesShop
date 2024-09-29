<?php
session_start();
if(isset($_SESSION['username'])){
    unset($_SESSION['username'], $_SESSION['name'], $_SESSION['role']);
}
header("location: login-admin.php");
exit();