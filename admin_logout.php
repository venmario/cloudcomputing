<?php 
session_start();

unset($_SESSION['usernameadmin']);
unset($_SESSION['namaadmin']);

header("location: admin_login.php");

?>