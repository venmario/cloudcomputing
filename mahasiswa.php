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
// echo"<h1>Halo, ".$_SESSION['namamahasiswa']."</h1>";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mahasiswa Index</title>
		<!-- style css -->
		<link rel="stylesheet" type="text/css" href="desain.css">

</head>
<body>
	<div class="container">
		<div class="header">
			<div class="logo">
				<a href="mahasiswa_login.php">
					<img src="images/ubaya.png" alt="logo">
				</a>
			</div>
			<div class="search">
				<h1>Dashboard</h1>
			</div>
			<div class="profile">
				<div class="username">
					<a href="#"><?php echo"Halo, ".$_SESSION['namamahasiswa']; ?></a>
				</div>
				<div class="photo">
					<img src="https://uls.ubaya.ac.id/theme/image.php/lambda/core/1615961415/u/f1" alt="photoprofile">
				</div>
				<div class="logout">
					<a href="mahasiswa_logout.php"><img src="images/logout.png"></a>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="deck">
				<!-- <div class="item">
					<div class="gambar-item">
						<a href="">
							<img src="images/pattern.jpg" alt="">
						</a>
					</div>
					<div class="judul-item">
						<a href="">Cloud Computing</a>
					</div>
				</div> -->
				<?php
						$mysqli->select_db('presensi_cloud_1');
						$sql = "SELECT m.id as id, m.nama as nama, mb.kp as kp, mb.id as idkp from ambil_matakuliahs am inner join matakuliahs m on m.id = am.matakuliahs_id inner join matakuliahs_buka mb on mb.id=am.matakuliahs_buka_id where am.mahasiswas_id = $id";
						$result = $mysqli->query($sql);
						while ($row = $result->fetch_assoc()) {
							// echo 	"<a href='mahasiswa_matkul.php?idmatkul=".$row['id']."&idkp=".$row['idkp']."' class='item'><div >".$row['nama']."</div></a>";
							echo '<div class="item">
									<div class="gambar-item">
										<a href="mahasiswa_matkul.php?idmatkul='.$row['id']."&idkp=".$row['idkp'].'" class="item">
											<img src="images/pattern.jpg" alt="">
									</a>
									</div>
									<div class="judul">
										<a href="mahasiswa_matkul.php?idmatkul='.$row['id']."&idkp=".$row['idkp'].'">'.$row['nama'].'</a>
									</div>
								</div>';
						}
						
					?>
				
			</div>

				
	<!-- tampilkan daftar mata kuliah, lalu presensi menggunakan popup memasukan kode dan konfirmasi -->
				
			
		</div>
		<div class="footer">
			<div class="copyright_section">
		    	<p class="copyright_text">Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
		    </div>
		</div>
	</div>
	
	
</body>
</html>