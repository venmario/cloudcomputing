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
	<title>Admin Karyawan</title>
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
				<h1>Karyawan</h1>
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
	<a href="admin.php">Back</a>
	<a href="admin_karyawan_tambah.php"><button>Tambah User</button></a>
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
		<div class="footer">
			<div class="copyright_section">
		    	<p class="copyright_text">Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
		    </div>
		</div>
	</div>
</body>
</html>