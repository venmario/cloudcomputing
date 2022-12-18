<?php 
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
session_start();
if(!isset($_SESSION['usernameadmin']))
{
	header("location: admin_login.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User</title>
</head>
<body>
	<?php  
		if($_SESSION['jabatan'] == "User Fakultas"){// tampilin matkul
			$mysqli->select_db('presensi_cloud');

			$idJurusan = $_GET['idjurusan'];
			$mysqli->select_db('presensi_cloud_'.$idJurusan);
			
			$sql = "SELECT * from matakuliahs";
			$result = $mysqli->query($sql);
			echo' <table>';
				echo' <thead>';
					echo' <td>Nama Matakuliah</td>';
				echo' </thead>';
				echo' <tbody>';
					while ($row = $result->fetch_assoc()){
						echo "<tr>";
						echo	"<td><a href='admin_user_detil.php?idmatkul=".$row['id']."'>".$row['nama']."</a></td>";
						echo "</tr>";
					}
				echo' </tbody>';
			echo' </table>';
		}else{//tampilin kp
			$idmatkul = $_GET['idmatkul'];
			$sql = "SELECT m.id as id, m.nama as nama, mb.kp as kp from matakuliahs_kp mk inner join matakuliahs m on m.id = mk.matakuliahs_id inner join matakuliahs_buka mb on mb.id = mk.matakuliahs_buka_id where id = $idmatkul";
		}
	?>
</body>
</html>
	
