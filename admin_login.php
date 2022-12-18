<?php  
session_start();
if(isset($_SESSION['usernameadmin']))
{
	header("location: admin.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Admin</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="wrap">
	<div class="kotak_login admin">
	      <form action="admin_login_process.php" method="post">
	      		<?php 
		if(isset($_SESSION['error']))
		{
			echo "<p>Username atau Password salah</p>";
			unset($_SESSION['error']);
		}
		?>
	        
	        <label>Username</label>
	        <input type="text" name="username" class="form_login" placeholder="Username atau email ..">
	     
	        <label>Password</label>
	        <input type="password" name="password" class="form_login" placeholder="Password ..">
	     
	        <input type="submit" name="btnlogin" class="tombol_login" value="LOGIN">
	      </form>
	    </div>
	    </div>
</body>
</html>