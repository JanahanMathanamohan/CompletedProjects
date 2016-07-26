<!DOCTYPE HTML>
<!--	
	Typify by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<!--Connects to database-->
<?php require_once('../config.php') ?>
<html>
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
	<head>
	<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
		<title>Database Project</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
	
		<link rel="stylesheet" href="assets/css/main.css" /> 
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	<body>
		<?php
				// Checks if access is allowed and redirectts
				session_start();
              	if(isset($_SESSION["user"]))
              	{
              		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
              		if($id>=1000000000)
                	{   
                    
                    	header('Location: MechanicSignin.php');
               	 	}else
                	{
                    	header('Location: DriverSignin.html');
                	}
              	}
        ?>


		<!-- Banner -->
			<section id="banner">
				<h2><strong>Failed Login</strong> Incorrect ID or Password</h2>
				<ul class="actions">
				</ul>
			</section>
		<!-- Login and Sign up Data --> 
			<section id="three" class="wrapper style2 special">
			<!-- Login -->
				<div data-role = "Login" id="userLogin" class="inner narrow" >
					<header>
							<h2>Enter Login Information</h2>
					</header>
							<!-- create form for login information -->
						<form method="post" action ="login.php"class="grid-form" enctype="multipart/form-data" class="grid-form">
						<!--user name text field-->
							<div class="form-control narrow">
								<label for="usrnm">Username:</label>
								<input type = "text" name = "user" id="user" placeholder = "Username" style = "width: 300px;">
							</div>
							<!--password text field-->
							<div class="form-control narrow">
								<label for="pw">Password:</label>
								<input type = "password" name = "pw" id="pw" placeholder = "Password" style = "width: 300px;">
							</div>
						
						<br>
						<!--Sign in button-->
						<ul class="actions">
							<li><input  value="Sign in" type="submit"></li>
						</ul>
						<br> 
						</form>
					<div class = "inner narrow">
						<p>New user? Click to sign up as a <a href="signupDriverForm.php"> DRIVER</a> or as a 
						<a href ="signupMechForm.php">MECHANIC</a></p>	
					</div>
				</div>
			</section>
		<!-- Footer -->
			<footer id="footer">
				<div class="copyright">
					&copy; Untitled. Design: <a href="http://templated.co/">TEMPLATED</a>.
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script>	
			</script>
 	</body>
</html>