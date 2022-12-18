<?php
session_start();
if(!isset($_SESSION['usernameadmin']))
    {
        header("location: admin_login.php");
        exit;
    }
$id = $_SESSION['idJurusan'];
$entity = $_POST['entity'];

include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $customHapus = (isset($_POST['custom_hapus'])) ? $_POST['custom_hapus'] : "";

    if($customHapus != ""){
        echo "masukif";
        foreach ($customHapus as $key) {
            $mysqli->select_db("presensi_cloud");
            $sql = "SELECT entity as entity, custom_field as nama from metadatas where id = ".$key;
            $result = $mysqli->query($sql);
            $row = $result->fetch_assoc();

            $entityCustom = $row['entity']; 
            $attr = $row['nama'];

            $sql = "DELETE from metadatas where id = ".$key;
            $result = $mysqli->query($sql);

            $mysqli->select_db("presensi_cloud_".$id);

            $sql = "ALTER TABLE ".$entityCustom." DROP ".$attr;
            $result = $mysqli->query($sql);
        }
    }

    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    else {
        echo "masukelse";
        $mysqli->select_db("presensi_cloud_".$id);
        
        
        if($_POST['entity'][0] != ""){
            $custom = $_POST['custom'];
            $tipe = $_POST['tipe'];
            $size = $_POST['size'];
            $entity = $_POST['entity'];
            $i=0;
            foreach ($entity as $key) {
                $sql = "ALTER TABLE $key ADD $custom[$i] $tipe[$i]($size[$i])";
                $result = $mysqli->query($sql);
                $i++;
            }
            

            $mysqli->select_db('presensi_cloud');
            $i=0;
            foreach ($entity as $key) {
                $sql = "INSERT into metadatas (entity, custom_field, jurusanss_id) values ('".$key."','".$custom[$i]."','".$id."')";
                $result = $mysqli->query($sql);
                $i++;
            }
        }
        // unset($_SESSION['idJurusan']);
        header("Location:admin.php?id=".$_SESSION['idJurusan']."#edit-jurusan-popup");
        unset($_SESSION['idJurusan']);
        exit;
    }
}
echo "gakmasuk";
?>