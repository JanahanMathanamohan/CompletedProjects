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
	<h2>Vehicles to keep ontop of</h2>
	</section>
	
	<!--Welcome -->
	<section id="dInfo" class="wrapper style2 special">
		<div class="inner narrow">
			<div >
				<table  >
					<thead>
						<tr>
							<td>Vehicle</td>
						</tr>
					</thead>
					<tbody>
						<?php
							// Query for what cars divers have of there favourity mechanics
							$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);

							$sql="	SELECT  	Distinct(V.Vehicle_No) AS VNO
									FROM    	mechanic AS M,  driver AS D , vehicle V
									WHERE   	M.Mechanic_Id = D.Mechanic_Id and D.Driver_Id = V.Driver_Id 
        							AND 		M.Mechanic_Id = $id;

 
							";
							// prints out the the table
							$result=mysql_query($sql,$conn) or die(mysql_error());
							while ($row = mysql_fetch_array($result)){
								$VNO =$row['VNO'];
    							echo "	
    									<tr>
										<td>$VNO</td>
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





