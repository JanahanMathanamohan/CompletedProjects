<!DOCTYPE HTML>
<!--
	Typify by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
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
				session_start();
              	if(isset($_SESSION["user"]))
              	{
              		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
              		if($id>=1000000000)
                	{   
                    
                    	header('Location: MechanicSignin.php');
               	 	}else
                	{
                    	header('Location: DriverSignin.php');
                	}
              	}
        ?>
		<!-- Banner -->
			<section id="banner">
				<h2><strong>Welcome</strong> to the car service database</h2>
				<h3>The all-in-one car service database</h3>
				<p>Brought to you by VehicleMains</p>
				<ul class="actions">
					<li><a href="#userLogin" data-rel="Login" class="button special">Login or Signup</a></li>
					
					
				</ul>
			</section>

		<!-- About The Project -->
			<section id="description" class="wrapper style2 special">
				<div data-role = "AboutUs" id = "Descript" class = "inner">
					<header>
						<h2>About Us</h2>
					</header>
					<p> Insert name here is an all-in-one web database that keeps you up-to-date with when you
					need to get your vehicle serviced! Providing services for both drivers and mechanics, 
					we aim to make it easier to keep track of all the dates and important information regarding
					when it is time for your vehicle to be serviced.</p>
					<h3>How it works:</h3>
					<p>If you decide to sign up with us, we'll ask you some basic questions about your vehicle and its service history
					These questions include your vehicles VIN, the odometer reading, when it's been serviced last, your mechanic, etc.
					Using this data, as well as our own database of vehicles and services, we'll let you know when you should consider service,
					as well as the price and the mechanics offering it.</p>
					<h3> Are you a mechanic / autoshop? </h3>
					<p> Sign up with us and add your prices for various services, and we'll let you know when you can expect customers
					to be coming into your shop, and for what services!</p>
				</div>
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
						<!-- Register -->
						</form>
					
					<br> 
					<!-- Register -->
					<div class = "inner narrow">
						<p>New user? Click to sign up as a <a href="signupDriverForm.php"> DRIVER</a> or as a 
						<a href ="signupMechForm.php">MECHANIC</a></p>	
					</div>
				</div>
				<div class="inner narrow">
					<header>
						<h2>Questions? Get in touch!</h2>
					</header>
					<form class="grid-form" method="post" action="#">
						<div class="form-control narrow">
							<label for="name">Name</label>
							<input name="name" id="name" type="text">
						</div>
						<div class="form-control narrow">
							<label for="email">Email</label>
							<input name="email" id="email" type="email">
						</div>
						<div class="form-control">
							<label for="message">Message</label>
							<textarea name="message" id="message" rows="4"></textarea>
						</div>
						<ul class="actions">
							<li><input value="Send Message" type="submit"></li>
						</ul>
					</form>
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

 	</body>
</html>