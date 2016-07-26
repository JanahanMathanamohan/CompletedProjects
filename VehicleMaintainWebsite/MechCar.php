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
	<h2>All Mechanics Used</h2>
		
	</section>
	
	<!--Table for all mechanics used -->
	<section id="dInfo" class="wrapper style2 special">
		<div >
			<div >
				<table  >
					<thead>
						<tr>
							<td>VIN</td>
							<td>Vehicle</td>
							<td>Mechanic Id</td>
							<td>Mechanic Name</td>
							<td>Company</td>
							<td>Address</td>
							<td>City</th>
						</tr>
					</thead>
					<tbody>
						<?php
							// query to find all mechanics that worked on all cars
							$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
							$sql="	SELECT    	DISTINCT(vehicle.Vehicle_Id ) AS VID, vehicle.Vehicle_No AS Vno, service_history.Mechanic_Id AS MID,
         										mechanic.Mechanic_Name AS Mname, mechanic.Company AS Company ,mechanic.Location AS Location, mechanic.City AS city
									FROM      driver LEFT JOIN vehicle on driver.Driver_Id = vehicle.Driver_Id 
									          LEFT JOIN service_history ON vehicle.Vehicle_ID = service_history.Vehicle_Id
									          LEFT JOIN mechanic ON service_history.Mechanic_Id = mechanic.Mechanic_Id
									WHERE     driver.Driver_Id = $id;
							";
							$result=mysql_query($sql,$conn) or die(mysql_error());
							// prints out the table
							while ($row = mysql_fetch_array($result)){
								$VID =$row['VID'];
								$VNO =$row['Vno'];
								$mid = $row['MID'];
								$Mname = $row['Mname'];
								$company =$row['Company'];
								$Location= $row['Location'];
								$city = $row['city'];
    							echo "	
    									<tr>
    									<td>$VID</td>
										<td>$VNO</td>
										<td>$mid</td>
										<td>$Mname</td>
										<td>$company</td>
										<td>$Location</td>
										<td>$city</td>
										</tr>
				
									";
    									
							}		
						?>
					</tbody>
				</table>
				<br>
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