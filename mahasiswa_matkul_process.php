<?php  
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
session_start();
if(!isset($_SESSION['usernamemahasiswa']))
{
	header("location: mahasiswa_login.php");
	exit;
}
$id = $_SESSION['idmahasiswa'];
$idmatkul = $_GET['idmatkul'];
$kp = $_GET['idkp'];
$kode = $_POST['kode'];
$tanggal = 
$mysqli->select_db('presensi_cloud_1');

$sql = "SELECT mk.status as status, mk.kode as kode, j.id as jadwal from jadwal_matakuliahs jm left join jadwals j on j.id = jm.jadwals_id right join matakuliahs_kp mk on mk.matakuliahs_id = jm.matakuliahs_id where mk.matakuliahs_id = $idmatkul and mk.matakuliahs_buka_id = $kp";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

if($row['status'] == "Available" and $kode == $row['kode']){
	$sql = "INSERT into kehadirans (mahasiswas_id, matakuliahs_id, matakuliahs_buka_id, jadwals_id, tanggal) values($id, $idmatkul, $kp, ".$row['jadwal'].", NOW())";
	$result = $mysqli->query($sql);
	header("location: mahasiswa_matkul.php?idmatkul=$idmatkul&idkp=$kp");
}else{
	header("location: mahasiswa_matkul.php?idmatkul=$idmatkul&idkp=$kp");
}
?>