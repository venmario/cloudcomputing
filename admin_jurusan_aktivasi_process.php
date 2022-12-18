<?php 
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
session_start();
if(!isset($_SESSION['usernameadmin']))
    {
        header("location: admin_login.php");
        exit;
    }
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
else {
    $mysqli->select_db('presensi_cloud');

    $id = $_GET['id'];
    //buat schema untuk jurusan yang ingin diaktivasi.
    $newSchema = 'presensi_cloud_'.$id;
    $sql = "create database ".$newSchema;
    $result = $mysqli->query($sql);

    $restore_file  = "Master.sql";
    $server_name   = "localhost";
    $username      = "root";

    $cmd = "mysql -h {$server_name} -u {$username} {$newSchema} < $restore_file";
    exec($cmd);
    var_dump($_POST['entity']);

    $sql = "UPDATE jurusanss SET status = 'Aktif' where id = ".$id;
    $result = $mysqli->query($sql);

    header("Location:admin_jurusan.php");
    exit;
}

?>