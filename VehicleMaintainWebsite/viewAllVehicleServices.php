<!--Gives Access to the DB-->
<?php require_once('../config.php') ?>
<html>
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
	<?php
		// start session and check is user is suppose to be here if not it redirects them
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
			// Displays users name
			$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
			$sql = "SELECT Driver_Name FROM driver WHERE Driver_Id = $id";
			$result = mysql_query($sql,$conn) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$name = $row['Driver_Name'];
			echo "<h2>$name! This is all your services</h2>";
		?>
		
	</section>
	<section class="wrapper style2 special">
		<div class="inner narrow">
			<header><h2>Vehicle Service Table</h2></header>
			<div class="table-wrapper">
				<table class="alt">
					<thead>
						<tr>
							<th>Vehicle ID</th>

							<th>Mechanic Id</th>
							<th>Service Type</th>
							<th>Date of Service</th>
						</tr>
					</thead>
					<tbody>
						<?php
							// create query to get all vehicle services
							$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
							$sql="	SELECT 	Vehicle_Id, S.Mechanic_Id AS mechid, S.Service_Type as service, S.Date_of_Service as dates
									FROM   	driver AS D, service_history AS S
									WHERE  	Vehicle_Id = ANY(	SELECT  Vehicle_Id
                            									FROM    vehicle AS V
                            									WHERE  	D.Driver_Id = $id AND D.Driver_Id = V.Driver_Id)";

							$result=mysql_query($sql,$conn) or die(mysql_error());
							// make table from query
							while ($row = mysql_fetch_array($result)){
								$VID =$row['Vehicle_Id'];
								$mechid = $row['mechid'];
								$serv = $row['service'];
								$date = $row['dates'];
    							echo "	
    									<tr>
    									<td>$VID</td>
										<td>$mechid</td>
										<td>$serv</td>
										<td>$date</td>
										</tr>
										
									";
    									
							}		
						?>
					</tbody>
				</table>
				<form method="post" action = "viewAll">
				<br>
			</div>
		</div>
	</section>

	<!-- End View Services -->
	<!-- Text-based Queries -->
	<section class = "wrapper style2 special">

		<header><h2><a href="DriverSignin.php">Go Back to Home</a></h2></header>
	</section>
	<!-- Footer -->
			<footer id="footer">
				<div class="copyright">
					&copy; Untitled. Design: <a href="http://templated.co/">TEMPLATED</a>.
				</div>
			</footer>
</html>