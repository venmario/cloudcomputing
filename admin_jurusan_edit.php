<?php  
session_start();
if(!isset($_SESSION['usernameadmin']))
	{
		header("location: admin_login.php");
		exit;
	}
$_SESSION['idJurusan'] = $_GET['id'];

include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');

$stmt = $mysqli->prepare("SELECT nama from jurusanss where id = ?");
$stmt->bind_param("i", $_SESSION['idJurusan']);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();


?>
<!DOCTYPE html>
<html>
<head>
	<title>
		Edit Jurusan
	</title>
	<style type="text/css">
		body {background-image: url("https://i.pinimg.com/originals/a3/64/fc/a364fcd4f19d239f78b00fdc7d759dd9.jpg"); background-size: 100% 100%; background-attachment: fixed;}
		#container {border: 5px solid black; width: 50%; margin: auto; border-radius: 20px; padding: 10px; backdrop-filter: blur(5px);}
		#custom_field {border: 3px solid black; width:80%; margin: auto; border-radius: 20px; padding: 10px; margin-bottom: 5px; padding: 10px;clear: both;}
		#custom{ padding: 10px;}
		.group{width: 100%;clear: both;}
		.label{float: left;padding: 2px; width: 40%;}
		.control{float: left;padding: 3px; width: 50%;}
		#custom_field input,select{width: 100%;}
		.group button{margin-left: 42%;}
		button{background-color: lightgreen; border-radius: 70px;}
		table, tr, td{border-collapse: collapse; border:2px solid black;}
		td{width: 33%}
		table{width: 100%}
	</style>
</head>
<script type="text/javascript" src="jquery.js"></script>
<body>
	<form action="admin_jurusan_edit_process.php" method="post">
		<div id=background >
			<div id=container>
				<div id=fakultas>
					<label>Jurusan <?php echo $row['nama'] ?></label>
					
				</div>
				<div id=custom>
					<div id=custom_field>
						<div class="group">
							<table>
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
					</div>
					<div id=custom_field>
						<div class="group">
							<label class="label">Custom Fields</label>
							<div class="control">
								<input type="text" name="custom[]">
							</div>
						</div>
						<div class="group">
							<label class="label">Tipe Data</label>
							<div class="control">
								<select name="tipe[]" ><br>
									<option value="varchar">Text</option>
									<option value="decimal">Angka</option>
								</select>
							</div>
						</div>
						<div class="group">
							<label class="label">Ukuran Data</label>
							<div class="control">
								<input type="number" name="size[]">
							</div>
						</div>
						<div class="group">
							<label class="label">Tabel</label>
							<div class="control">
									<select name="entity[]" ><br>
										<option value="">Pilih Tabel</option>
										<option value="ambil_matakuliahs">Ambil Matakuliah</option>
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
						<div class="group">
							<button type="submit" id="tambahcustom" value="Daftar">Tambah Custom Field</button><br>
						</div>
						
					</div>
				</div>
				
			<button type="submit" value="Daftar">Edit</button>
			</div>
		</div>
		
		
	</form>
<script type="text/javascript">
	// $("#tambahcustom").on('click', function(){
	// 	var hasil = '<div id=custom_field>';
	// 	hasil+=				'<div class="group">';
	// 	hasil+=					'<label class="label">Custom Fields</label>';
	// 	hasil+=					'<div class="control">';
	// 	hasil+=				'<input type="text" name="custom[]">';
	// 	hasil+=					'</div>';
	// 	hasil+=				'</div>';
	// 	hasil+=				'<div class="group">';
	// 	hasil+=					'<label class="label">Tipe Data</label>';
	// 	hasil+=					'<div class="control">';
	// 	hasil+=						'<select name="tipe[]" >'
	// 	hasil+=							'<option value="varchar">Text</option>';
	// 	hasil+=							'<option value="decimal">Angka</option>';
	// 	hasil+=						'</select>';
	// 	hasil+=					'</div>';
	// 	hasil+=				'</div>';
	// 	hasil+=					'<div class="group">';
	// 	hasil+=						'<label class="label">Ukuran Data</label>';
	// 	hasil+=						'<div class="control">';;
	// 	hasil+=							'<input type="number" name="size[]">';
	// 	hasil+=						'</div>';;
	// 	hasil+=					'</div>';;
	// 	hasil+=				'<div class="group">';
	// 	hasil+=					'<label class="label">Tabel</label>';
	// 	hasil+=					'<div class="control">';
	// 	hasil+=						'<select name="entity[]" >';
	// 	hasil+=							'<option value="">Pilih Tabel</option>';
	// 	hasil+=							'<option value="ambil_matakuliahs">Ambil Matakuliah</option>';
	// 	hasil+=							'<option value="jadwals">jadwal</option>';
	// 	hasil+=							'<option value="jadwal_matakuliahs">Jadwal Matakuliah</option>';
	// 	hasil+=							'<option value="kehadirans">Kehadiran</option>';
	// 	hasil+=							'<option value="mahasiswas">Mahasiswa</option>';
	// 	hasil+=							'<option value="matakuliahs">Matakuliah</option>';
	// 	hasil+=							'<option value="matakuliahs_buka">Matakuliah Buka</option>';
	// 	hasil+=							'<option value="matakuliahs_kp">Matakuliah KP</option>';
	// 	hasil+=						'</select>';
	// 	hasil+=					'</div>';
	// 	hasil+=				'</div>';
	// 	hasil+=				'<div class="group">';
	// 	hasil+=					'<button type="button" class="hapuscustom">Hapus Custom Field</button>';
	// 	hasil+=				'</div>';
	// 	hasil+=			'</div>';
	// 	$("#custom").append(hasil);
	// });

	// $('body').on('click','.hapuscustom',function(){
	// 		$(this).parent().parent().remove();
	// });
</script>
</body>
</html>