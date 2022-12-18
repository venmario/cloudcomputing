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
    	$mysqli->select_db('presensi_cloud');

    	$sql = "SELECT k.username, k.nama, k.id, r.jabatan from karyawan k inner join role r on r.id = k.role_id where k.username = ? and k.password = ? and r.jabatan != 'Admin'";
    	$stmt = $mysqli->prepare($sql);
    	$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$res = $stmt->get_result();
		$row = $res->fetch_assoc();
		if($row != false){
			$_SESSION['usernamekaryawan'] = $username;
			$_SESSION['namakaryawan'] = $row['nama'];
			$_SESSION['idkaryawan'] = $row['id'];
			$_SESSION['jabatan'] = $row['jabatan'];

			header("location: karyawan.php");
		}
		else{
			$_SESSION['error'] = 1;
			header("location: karyawan_login.php");
		}
    }
}
?>