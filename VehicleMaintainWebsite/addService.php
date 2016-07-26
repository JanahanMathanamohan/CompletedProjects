<!-- Connect to the Database -->
<?php require_once('../config.php') ?>
<html>
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
	<!-- Redirects user if the user is not able to acess this page -->
	<?php
		session_start();
      	if(isset($_SESSION["user"]))
      	{
      		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
      		if($id<1000000000)
        	{   
            
            	header('Location: DriverSignin.php');
       	 	}
      	}else
      	{
      		header('Location: Denied.html');
      	}
	?>
	<head>
	<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
		<title>Welcome!</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
	
		<link rel="stylesheet" href="assets/css/main.css" /> 
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	<body>
	<!--Welcome message-->
	<section id="banner">
		<?php
			$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
			$sql = "SELECT Mechanic_Name FROM mechanic WHERE Mechanic_Id = $id";
			$result = mysql_query($sql,$conn) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$name = $row['Mechanic_Name'];
			echo "<h2>$name!, Add a Service</h2>";
		?>
		
	</section>
	
	<!--This section is the form to fill out-->
	<section class = "wrapper style2 special">
		<div class="inner narrow">
			<header><h2>Fiil out the Information</h2></header>
				<!-- This is the form that sends to addService -->
				<form id="serviceForm" method="post" action = "addServiceValidation.php" enctype="multipart/form-data">
					<div class="form-control narrow">
					<label>VIN: </label>
					<input id="VID" name = "VID" type = "text" placeholder="ABCDEFGH123456789">
				</div>
				<div class="form-control narrow">
					<label>Service Type: </label>
					<select name="serviceType" id="serviceType" >
					<!--This is to load the list of services from the xml-->
					<?php
						$xml = simplexml_load_file('Services.xml');
						foreach ($xml->Service as $item)
						{
								echo "<option value='".$item ."'>" . $item."</option>";
						}
					?>
					</select>				
				</div>
				<br>
				<br>
				<div class="form-control narrow">
					<label>Next Service: </label>
					<input id="VDate" name = "VDate" type = "date" placeholder="">
				</div>
				<br>
				<br>
				<ul class="actions">
					<li><input value="Submit" type="submit"></li>
				</ul>
				</form>
		</div>
	</section>
	<!-- Link back to home page-->
	<section class = "wrapper style2 special">
		<header><h2><a href="MechanicSignin.php">Go back to Home</a></h2></header>
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
			<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
			<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js"></script>>
			<script>
			//This is the script used to validate the fields before submit
			$(document).ready(function() {
				$('#serviceForm').validate({
					rules:{
						VID: {
							required: true,
							minlength: 17,
							maxlength: 17
						},
						VDate: {
							required: true
						},
						serviceType: {
							required: true,
						}
					}

				});
			
			});
			
			</script>
</html>