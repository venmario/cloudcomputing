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
	<title>Admin Index</title>
	<link rel="stylesheet" href="desain.css">
	<script src="jquery.js"></script>
</head>
<body>
<div class="container">
	<div class="overlay" id="edit-jurusan-popup">
		<div class="kotak_edit">
			<form action="admin_jurusan_edit_process.php" method="post">
			<?php 
			$_SESSION['idJurusan'] = $_GET['id'];
			$mysqli->select_db('presensi_cloud');
			$stmt = $mysqli->prepare("SELECT nama from jurusanss where id = ?");
			$stmt->bind_param("i", $_GET['id']);
			$stmt->execute();
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			 ?>
			<a href="#" class="close-btn">x</a>
			<h2>Jurusan <?php echo $row['nama'] ?></h2>
			<div class="group">
				<table class="content-table table-jurusan-edit">
					<thead>
						<tr>
							<td>Nama Custom Field</td>
							<td>Tabel</td>
							<td>HAPUS</td>
						</tr>
					</thead>
					<tbody>
						<?php  
							$stmt = $mysqli->prepare("SELECT * from metadatas where jurusanss_id = ?");
							$stmt->bind_param("i", $_SESSION['idJurusan']);
							$stmt->execute();
							$res = $stmt->get_result();

							while($row = $res->fetch_assoc()){
								echo "<tr>";
								echo 	"<td>".$row['custom_field']."</td>";
								echo 	"<td>".$row['entity']."</td>";
								echo 	"<td><input type='checkbox' name='custom_hapus[]' value='".$row['id']."'></td>";
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
			<div class="div-control">
				<div class="div-label">
					<label>Custom Fields</label>
				</div>
				<div class="form-control">
					<input type="text" name="custom[]">
				</div>
			</div>
			<div class="div-control">
				<div class="div-label">
					<label>Tipe Data</label>
				</div>
				<div class="form-control">
					<select name="tipe[]" ><br>
						<option value="varchar">Text</option>
						<option value="decimal">Angka</option>
					</select>
				</div>
			</div>
			<div class="div-control">
				<div class="div-label">
					<label>Ukuran Data</label>
				</div>
				<div class="form-control">
					<input type="number" name="size[]">
				</div>
			</div>
			<div class="div-control">
				<div class="div-label">
					<label>Tabel</label>
				</div>
				<div class="form-control">
					<select name="entity[]" >
						<option value="">Pilih Tabel</option>
					    <option value="ambil_matakuliahs">Ambil Matakuliah</option>
						<option value="dac_kehadiran">DAC Kehadiran</option>
					    <option value="jadwals">Jadwal</option>
					    <option value="jadwal_matakuliahs">Jadwal matakuliah</option>
					    <option value="kehadirans">Kehadiran</option>
					    <option value="mahasiswas">Mahasiswa</option>
					    <option value="matakuliahs">Matakuliah</option>
					    <option value="matakuliahs_buka">Matakuliah Buka</option>
					    <option value="matakuliahs_kp">Matakuliah KP</option>
					</select>
				</div>
			</div>
			<button type="submit" name="btnsubmit">SIMPAN</button>
			</form>
			<!--  -->
		</div>
	</div>

	<div class="overlay" id="tambah-karyawan-popup">		
			<div class="kotak_tambah">
				<form action="admin_karyawan_tambah_process.php" method="post">
				<h2>Tambah Karyawan</h2>
				<a href="#" class="close-btn">x</a>
				<div class="div-control">
					<div class="div-label">
						<label>Name</label>
					</div>
					<div class="form-control">
						<input type="text" name="nama" required>
					</div>
				</div>
				<div class="div-control">
					<div class="div-label">
						<label>Username</label>
					</div>
					<div class="form-control">
						<input type="text" name="username" required>
					</div>
				</div>
				<div class="div-control">
					<div class="div-label">
						<label>Password</label>
					</div>
					<div class="form-control">
						<input type="password" name="password" required>
					</div>
				</div>
				<div class="div-control">
					<div class="div-label">
						<label>Jabatan</label>
					</div>
					<div class="form-control">
						<select name="jabatan" id="jabatan">
					        <option>Pilih</option>
					        <?php  
					            $sql = "SELECT * from role where jabatan != 'Dosen' and jabatan != 'Admin'";
					            $result = $mysqli->query($sql);
					            while ($row = $result->fetch_assoc()){
					                echo "<option value='".$row['id']."'>".$row['jabatan']."</option>";
					            }
					        ?>
					    </select>
					</div>
				</div>
				<div class="div-control">
					<div class="div-label">
						<label></label>
					</div>
					<div class="form-control">
						<select name="combo2" id="combo2">
					        <option>Pilih</option>
					    </select>
					</div>
				</div>
				<button type="submit" name="btnsubmit">SIMPAN</button>
			</div>
		</form>
	</div>
		<div class="header">
			<div class="logo">
				<a href="admin_login.php">
					<img src="images/ubaya.png" alt="logo">
				</a>
			</div>
			<div class="search">
				<h1>Admin</h1>
			</div>
			<div class="profile">
				<div class="username">
					<a href="#"><?php echo"Halo, ".$_SESSION['namaadmin']; ?></a>
				</div>
				<div class="photo">
					<img src="https://uls.ubaya.ac.id/theme/image.php/lambda/core/1615961415/u/f1" alt="photoprofile">
				</div>
				<div class="logout">
					<a href="admin_logout.php"><img src="images/logout.png"></a>
				</div>
			</div>
		</div>
		<div class="content">
		<!-- <a href="admin_karyawan.php"><button type="submit" name="btnsubmit" value="logout">Karyawan</button></a>
<a href="admin_jurusan.php"><button type="submit" name="btnsubmit" value="logout">Jurusan</button></a>

 -->
 		<div class="container-tab">
 			<div class="tab_triger">
			<ul>
				<li><label for="tab1">Admin</label></li>
				<li><label for="tab2">Karyawan</label></li>
				<li><label for="tab3">Jurusan</label></li>
 				
			</ul>
		</div>
		<div class="tab_container_wrap">
			<input type="radio" checked id="tab1" name="1">
			<div class="tab_content_box">
				<table class="content-table">
				<thead>
					<td>Fakultas</td>
					<td>Jurusan</td>
					<td>Status</td>
				</thead>
				<tbody>
					<?php  
							// tambahin table untuk  display jurusan apa aja dan karyawannya siapa saja beserta dacnya
						$mysqli->select_db('presensi_cloud');
						$sql = "SELECT j.status as status, j.id as idJurusan, j.nama as namaJurusan, f.nama as namaFakultas FROM jurusanss j inner join fakultass f on j.fakultass_id = f.id ORDER BY namaFakultas, namaJurusan ASC";
						$result = $mysqli->query($sql); //list semua jurusan di setiap fakultas

						while ($row = $result->fetch_assoc()) {
							echo"<tr>";
							echo	"<td>".$row['namaFakultas']."</td>";
							echo	"<td>".$row['namaJurusan']."</td>";
							if($row['status'] == "Tidak Aktif"){
								echo "<td>Belum Aktif</td>";
							}
							else{
								echo "<td>Aktif</td>";
							} 
							echo"</tr>";
						}
					?>
				</tbody>
			</table>

			<table class="content-table">
				<thead>
					<td>Username</td>
					<td>Nama</td>
					<td>Jabatan</td>
				</thead>
				<tbody>
					<?php  
						$sql = "SELECT k.username, k.nama, r.jabatan from karyawan k inner join role r on r.id = k.role_id";
						$result = $mysqli->query($sql);
						while ($row = $result->fetch_assoc()) {
							echo"<tr>";
							echo	"<td>".$row['username']."</td>";
							echo	"<td>".$row['nama']."</td>";
							echo	"<td>".$row['jabatan']."</td>";
							echo"</tr>";
						}
					?>
				</tbody>
			</table>
			</div>
			<input type="radio" id="tab2" name="1">
			<div class="tab_content_box">
				<div class="btn-tambah-karyawan">
					<a href="#tambah-karyawan-popup">
						<button>Tambah Karyawan</button>
					</a>
				</div>
				<table class="content-table">
					<thead>
						<tr>
							<td>Username</td>
							<td>Nama</td>
							<td>Jabatan</td>
							<td>Edit DAC</td>
						</tr>
					</thead>
		<?php 
			$sql = "SELECT k.id, k.username, k.nama, r.jabatan from karyawan k inner join role r on r.id = k.role_id where r.jabatan != 'Admin'";
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_assoc()){
				echo"<tr>";
				echo	"<td>".$row['username']."</td>";
				echo	"<td>".$row['nama']."</td>";
				echo	"<td>".$row['jabatan']."</td>";
				if($row['jabatan'] != 'Dosen')
					echo  	"<td>"."<a href='admin_karyawan_edit.php?id=".$row['id']."'>Edit DAC</a>"."</td>";
				else
					echo 	"<td></td>";
				echo"</tr>";
			}
		?>
	</table>
			</div>
			<input type="radio" id="tab3" name="1">
			<div class="tab_content_box">
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
					echo "<td>"."<a href='?id=".$row['idJurusan']."#edit-jurusan-popup'>Edit</a>"."</td>";
				} 
			}
		?>
	</table>
			</div>
 		</div>
 		
			
		</div>
		<div class="footer">
			<div class="copyright_section">
		    	<p class="copyright_text">Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
		    </div>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function(){
            $('#jabatan').change(function(){
                var idjabatan = $('#jabatan').val();

                $.ajax({
                    method: "post",
                    url: "data.php",
                    data: {idjabatan: idjabatan},
                    dataType: 'json',
                    success:function(data){
                        $("#combo2").empty();
                        for (var i = 0; i < data.length; i++) {
                            $('#combo2').append('<option value="'+data[i]['id']+'">'+data[i]['nama']+'</option>');
                        }
                    }
                });
            });
        });
        
    </script>
</body>
</html>