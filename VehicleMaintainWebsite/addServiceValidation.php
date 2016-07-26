<!--Access the database-->
<?php require_once('../config.php') ?>
<?php
	// Session start and then checks if user can enter this
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
    // variables
	$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
	$VIN = $_POST['VID'];
	$VDate = $_POST['VDate'];
	$Vservice = $_POST['serviceType'];
	$dateFormated = split('-', $VDate);
	// checks if it is a valid vehicle
	$date = $dateFormated[2].'-'.$dateFormated[1].'-'.$dateFormated[0];
	$sql4 = "SELECT Vehicle_Id FROM vehicle WHERE Vehicle_Id='$VIN'";
	$result = mysql_query($sql4,$conn) or die (mysql_error());
	if(mysql_num_rows($result) == 1)
	{
		// gets date 
		$sql = "SELECT CURDATE()";
		$result = mysql_query($sql,$conn) or die (mysql_error());
		while ($row = mysql_fetch_array($result)) {
	 		$curdate=$row['CURDATE()'];
		}
		// inserts in table
		$sql2 = "INSERT INTO service_history(Vehicle_Id, Mechanic_Id, Date_of_Service, Service_Type) VALUES ('$VIN',$id,'$curdate','$Vservice')";
		$result = mysql_query($sql2,$conn) or die (mysql_error());
		$sql3 = "UPDATE vehicle SET Last_Service='$curdate', Next_Service='$VDate',Service_Type='$Vservice' WHERE Vehicle_Id ='$VIN'";
		$result = mysql_query($sql3,$conn) or die (mysql_error());
		
		header("Location: addService.php");
		echo "<h3>Add Success</h3>";
	}else 
	{
		// Fail page
		echo "<!DOCTYPE html>
		<html>
		<head>
			<link rel=\"shortcut icon\" type=\"image/ico\" href=\"favicon.ico\" />	
			<script type=\"text/javascript\" src=\"js/jquery-1.11.0.min.js\"></script>
			<script type=\"text/javascript\" src=\"js/jquery.leanModal.min.js\"></script>
			<title>Sign Up Mechanic Success</title>
			<meta charset=\"utf-8\" />
			<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />
			<!--[if lte IE 8]><script src=\"assets/js/ie/html5shiv.js\"></script><![endif]-->
			<link rel=\"stylesheet\" href=\"assets/css/main.css\" /> 
		</head>
		<body>
			<section id=\"banner\">
					<h2><strong>ADD FAIL</strong></h2>
				</section>	
			<section id=\"three\" class=\"wrapper style2 special\">
					 <a href=\"addService.php\"> Click here to go to your home page</a>
			</section>
		</body>
		</html>";	
	}

?>sS