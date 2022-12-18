<?php  
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
session_start();
if(!isset($_SESSION['usernameadmin']))
{
	header("location: admin_login.php");
	exit;
}
else{
	$nama = $_POST['nama'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$jabatan = $_POST['jabatan'];
	$pilihan2 = $_POST['combo2'];

	$mysqli->select_db("presensi_cloud");
	
	$sql = "INSERT into karyawan (username, password, nama, role_id) values(?, ?, ?, ?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("sssi", $username, $password, $nama, $jabatan);
		$stmt->execute();
		$idKaryawan = $stmt->insert_id;

	if($jabatan == 2 || $jabatan == 3) {//dekan wakil dekan
		$sql = "SELECT * from dac_rules where field like 'fakultas%' and value = $pilihan2";

	}else{//kajur
		$sql = "SELECT * from dac_rules where field like 'jurusan%' and value = $pilihan2";
	}
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();

	$sql = "INSERT into dac_karyawan (dac_id, karyawan_id) values (".$row['id'].", $idKaryawan)";
	$result = $mysqli->query($sql);
	
	header("location: admin.php");			
}
?>