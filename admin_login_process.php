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

    	$sql = "SELECT k.username, k.nama, k.id, r.jabatan from karyawan k inner join role r on r.id = k.role_id where username = ? and password = ? and r.jabatan = 'Admin'";
    	$stmt = $mysqli->prepare($sql);
    	$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$res = $stmt->get_result();
		$row = $res->fetch_assoc();
		if($row != false){
			$_SESSION['usernameadmin'] = $username;
			$_SESSION['namaadmin'] = $row['nama'];
			$_SESSION['idadmin'] = $row['id'];
			header("location: admin.php");
		}
		else{
			$_SESSION['error'] = 1;
			header("location: admin_login.php");
		}
    }
}
?>