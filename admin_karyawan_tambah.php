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
<head>
    <title>Tambah User</title>
    <script src="jquery.js"></script>
</head>
<body>
<form action="admin_karyawan_tambah_process.php" method="post">
    <label>Nama</label><input type="nama" name="nama" required>
    <label>Username</label><input type="text" name="username" required>
    <label>Password</label><input type="password" name="password" required>
    <label>Jabatan</label><select name="jabatan" id="jabatan">
        <option>Pilih</option>
        <?php  
            $sql = "SELECT * from role where jabatan != 'Dosen' and jabatan != 'Admin'";
            $result = $mysqli->query($sql);
            while ($row = $result->fetch_assoc()){
                echo "<option value='".$row['id']."'>".$row['jabatan']."</option>";
            }
        ?>
    </select>
    <select name="combo2" id="combo2">
        <option>Pilih</option>

    </select>
    <button type="submit">Tambah</button>
</form>
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