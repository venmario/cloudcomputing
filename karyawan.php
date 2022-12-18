<?php 
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
session_start();
if(!isset($_SESSION['usernamekaryawan']))
{
	header("location: karyawan_login.php");
	exit;
}
$id = $_SESSION['idkaryawan'];
$jabatan = $_SESSION['jabatan'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Karyawan Index</title>
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
				<h1>Dashboard</h1>
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
			
				<?php  
					if($jabatan == "Dosen"){
						echo '<div class="deck">';
						$mysqli->select_db('presensi_cloud');
						$sql = "SELECT dr.value from dac_rules dr inner join dac_karyawan dk on dk.dac_id = dr.id where dk.karyawan_id = $id and dr.field = 'jurusanss_id'";
						$result = $mysqli->query($sql);
						$row = $result->fetch_assoc();
						$_SESSION['idjurusankaryawan'] = $row['value'];
						
						$mysqli->select_db('presensi_cloud_'.$_SESSION['idjurusankaryawan']);
						$sql = "SELECT m.id as id, m.nama as nama, mb.kp as kp, mb.id as idkp from matakuliahs_kp mk inner join matakuliahs m on m.id=mk.matakuliahs_id inner join matakuliahs_buka mb on mb.id=mk.matakuliahs_buka_id where mk.dosen_id=$id";
						$result = $mysqli->query($sql);
						while ($row = $result->fetch_assoc()) {
							// echo 	"<a href='karyawan_matkul.php?idmatkul=".$row['id']."&idkp=".$row['idkp']."' class='item'><div >".$row['nama']." KP ".$row['kp']."</div></a>";

							echo '<div class="item">
									<div class="gambar-item">
										<a href="karyawan_matkul.php?idmatkul='.$row['id']."&idkp=".$row['idkp'].'" class="item">
											<img src="images/pattern.jpg" alt="">
									</a>
									</div>
									<div class="judul">
										<a href="karyawan_matkul.php?idmatkul='.$row['id']."&idkp=".$row['idkp'].'">'.$row['nama'].' KP '.$row['kp'].'</a>
									</div>
								</div>';
						}
						echo '</div>';
					}
					else{
						$sql = "SELECT dr.field, dr.operator, dr.value from dac_rules dr inner join dac_karyawan dk on dr.id = dk.dac_id where dk.karyawan_id = $id";
						$result = $mysqli->query($sql);
						$row = $result->fetch_assoc();
						$dac_value = $row['value'];

						$sql = "SELECT * from jadwal_perkuliahan";
						$result2 = $mysqli->query($sql);
						$row2 = $result2->fetch_assoc();
						$first = new DateTime($row2['kuliah_1']);
					    $second = new DateTime('now');	
					    $diff = $second->diff($first)->format("%a");
					    $total_minggu = (ceil($diff/7) > 7) ? 7 : ceil($diff/7);

					    $sql = "SELECT * from jurusanss where status = 'Aktif'";
							

						if($jabatan == "Dekan" || $jabatan == "Wakil Dekan"){
							$sql .=" and fakultass_id = $dac_value";
							$result = $mysqli->query($sql);//mengambil semua jurusan yang ada di fak itu yang aktif.
						}elseif($jabatan == "Kajur"){
							$sql .=" and id = $dac_value";
							$result = $mysqli->query($sql);
						}
						
						while($row = $result->fetch_assoc()){// iterasi per jurusan
							echo' <table class="content-table">';
							echo' 	<thead>';
							echo' 		<tr><td colspan="2" style="text-align: center;">Jurusan '.$row['nama'].'</td></tr>';
							echo' 		<tr>';
							echo'			<td>Nama Mahasiswa</td>';
							echo'			<td>Matakuliah</td>';
							echo'		</tr>';
							echo' 	</thead>';
							echo' 	<tbody>';
							$mysqli->select_db('presensi_cloud_'.$row['id']);

							$sql = "SELECT * from dac_kehadiran where karyawan_id = $id";// ambil dac yang ada di jurusan itu oleh karyawan itu
							$result1 = $mysqli->query($sql);

							while($row1 = $result1->fetch_assoc()){//iterasi per matkul
								$sql = "SELECT * from jadwal_matakuliahs where matakuliahs_id = ".$row1['matakuliahs_id'];
								$result2 = $mysqli->query($sql);
								$jadwal_sekarang = 0;
								$jadwal_unik = 0;
								$jadwal_total = 0;
								$jadwal = array();
								$i = 0;
								while ($row2 = $result2->fetch_assoc()){
									$i++;
									$jadwal_sekarang = $row2['jadwals_id'];
									if($row2['jadwals_id'] - $jadwal_unik <= 2 && $row2['jadwals_id'] - $jadwal_unik > 0 && $i > 0){
										continue;
									}
									else{
										$jadwal_unik = $jadwal_sekarang;
										$jadwal[] = $jadwal_unik;
										$jadwal_total = $jadwal_total + 1;
									}
								}

								if($jadwal_total > 1) $total_minggu = $total_minggu * 2;//klo seminggu jadwalnya 2x maka total minggu*2

								$sql = "SELECT m.nama as nama, am.mahasiswas_id, mat.nama as namamatkul from ambil_matakuliahs am inner join mahasiswas m on m.id = am.mahasiswas_id inner join matakuliahs mat on mat.id = am.matakuliahs_id where matakuliahs_id = ".$row1['matakuliahs_id'];//siapa saja yang ngambil matakuliah tersebut
								$result3 = $mysqli->query($sql);

								while($row3 = $result3->fetch_assoc()){//iterasi per mahasiswa
									$sql = "SELECT m.nama as namamahasiswa, mat.nama as namamatkul from kehadirans k inner join mahasiswas m on m.id = k.mahasiswas_id inner join matakuliahs mat on mat.id = k.matakuliahs_id where mahasiswas_id = ".$row3['mahasiswas_id']." and matakuliahs_id = ".$row1['matakuliahs_id'];
									
									$result4 = $mysqli->query($sql);
									$row4 = $result4->fetch_assoc();
									$kehadiran = $result4->num_rows;//berapa kali dia presensi
									$persentase_kehadiran = $kehadiran / $total_minggu;
									$operator = $row1['operator'];
									if($operator == '<'){
										if($persentase_kehadiran < $row1['value']){
											echo '<tr>';
											echo '	<td>'.$row3['nama'].'</td>';
											echo '	<td>'.$row3['namamatkul'].'</td>';
											echo '</tr>';
										}

								    }elseif($operator == '<='){
								    	if($persentase_kehadiran <= $row1['value']){
											echo '<tr>';
											echo '	<td>'.$row3['nama'].'</td>';
											echo '	<td>'.$row3['namamatkul'].'</td>';
											echo '</tr>';
										}

								    }elseif($operator == '>'){
								    	if($persentase_kehadiran > $row1['value']){
											echo '<tr>';
											echo '	<td>'.$row3['nama'].'</td>';
											echo '	<td>'.$row3['namamatkul'].'</td>';
											echo '</tr>';
										}

								    }elseif($operator == '>='){
								    	if($persentase_kehadiran >= $row1['value']){
											echo '<tr>';
											echo '	<td>'.$row3['nama'].'</td>';
											echo '	<td>'.$row3['namamatkul'].'</td>';
											echo '</tr>';
										}

								    }elseif($operator == '=='){
								    	if($persentase_kehadiran == $row1['value']){
											echo '<tr>';
											echo '	<td>'.$row3['nama'].'</td>';
											echo '	<td>'.$row3['namamatkul'].'</td>';
											echo '</tr>';
										}

									}
								}
							}
						}
						echo' 	</tbody>';
						echo' </table>';

					}
		
				?>
		</div>
		<div class="footer">
			<div class="copyright_section">
		    	<p class="copyright_text">Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
		    </div>
		</div>
	</div>	
</body>
</html>