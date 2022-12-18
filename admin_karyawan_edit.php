<?php  
// EDIT DAC
session_start();
if(!isset($_SESSION['usernameadmin'])){
		header("location: admin_login.php");
}

$_SESSION['idKaryawan'] = $_GET['id'];
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');

$id = $_GET['id'];

$sql = "SELECT k.nama, r.jabatan, dr.field, dr.value from karyawan k inner join role r on r.id = k.role_id inner join dac_karyawan dk on dk.karyawan_id = k.id inner join dac_rules dr on dr.id = dk.dac_id where k.id = $id";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$jabatan = $row['jabatan'];
$nama = $row['nama'];
$value = $row['value'];
?>


<!DOCTYPE html>
<html>
<head>
	<title>Karyawan Edit</title>
	<script src="jquery.js"></script>
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
				<h1><?php echo $nama ?></h1>
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
			<?php  
		$sql = "SELECT * from jurusanss where status = 'Aktif'";

		if($jabatan == "Dekan" || $jabatan == "Wakil Dekan"){
			$sql .=" and fakultass_id = $value";
			$result = $mysqli->query($sql);
		}elseif($jabatan == "Kajur"){
			$sql .=" and id = $value";
			$result = $mysqli->query($sql);
		}
	?>
	<div class="dac-form">
	<h2>Edit Karyawan</h2>
	<form method="post" action="admin_dac.php?idkaryawan=<?php echo $id ?>">
<!-- 		<div class="div-control">
			<div class="div-label">
				<label>Pilih Jurusan</label>
			</div>
			<div class="form-control">
				
			</div>
		</div> -->
		<div class="div-control">
			<div class="div-label">
				<label>Pilih Jurusan</label>
			</div>
			<div class="form-control">
				<select id="combo-jurusan" name="combo-jurusan">
				<option>Plilh Jurusan</option>
				<?php  
					while($row = $result->fetch_assoc()){//iterasi per jurusan klo dekan
						echo'<option value="'.$row['id'].'">'.$row['nama'].'</option>';
					}
				?>
				</select>
			</div>
		</div>
		<div class="div-control">
			<div class="div-label">
				<label>Pilih Mata Kuliah</label>
			</div>
			<div class="form-control">
				<select id="combo-matkul" name="combo-matkul">
			<option>Pilih Matkul</option>
		</select>
			</div>
		</div>
		<div class="div-control">
			<div class="div-label">
				<label>Pilih Operator</label>
			</div>
			<div class="form-control">
				<select id="combo-operator" name="combo-operator">
					<option>Pilih Operator</option>
					<option value="<="><=</option>
					<option value=">=">>=</option>
					<option value="==">==</option>
					<option value="<"><</option>
					<option value=">">></option>
				</select>
			</div>
		</div>
		<div class="div-control">
			<div class="div-label">
				<label>Masukkan Value</label>
			</div>
			<div class="form-control">
				<input type="number" name="numvalue" placeholder="Masukan Value (%)">
			</div>
		</div>
		
		<button type="submit" name="btnsubmit">Tambah/Rubah DAC</button>
	</form>
	</div>

	<?php 
		$sql = "SELECT dr.field, dr.operator, dr.value from dac_rules dr inner join dac_karyawan dk on dr.id = dk.dac_id where dk.karyawan_id = $id";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$dac_value = $row['value'];

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
			echo' 		<tr><td colspan="3" style="text-align: center;">Jurusan '.$row['nama'].'</td></tr>';
			echo' 		<tr>';
			echo'			<td>Nama Matakuliah</td>';
			echo'			<td>Operator</td>';
			echo'			<td>Value</td>';
			echo'		</tr>';
			echo' 	</thead>';
			echo' 	<tbody>';
			$mysqli->select_db('presensi_cloud_'.$row['id']);

			$sql = "SELECT m.nama, dk.operator, dk.value from dac_kehadiran dk inner join matakuliahs m on m.id = dk.matakuliahs_id where karyawan_id = $id";// ambil dac yang ada di jurusan itu oleh karyawan itu
			$result1 = $mysqli->query($sql);

			while($row1 = $result1->fetch_assoc()){
				echo '<tr>';
				echo '	<td>'.$row1['nama'].'</td>';
				echo '	<td>'.$row1['operator'].'</td>';
				echo '	<td>'.($row1['value']*100).'% </td>';
				echo '</tr>';
				

				
			}
		}
		echo' 	</tbody>';
		echo' </table>';
	?>
 		</div>
		<div class="footer">
			<div class="copyright_section">
		    	<p class="copyright_text">Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
		    </div>
		</div>
	</div>
	

	<script type="text/javascript">
		$(document).ready(function(){
			$('#combo-jurusan').change(function(){
				var hasil = '<option>TES</option>';
				var idjurusan = $('#combo-jurusan').val();

				$.ajax({
					method: "post",
					url: "data.php",
					data: {idjurusan: idjurusan},
					dataType: 'json',
					success:function(data){
						$("#combo-matkul").empty();
						for (var i = 0; i < data.length; i++) {
							$('#combo-matkul').append('<option value="'+data[i]['id']+'">'+data[i]['nama']+'</option>');
						}
					}
				});
			});
		});
		
	</script>
</body>
</html>