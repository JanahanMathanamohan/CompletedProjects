
<!-- Access the database-->
<?php require_once('../config.php') ?>
<html>
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
	<?php
		// starts the session and redirects the user if they are not suppose to be here
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
	<!--Header-->
		<section id="banner">
		<?php
			// query to retrieve mechanic name and displays it
			$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
			$sql = "SELECT Mechanic_Name FROM mechanic WHERE Mechanic_Id = $id";
			$result = mysql_query($sql,$conn) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$name = $row['Mechanic_Name'];
			echo "<h2>Welcome!,$name</h2>";
		?>
		
	</section>
	
	<!--Welcome -->
	<section id="dInfo" class="wrapper style2 special">
		<div class="inner narrow">
			<header>
				<!--Links too other views-->
				<h2><a href = "mechCust.php">Mechanics: View Customers</a></h2>
				
				<h2><a href = "addService.php">Mechanics: Add Service to Vehicle</a></h2>
				
				
			</header>
			<header>
			<h2>Manufacturers: View services</a></h2>
			</header>
			<form method="post" action = "manuService.php">
			<!-- User name -->
				<div class="form-control narrownd">
					<label> Select brand and year</label>
					<select name="brand" id="brand">
						<?php
							// prints out for options for brands
							$xml = simplexml_load_file('brand.xml');
							foreach ($xml->option as $item)
							{
   								echo "<option value='".$item ."'>" . $item."</option>";
							}
						?>
					</select>

					<select name="year" id="year">
						<?php
							// prints out values for the years
							$xml = simplexml_load_file('year.xml');
							foreach ($xml->option as $item)
							{
   								echo "<option value='".$item ."'>" . $item."</option>";
							}
						?>
					</select>
					<ul class="actions">

						<li><input value="Submit" type="submit">;
				
					</ul>					
				</div>
			</form>
			<header>
				<h2><a href="Logout.php">Logout</a></h2>
			</header>
			
			
		</div>
	</section>
	<!-- Footer -->
			<footer id="footer">
				<div class="copyright">
					&copy; Untitled. Design: <a href="http://templated.co/">TEMPLATED</a>.
				</div>
			</footer>

</html>