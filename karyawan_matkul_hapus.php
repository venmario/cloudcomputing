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

$sql = "SELECT * from matakuliahs where id=$idmatkul";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$namamatkul = $row['nama'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Matkul Karyawan</title>
	<link rel="stylesheet" href="desain.css">
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="logo">
				<a href="karyawan_login.php">
					<img src="images/ubaya.png" alt="logo">
				</a>
			</div>
			<div class="search">
				<h1><?php 				$sql = "SELECT mk.status, mk.kode, mb.kp from matakuliahs_kp mk inner join matakuliahs_buka mb on mb.id = mk.matakuliahs_buka_id where matakuliahs_id = $idmatkul and matakuliahs_buka_id = $kp";
				$result = $mysqli->query($sql);
				$row = $result->fetch_assoc(); 
				echo $namamatkul, " ", $row['kp'];?></h1>
			</div>
			<div class="profile">
				<div class="username">
					<a href="#"><?php echo"Halo, ".$_SESSION['namakaryawan']; ?></a>
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
			<form method="post" action="karyawan_matkul_hapus_process.php?idmatkul=<?php echo $idmatkul?>&idkp=<?php echo $kp ?>">
			<h1>
				<?php 
					$sql = "SELECT mk.status, mk.kode, mb.kp from matakuliahs_kp mk inner join matakuliahs_buka mb on mb.id = mk.matakuliahs_buka_id where matakuliahs_id = $idmatkul and matakuliahs_buka_id = $kp";
					$result = $mysqli->query($sql);
					$row = $result->fetch_assoc();
 
				?>	
			</h1>

			<?php  
			$sql = "SELECT * from jadwal_matakuliahs where matakuliahs_id = $idmatkul and matakuliahs_buka_id = $kp";
			$result = $mysqli->query($sql);
			$jadwal_sekarang = 0;
			$jadwal_unik = 0;
			$jadwal_total = 0;
			$jadwal = array();
			$i = 0;
			while ($row = $result->fetch_assoc()){
				$i++;
				$jadwal_sekarang = $row['jadwals_id'];
				if($row['jadwals_id'] - $jadwal_unik <= 2 && $row['jadwals_id'] - $jadwal_unik > 0 && $i > 0){
					continue;
				}
				else{
					$jadwal_unik = $jadwal_sekarang;
					$jadwal[] = $jadwal_unik;
					$jadwal_total = $jadwal_total + 1;
				}
			}

			$mysqli->select_db('presensi_cloud');
			$sql = "SELECT * from jadwal_perkuliahan";
			$result1 = $mysqli->query($sql);
			$row1 = $result1->fetch_assoc();
			$kuliah1 = date_format(date_create($row1['kuliah_1']), "Y-m-d");//week 1-7
			$kuliah2 = date_format(date_create($row1['kuliah_2']), "Y-m-d");//week 8-14
			$mysqli->select_db('presensi_cloud_'.$idjurusan);

			
				$jadwal1 = $jadwal[0];//id
				$sql = "SELECT * from jadwals where id = $jadwal1";
				$result = $mysqli->query($sql);
				$row = $result->fetch_assoc();
				$hari = $row['hari'];
				$next_date = date('Y-m-d', strtotime("$hari", strtotime($kuliah1)));//hari selanjutnya
				echo '<table class="content-table table-dosen">';
				echo 	'<thead>';
				echo 		'<td>Nama Mahasiswa</td>';
				for ($i=1; $i < 8; $i++) { 
					echo '<td>'.date_format(date_create($next_date), "D d M").'</td>';
					$next_date = strtotime($next_date);
					$next_date = date('Y-m-d', strtotime("+1 week", $next_date));
				}

				$sql = "SELECT * from jadwals where id = $jadwal1";
				$result = $mysqli->query($sql);
				$row = $result->fetch_assoc();
				$next_date = date('Y-m-d', strtotime("$hari", strtotime($kuliah2)));//hari selanjutnya
				for ($i=1; $i < 8; $i++) { 
					echo '<td>'.date_format(date_create($next_date), "D d M").'</td>';
					$next_date = strtotime($next_date);
					$next_date = date('Y-m-d', strtotime("+1 week", $next_date));
				}
				echo 	'</thead>';
				echo 	'<tbody>';

				////

				$sql = "SELECT m.id as id, m.nama as nama, am.matakuliahs_id as idmatkul, am.matakuliahs_buka_id as kp from mahasiswas m inner join ambil_matakuliahs am on am.mahasiswas_id=m.id where am.matakuliahs_id = $idmatkul and am.matakuliahs_buka_id = $kp";//per mahasiswa
				$result = $mysqli->query($sql);

				while($row = $result->fetch_assoc()){//loop per mahasiswa
					echo '<tr>';	
					echo 	'<td>'.$row['nama'].'</td>';
					$sql2 = "SELECT * from jadwals where id = $jadwal1";
					$result2 = $mysqli->query($sql2);
					$row2 = $result2->fetch_assoc();
					$next_date = date('Y-m-d', strtotime("$hari", strtotime($kuliah1)));//hari selanjutnya
					for ($i=1; $i < 8; $i++) { //presensi mahasiswa kuliah 1
						$sql3 = "SELECT * FROM kehadirans WHERE mahasiswas_id = ".$row['id']." and matakuliahs_id = ".$idmatkul." and tanggal like '$next_date%' limit 1";
						$result3 = $mysqli->query($sql3);
						if(mysqli_num_rows($result3) > 0){//klo ada presensi, checkboxnya kecentang
							$row3 = $result3->fetch_assoc();
							echo '<td><input type="checkbox" name="chkPresensi[]" value="'.$row['id'].':'.$next_date.':'.$jadwal1.'"></td>';
						}else{//klo gaada, checkboxnya kosong
							echo '<td></td>';
						}
						$next_date = strtotime($next_date);
						$next_date = date('Y-m-d', strtotime("+1 week", $next_date));
					}
					$sql2 = "SELECT * from jadwals where id = $jadwal1";
					$result2 = $mysqli->query($sql2);
					$row2 = $result2->fetch_assoc();
					$next_date = date('Y-m-d', strtotime("$hari", strtotime($kuliah2)));//hari selanjutnya

					for ($i=8; $i < 15; $i++) { //presensi mahasiswa kuliah 2
						$sql3 = "SELECT * FROM kehadirans WHERE mahasiswas_id = ".$row['id']." and matakuliahs_id = ".$idmatkul." and tanggal like '$next_date%' limit 1";
						$result3 = $mysqli->query($sql3);
						if(mysqli_num_rows($result3) > 0){//klo ada presensi, checkboxnya kecentang
							$row3 = $result3->fetch_assoc();
							echo '<td><input type="checkbox" name="chkPresensi[]" value="'.$row['id'].':'.$next_date.':'.$jadwal1.'"></td>';
						}else{//klo gaada, checkboxnya kosong
							echo '<td></td>';
						}
						$next_date = strtotime($next_date);
						$next_date = date('Y-m-d', strtotime("+1 week", $next_date));
					}
					echo '</tr>';
				}
				
				echo 	'</tbody>';
				echo '</table><br><br>';
				if($jadwal_total > 1){
					$jadwal2 = $jadwal[1];//id
					$sql = "SELECT * from jadwals where id = $jadwal2";
					$result = $mysqli->query($sql);
					$row = $result->fetch_assoc();
					$hari = $row['hari'];
					$next_date = date('Y-m-d', strtotime("$hari", strtotime($kuliah1)));//hari selanjutnya
					echo '<table class="content-table table-dosen">';
					echo 	'<thead>';
					echo 		'<td>Nama Mahasiswa</td>';
					for ($i=1; $i < 8; $i++) { 
						echo '<td>'.date_format(date_create($next_date), "D d M").'</td>';
						$next_date = strtotime($next_date);
						$next_date = date('Y-m-d', strtotime("+1 week", $next_date));
					}

					$sql = "SELECT * from jadwals where id = $jadwal2";
					$result = $mysqli->query($sql);
					$row = $result->fetch_assoc();
					$hari = $row['hari'];
					$next_date = date('Y-m-d', strtotime("$hari", strtotime($kuliah2)));//hari selanjutnya
					for ($i=1; $i < 8; $i++) { 
						echo '<td>'.date_format(date_create($next_date), "D d M").'</td>';
						$next_date = strtotime($next_date);
						$next_date = date('Y-m-d', strtotime("+1 week", $next_date));
					}
					echo 	'</thead>';
					echo 	'<tbody>';

					$sql = "SELECT m.id as id, m.nama as nama, am.matakuliahs_id as idmatkul, am.matakuliahs_buka_id as kp from mahasiswas m inner join ambil_matakuliahs am on am.mahasiswas_id=m.id where am.matakuliahs_id = $idmatkul and am.matakuliahs_buka_id = $kp";//per mahasiswa
					$result = $mysqli->query($sql);

					while($row = $result->fetch_assoc()){//loop per mahasiswa
						echo '<tr>';	
						echo 	'<td>'.$row['nama'].'</td>';
						$sql2 = "SELECT * from jadwals where id = $jadwal2";
						$result2 = $mysqli->query($sql2);
						$row2 = $result2->fetch_assoc();
						$hari = $row2['hari'];
						$next_date = date('Y-m-d', strtotime("$hari", strtotime($kuliah1)));//hari selanjutnya
						for ($i=1; $i < 8; $i++) { //presensi mahasiswa kuliah 1
							$sql3 = "SELECT * FROM kehadirans WHERE mahasiswas_id = ".$row['id']." and matakuliahs_id = ".$idmatkul." and tanggal like '$next_date%' limit 1";
							$result3 = $mysqli->query($sql3);
							if(mysqli_num_rows($result3) > 0){//klo ada presensi, checkboxnya kecentang
								$row3 = $result3->fetch_assoc();
								echo '<td><input type="checkbox" name="chkPresensi[]" value="'.$row['id'].':'.$next_date.':'.$jadwal2.'"></td>';
							}else{//klo gaada, checkboxnya kosong
								echo '<td></td>';
							}
							$next_date = strtotime($next_date);
							$next_date = date('Y-m-d', strtotime("+1 week", $next_date));
						}
						$sql2 = "SELECT * from jadwals where id = $jadwal2";
						$result2 = $mysqli->query($sql2);
						$row2 = $result2->fetch_assoc();
						$hari = $row2['hari'];
						$next_date = date('Y-m-d', strtotime("$hari", strtotime($kuliah2)));//hari selanjutnya

						for ($i=8; $i < 15; $i++) { //presensi mahasiswakuliah 2
							$sql3 = "SELECT * FROM kehadirans WHERE mahasiswas_id = ".$row['id']." and matakuliahs_id = ".$idmatkul." and tanggal like '$next_date%' limit 1";
							$result3 = $mysqli->query($sql3);
							if(mysqli_num_rows($result3) > 0){//klo ada presensi, checkboxnya kecentang
								$row3 = $result3->fetch_assoc();
								echo '<td><input type="checkbox" name="chkPresensi[]" value="'.$row['id'].':'.$next_date.':'.$jadwal2.'"></td>';
							}else{//klo gaada, checkboxnya kosong
								echo '<td></td>';
							}
							$next_date = strtotime($next_date);
							$next_date = date('Y-m-d', strtotime("+1 week", $next_date));
						}
						echo '</tr>';
					}
					
				echo 	'</tbody>';
				echo '</table><br><br>';
			}	
			
		?>
		<div class="simpan">
		<button class="btn-presensi hapus" type="submit" name="btnsubmit" value="presensi">HAPUS PRESENSI</button>
			
		</div>
	</form>
		</div>
		<div class="footer">
			<div class="copyright_section">
		    	<p class="copyright_text">Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
		    </div>
		</div>
	</div>
	
	
</body>
</html>