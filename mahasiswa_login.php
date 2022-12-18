<?php 
session_start();
if(isset($_SESSION['usernamemahasiswa']))
{
	header("location: mahasiswa.php");
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- site metas -->
<title>Login Mahasiswa</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">	
<!-- bootstrap css -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!-- style css -->
<link rel="stylesheet" type="text/css" href="css/style.css">
<!-- Responsive-->
<link rel="stylesheet" href="css/responsive.css">
<!-- fevicon -->
<link rel="icon" href="images/fevicon.png" type="image/gif" />
<!-- Scrollbar Custom CSS -->
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
<!-- Tweaks for older IEs-->
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<!-- owl stylesheets --> 
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.theme.default.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<link rel="stylesheet" href="file://E://fontawesome/css/all.css">

</head>
<body>
	<!--header section start -->
	<div class="header_section">

	  <div class="overlay" id="login-popup">
	    <div class="kotak_login">
	      <form action="mahasiswa_login_process.php" method="post">
	      		<?php 
		if(isset($_SESSION['error']))
		{
			echo "<p>Username atau Password salah</p>";
			unset($_SESSION['error']);
		}
		?>
	        <a href="#" class="close-btn">x</a>
	        <label>Username</label>
	        <input type="text" name="username" class="form_login" placeholder="Username atau email ..">
	     
	        <label>Password</label>
	        <input type="password" name="password" class="form_login" placeholder="Password ..">
	     
	        <input type="submit" name="btnlogin" class="tombol_login" value="LOGIN">
	      </form>
	    </div>
	  </div>

		<div class="container">
			<div class="row">
				<div class="col-sm-2">
					<div class="logo"><a href="index.php"><img src="images/ubaya.png"></a></div>
				</div>
				
				<div class="col-sm-4">
		            <ul class="top_button_section">
		               <li><a class="login-bt active" href="#login-popup">Login</a></li>
		               <li class="search"><a href="#"><img src="images/search-icon.png" alt="#" /></a></li>
		            </ul>
				</div>
			</div>
		</div>
	</div>

    <div class="row">
      
    </div>
    </div>

		</div>
        <!--header section end -->
        
		</div>
	</div>
    <!--banner section end -->


	<!--footer section start -->
	<div class="footer_section">
		
		    
		    <div class="copyright_section">
		    	<p class="copyright_text">Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
		    </div>
		</div>
	</div>
	<!--footer section end -->


</body>
</html>