<?php 
session_start();

unset($_SESSION['usernamekaryawan']);
unset($_SESSION['namakaryawan']);

header("location: karyawan_login.php");

?>