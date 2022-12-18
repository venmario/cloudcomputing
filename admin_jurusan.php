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
	<title>Admin Jurusan</title>
	<link rel="stylesheet" href="desain.css">
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="logo">
				<a href="admin_login.php">
					<img src="images/ubaya.png" alt="logo">
				</a>
			</div>
			<div class="search">
				<h1>Jurusan</h1>
			</div>
			<div class="profile">
				<div class="username">
					<a href="#"><?php echo"Halo, ".$_SESSION['namaadmin']; ?></a>
				</div>
				<div class="photo">
					<img src="https://uls.ubaya.ac.id/theme/image.php/lambda/core/1615961415/u/f1" alt="photoprofile">
				</div>
				<div class="logout">
					<a href="karyawan_logout.php"><img src="images/logout.png"></a>
				</div>
			</div>
		</div>
		<div class="content">
	<a href="admin.php">Back</a>
	<table class="content-table">
		<thead>
			<td>Fakultas</td>
			<td>Jurusan</td>
			<td>Aktivasi</td>
			<td>Edit</td>
		</thead>
		<?php 
			$sql = "SELECT j.status as status, j.id as idJurusan, j.nama as namaJurusan, f.nama as namaFakultas FROM jurusanss j inner join fakultass f on j.fakultass_id = f.id ORDER BY namaFakultas, namaJurusan ASC";
			$result = $mysqli->query($sql); //list semua jurusan di setiap fakultas

			while ($row = $result->fetch_assoc()) {
				echo"<tr>";
				echo	"<td>".$row['namaFakultas']."</td>";
				echo	"<td>".$row['namaJurusan']."</td>";
				if($row['status'] == "Tidak Aktif"){// klo blom aktif muncul timbol aktivasi tpi tombol edit dihilangkan.
					echo "<td>"."<a href='admin_jurusan_aktivasi_process.php?id=".$row['idJurusan']."'>Aktivasi</a>"."</td>";
					echo "<td>Belum Aktif</td>";
				}
				else{// klo udh aktif, muncul tulisan udh aktif, dan bisa di edit
					echo "<td>Sudah Aktif</td>";
					echo "<td>"."<a href='admin_jurusan_edit.php?id=".$row['idJurusan']."'>Edit</a>"."</td>";
				} 
				echo"</tr>";
			}
		?>
	</table>
	</div>
		</div>
		<div class="footer">
			<div class="copyright_section">
		    	<p class="copyright_text">Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
		    </div>
		</div>
	</div>
</body>
</html>