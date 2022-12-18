<?php  
session_start();
if(isset($_POST['btnlogin']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];

	include ('connectdb.php');
	$mysqli = konek('localhost', 'root', '');

	if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();

    }
    else{
    	$mysqli->select_db('presensi_cloud_1');//sebagai contoh, hanya pakai satu jurusan saja jadi coding pemilihan schema, dilakukan secara hardcode.
    	// jika mau auto pilih db maka bisa pakai field NRP, jika nrp 16xxxxxxx berarti teknik, jika nrp xx04xxxxx berarti informatika.

    	$sql = "select * from mahasiswas where nrp = ? and password = ?";
    	$stmt = $mysqli->prepare($sql);
    	$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$res = $stmt->get_result();
		$row = $res->fetch_assoc();
		if($row != false){
			$_SESSION['usernamemahasiswa'] = $username;
			$_SESSION['namamahasiswa'] = $row['nama'];
			$_SESSION['idmahasiswa'] = $row['id'];
			header("location: mahasiswa.php");
		}
		else{
			$_SESSION['error'] = 1;
			header("location: mahasiswa_login.php#login-popup");
		}
    }
}
?>