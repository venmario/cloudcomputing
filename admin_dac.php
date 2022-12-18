<?php  
// EDIT DAC
session_start();
if(!isset($_SESSION['usernameadmin'])){
		header("location: admin_login.php");
}

include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');

$id = $_GET['idkaryawan'];
$idjurusan = $_POST['combo-jurusan'];
$idmatkul = $_POST['combo-matkul'];
$operator = $_POST['combo-operator'];
$value = ($_POST['numvalue'])/100;
?>


<!DOCTYPE html>
<html>
<head>
	<title>EDIT DAC</title>
</head>
<body>
	<?php 
		if(isset($_POST['btnsubmit'])){
			$mysqli->select_db('presensi_cloud_'.$idjurusan);

			$sql = "SELECT * from dac_kehadiran where karyawan_id = $id and matakuliahs_id = $idmatkul";
			$result = $mysqli->query($sql);

			if(mysqli_num_rows($result) != 0){
				$sql = "UPDATE dac_kehadiran set operator = '$operator', value = '$value' where karyawan_id = $id and matakuliahs_id = $idmatkul";
				$result = $mysqli->query($sql);
			}else{
				$sql = "INSERT into dac_kehadiran (karyawan_id, matakuliahs_id, operator, value) values ($id, $idmatkul, '$operator', '$value')";
				echo $sql;
				$result = $mysqli->query($sql);
			}
			header("location: admin_karyawan_edit.php?id=$id");
		}

	?>
</body>
</html>