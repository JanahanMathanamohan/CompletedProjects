<!--Access database -->
<?php require_once('../config.php'); ?>
<?php
	// check if user is allowed in here
	session_start();
	if(isset($_SESSION["user"]))
  	{
  		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
  		if($id<=1000000000 )
    	{   
        
        	header('Location: MechanicSignin.php');
   	 	}
  	}else
  	{
  		header('Location: Denied.html');
  	}
  	//variable declerations
	$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
	$VIN = $_POST['VID'];
	$VDate = $_POST['VDate'];
	$VLicense = $_POST['VLicense'];
	$Vbrand = $_POST['brand'];
	$Vmodel = $_POST['model'];
	$Vyear = (is_numeric($_POST['year']) ? (int)$_POST['year'] : 0); 
	$Vodo = (is_numeric($_POST['VOdo']) ? (int)$_POST['VOdo'] : 0);
	$VAvg = (is_numeric($_POST['VAverage']) ? (int)$_POST['VAverage'] : 0);
	$Vservice = $_POST['serviceType'];
	// Query to retrieve vehicle numbers
	$sql3 = "SELECT Vehicle_No FROM vehicle_specification WHERE Vehicle_Brand='$Vbrand' and Vehicle_Model='$Vmodel' and Vehicle_Year=$Vyear;";
	$result2 = mysql_query($sql3,$conn) or die (mysql_error());
	if($row = mysql_fetch_array($result2))
	{
		$Vno = $row['Vehicle_No'];
	}
	// inserts updates into vehicle 
	$dateFormated = split('-', $VDate);
	$date = $dateFormated[2].'-'.$dateFormated[1].'-'.$dateFormated[0];
	$sql4 = "INSERT INTO vehicle(Vehicle_Id,Driver_Id, Vehicle_No, Odometer_Reading,Odometer_Average, Last_Service,Service_Type) VALUES ('$VIN',$id,'$Vno',$Vodo,$VAvg,'$VDate','$Vservice');";
	$result3 = mysql_query($sql4,$conn) or die (mysql_error());
	// prints out success page
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
				<h2><strong>AddVehicle Success</strong></h2>
			</section>	
		<section id=\"three\" class=\"wrapper style2 special\">
				 <a href=\"DriverSignin.php\"> Click here to go to your home page</a>
		</section>
	</body>
	</html>"
?>