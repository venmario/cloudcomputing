<?php  
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');

if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
}
else{
	$mysqli->select_db('presensi_cloud');

	if($_POST['btnsubmit'] == "karyawan"){
		$sql = "Select * from karawan";
		$result = $mysqli->query($sql);
		header("location: admin_karyawan.php?result=".$res);

	}
	else{
		$sql = "Select * from jurusan";
		$result = $mysqli->query($sql);
	}

}

?>