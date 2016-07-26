<!--Access Database -->
<?php require_once('../config.php') ?>
<html>
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
	<?php
		// Session starts and makes user 
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
		$brand = $_POST['brand'];
		echo "<h2>Mechanic experience in $brand</h2>";
	?>
	</section>
	
	<!--Welcome -->
	<section id="dInfo" class="wrapper style2 special">
		<div class="inner narrow">
			<div >
				<table  >
					<thead>
						<tr>
							<td>Mechanic ID</td>
							<td>Mechanic Name</td>
							<td>Number of Services</td>
			
						</tr>
					</thead>
					<tbody>
						<?php
							// make a query to get mechanic experience on a brand
							$brand = $_POST['brand'];
							$city = $_POST['city'];
							$sql="	SELECT  S.Mechanic_Id AS mid, M.Mechanic_Name AS MName, count(S.Mechanic_Id) AS count
									FROM    service_history AS S, mechanic AS M
									WHERE   M.Mechanic_Id = S.Mechanic_Id and M.City = '$city' and S.Vehicle_Id = ANY ( SELECT Vehicle_Id
																						                              	FROM vehicle AS V
																						                              	WHERE V.Vehicle_No = ANY( SELECT   Vehicle_No
																						                                                        FROM     vehicle_specification
																						                                                        WHERE    Vehicle_Brand ='$brand'))
									GROUP BY  S.Mechanic_Id;
							";
							$result=mysql_query($sql,$conn) or die(mysql_error());
							// makes the table
							while ($row = mysql_fetch_array($result)){
								$mid =$row['mid'];
								$name =$row['MName'];
								$count = $row['count'];
    							echo "	
    									<tr>
										<td>$mid</td>
										<td>$name</td>
										<td>$count</td>
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