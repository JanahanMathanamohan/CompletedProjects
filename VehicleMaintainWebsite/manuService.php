<!-- connects to db -->
<?php require_once('../config.php') ?>
<html>
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
	<?php
		// starts session and redirects if user is not suppose to access this
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
		// prints out brand and year as welcome message
		$brand = $_POST['brand'];
		$year = $_POST['year'];
		echo "<h2>Brand: $brand in year $year </h2>";
	?>
	</section>
	
	<!-- table with results -->
	<section id="dInfo" class="wrapper style2 special">
		<div class="inner narrow">
			<div >
				<table  >
					<thead>
						<tr>
							<td>Vehicle</td>
							<td>Service</td>
							<td>Amount of service</td>
						</tr>
					</thead>
					<tbody>
						<?php
							// query to get info on vehicles and their servies
							$sql="	SELECT    	V.Vehicle_No as VNO, S.service_type as Service,  count(*) as amount
									FROM      	service_history AS S, vehicle AS V
									WHERE     	V.Vehicle_Id = S.Vehicle_Id
									          		AND YEAR(S.Date_of_Service)=$year
									          		AND V.Vehicle_No = ANY (	SELECT  Vehicle_No
									                                  				FROM   vehicle_specification
									                                  				WHERE   Vehicle_Brand = '$brand')
									GROUP BY  V.Vehicle_No , S.service_type
 
							";
							$result=mysql_query($sql,$conn) or die(mysql_error());
							// prints out the table
							while ($row = mysql_fetch_array($result)){
								$VNO =$row['VNO'];
								$service =$row['Service'];
								$amount = $row['amount'];
    							echo "	
    									<tr>
										<td>$VNO</td>
										<td>$service</td>
										<td>$amount</td>
										</tr>
				
									";
    									
							}		
						?>
					</tbody>
				</table>
				<br>
				<ul class="actions">
					<h2><a href="MechanicSignin.php">Go Back to Home</a></h2>
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





