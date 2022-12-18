<?php  
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
session_start();
if(!isset($_SESSION['usernamekaryawan']))
{
	header("location: karyawan_login.php");
	exit;
}
if($_SESSION['jabatan'] != "Dosen"){
	header("location: karyawan.php");
	exit;
}
$id = $_SESSION['idkaryawan'];
$idmatkul = $_GET['idmatkul'];
$kp = $_GET['idkp'];
$mysqli->select_db('presensi_cloud_'.$_SESSION['idjurusankaryawan']);

if(isset($_POST['btnsubmit'])){
	if($_POST['btnsubmit'] == "checkin"){
		$kode = rand(10000000,99999999);
		$sql = "UPDATE matakuliahs_kp set status = 'Available', kode = $kode where matakuliahs_id = $idmatkul and matakuliahs_buka_id = $kp";
		$result = $mysqli->query($sql);
		header("location: karyawan_matkul.php?idmatkul=$idmatkul&idkp=$kp");
	}elseif($_POST['btnsubmit'] == "checkout"){
		$sql = "UPDATE matakuliahs_kp set status = 'Unavailable' where matakuliahs_id = $idmatkul and matakuliahs_buka_id = $kp";
		$result = $mysqli->query($sql);
		header("location: karyawan_matkul.php?idmatkul=$idmatkul&idkp=$kp");
	}elseif($_POST['btnsubmit'] == "presensi"){
		$values = (isset($_POST['chkPresensi'])) ? $_POST['chkPresensi'] : "";
		if($values != ""){
			foreach($values as $key){
				$hasil = explode(":", $key);
				$tanggal = date_create($hasil[1]);
				$sql = "INSERT into kehadirans (mahasiswas_id, matakuliahs_id, matakuliahs_buka_id, jadwals_id, tanggal) values ($hasil[0], $idmatkul, $kp, $hasil[2], '$hasil[1]')";
				$result = $mysqli->query($sql);
				header("location: karyawan_matkul.php?idmatkul=$idmatkul&idkp=$kp");
			}
		}
		else{
			header("location: karyawan_matkul.php?idmatkul=$idmatkul&idkp=$kp");
		}
		
		
	}
}

?>