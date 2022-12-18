<?php 
session_start();

unset($_SESSION['usernamemahasiswa']);
unset($_SESSION['namamahasiswa']);
unset($_SESSION['idmahasiswa']);

header("location: mahasiswa_login.php");

?>