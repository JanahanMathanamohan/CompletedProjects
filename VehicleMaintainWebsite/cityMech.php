<!--Access database-->
<?php require_once('../config.php') ?>
<html>
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
	<?php
		// redirects page if user is not suppose to enter
		session_start();
      	if(isset($_SESSION["user"]))
      	{
      		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
      		if($id>=1000000000)
        	{   
            
            	header('Location: MechanicSignin.php');
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
		$city = $_POST['city'];
		echo "<h2>Mechanic Experience in $city </h2>";
	?>
	</section>
	
	<!--Table -->
	<section id="dInfo" class="wrapper style2 special">
		<div class="inner narrow">
			<div >
				<table  >
					<thead>
						<tr>
							<td>Mechanic ID</td>
							<td>Mechanic Name</td>
							<td>Mechanic Address</td>
							<td>Vechicle</td>
			
						</tr>
					</thead>
					<tbody>
						<?php
							// query for finding the mechanics in a city and the vehicles they play on
							$city = $_POST['city'];
							$sql="	SELECT  mechanic.Mechanic_Id AS min, mechanic.Mechanic_Name as name, mechanic.Location as location, Vehicle_No
									FROM    mechanic LEFT JOIN service_history on mechanic.Mechanic_Id = service_history.Mechanic_Id
									        LEFT JOIN  vehicle on vehicle.Vehicle_Id = service_history.Vehicle_Id
									UNION
									SELECT  mechanic.Mechanic_Id AS min, mechanic.Mechanic_Name as name, mechanic.Location as location, Vehicle_No
									FROM    mechanic RIGHT JOIN service_history on mechanic.Mechanic_Id = service_history.Mechanic_Id
									        RIGHT JOIN  vehicle on vehicle.Vehicle_Id = service_history.Vehicle_Id
									WHERE   mechanic.Location LIKE  '$city'
									GROUP BY mechanic.Mechanic_Id, vehicle_No
        							HAVING COUNT(*) = 1 
							";
							$result=mysql_query($sql,$conn) or die(mysql_error());
							// query placed in a table
							while ($row = mysql_fetch_array($result)){
								$mid =$row['min'];
								$name =$row['name'];
								$location = $row['location'];
								$VNO = $row['Vehicle_No'];
    							echo "	
    									<tr>
										<td>$mid</td>
										<td>$name</td>
										<td>$location</td>
										<td>$VNO</td>
										</tr>
				
									";
							}		
						?>
					</tbody>
				</table>
				<br>
				<!-- Redirect back to home -->
				<ul class="actions">
					<h2><a href="DriverSignin.php">Go Back to Home</a></h2>
				</ul>
			</div>
		</div>
	
		</section>
	<!-- Footer -->
			<footer id="footer">
				<div class="copyright">
					&copy; Untitled. Design: <a href="http://templated.co/">TEMPLATED</a>.
				</div>
			</footer>

</html>