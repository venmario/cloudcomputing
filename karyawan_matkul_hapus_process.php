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
$idjurusan = (isset($_GET['idjurusan'])) ? $_GET['idjurusan'] : $_SESSION['idjurusankaryawan'];
$mysqli->select_db('presensi_cloud_'.$idjurusan);

if(isset($_POST['btnsubmit'])){
	if($_POST['btnsubmit'] == "presensi"){
		$values = (isset($_POST['chkPresensi'])) ? $_POST['chkPresensi'] : "";
		if($values != ""){
			foreach($values as $key){
				$hasil = explode(":", $key);
				$tanggal = date_create($hasil[1]);
				$sql = "DELETE from kehadirans where mahasiswas_id = $hasil[0] and matakuliahs_id = $idmatkul and matakuliahs_buka_id = $kp and jadwals_id = $hasil[2] and tanggal like '$hasil[1]%'";
				$result = $mysqli->query($sql);
				header("location: karyawan_matkul_hapus.php?idmatkul=$idmatkul&idkp=$kp");
			}
		}
		else{
			header("location: karyawan_matkul_hapus.php?idmatkul=$idmatkul&idkp=$kp");
		}
		
		
	}
}

?>