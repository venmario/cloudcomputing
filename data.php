<?php  
 include ('connectdb.php');
 $mysqli = konek('localhost', 'root', '');

 if(isset($_POST['idjurusan'])){
  $idjurusan = $_POST['idjurusan'];
  $arr_matkul = array();

  $mysqli->select_db('presensi_cloud_'.$idjurusan);
  $sql = "SELECT * from matakuliahs";
  $result = $mysqli->query($sql);

  while ($row = $result->fetch_assoc()){
   $id = $row['id'];
   $matkul = $row['nama'];

   $arr_matkul[] = array("id" => $id, "nama" => $matkul);
  }

  echo json_encode($arr_matkul);
 }
 if (isset($_POST['idjabatan'])) {
  $idjabatan = $_POST['idjabatan'];
  $arr_karyawan = array();

  $mysqli->select_db('presensi_cloud');

  if($idjabatan == 2 || $idjabatan == 3){//dekan wakil dekan
   $sql = "SELECT * from fakultass";
  }else{//kajur
   $sql = "SELECT * from jurusanss";
  }
  
  $result = $mysqli->query($sql);

  while ($row = $result->fetch_assoc()){
   $id = $row['id'];
   $matkul = $row['nama'];

   $arr_karyawan[] = array("id" => $id, "nama" => $matkul);
  }

  echo json_encode($arr_karyawan);
 }
 
?>