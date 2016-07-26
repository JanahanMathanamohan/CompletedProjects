<!-- Connect to the Database -->
<?php require_once('../config.php') ?>
<?php
	 // Redirects user if the user is not able to acess this page 
	session_start();
	if(isset($_SESSION["user"]))
  	{
  		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
  		if($id>1000000000 )
    	{   
        
        	header('Location: MechanicSignin.php');
   	 	}else
   	 	{
   	 		header('Location: DriverSignin.php');
   	 	}
  	}
  	// variables
	$name = $_POST['dName'];
	$email = $_POST['dMail'];
	$password = $_POST['dPassword'];
	$phone = $_POST['dPhone'];
	// make a query to insert driver
	$sql = "INSERT INTO driver( Driver_Name, Email, Phone,Driver_PW) VALUES ('$name','$email','$phone','$password')";
	$result=mysql_query($sql,$conn) or die(mysql_error());
	// get driver isd that was inserted
	$sql2 = "SELECT Max(Driver_Id) AS MAx FROM driver";
	$Id = mysql_query($sql2,$conn) or die(mysql_error());
	while ($row = mysql_fetch_array($Id)) {
 		$max=$row['MAx'];
	}
	// vehicle variables
	$VIN = $_POST['VID'];
	$VDate = $_POST['VDate'];
	$VLicense = $_POST['VLicense'];
	$Vbrand = $_POST['brand'];
	$Vmodel = $_POST['model'];
	$Vyear = (is_numeric($_POST['year']) ? (int)$_POST['year'] : 0); 
	$Vodo = (is_numeric($_POST['VOdo']) ? (int)$_POST['VOdo'] : 0);
	$VAvg = (is_numeric($_POST['VAverage']) ? (int)$_POST['VAverage'] : 0);
	$Vservice = $_POST['serviceType'];
	// make query and get the vehicle number
	$sql3 = "SELECT Vehicle_No FROM vehicle_specification WHERE Vehicle_Brand='$Vbrand' and Vehicle_Model='$Vmodel' and Vehicle_Year=$Vyear;";
	$result2 = mysql_query($sql3,$conn) or die (mysql_error());
	if($row = mysql_fetch_array($result2))
	{
		$Vno = $row['Vehicle_No'];
	}
	$dateFormated = split('-', $VDate);
	$date = $dateFormated[2].'-'.$dateFormated[1].'-'.$dateFormated[0];
	// make guery to insert the vehicle
	$sql4 = "INSERT INTO vehicle(Vehicle_Id,Driver_Id, Vehicle_No, Odometer_Reading,Odometer_Average, Last_Service,Service_Type) VALUES ('$VIN',$max,'$Vno',$Vodo,$VAvg,'$VDate','$Vservice');";
	$result3 = mysql_query($sql4,$conn)	 or die (mysql_error());
	// retrive query for the driver name
	$sql2 = "SELECT Driver_Name  FROM driver WHERE Driver_Id=$max"; 
	$Id = mysql_query($sql2,$conn) or die(mysql_error());
	while ($row = mysql_fetch_array($Id)) {
 		$name=$row['Driver_Name'];
	}
	// sets session
	$_SESSION["user"]=$max;
	// prints out sucess page
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
				<h2><strong>SignUp Success</strong> remeber you Id is <br></br> <strong>$max</strong></h2>
				<p>Welcome $name</p>
			</section>	
		<section id=\"three\" class=\"wrapper style2 special\">
				 <a href=\"DriverSignin.php\"> Click here to go to your home page</a>
		</section>
	</body>
	</html>";

?>